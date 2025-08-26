<?php

namespace Modules\InvoiceModule\app\Services;

use App\Helpers\UploaderHelper;
use App\Helpers\ApiResponseHelper;

use Illuminate\Support\Facades\File;
use Modules\InvoiceModule\app\Repositories\InvoiceItemRepository;
use Modules\InvoiceModule\app\Repositories\InvoiceRepository;

class InvoiceService
{
    use ApiResponseHelper;
    private $invoiceRepository;
    private $invoiceItemRepository;

    use UploaderHelper;

    public function __construct(InvoiceRepository $invoiceRepository,InvoiceItemRepository $invoiceItemRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    public function create($data)
    {
        $invoice_data = [
            'name' => $data->inv_for,
            'customer_id' => $data->customer_id ?? 0,
            'inv_number' => $data->inv_number,
            'inv_date' => $data->inv_date,
            'inv_for' => $data->inv_for,
            'status' => $data->status ?? 'new'
        ];
        $invoice = $this->invoiceRepository->create($invoice_data);

        //create invoice items
        if (isset($data->inv_items) && is_array($data->inv_items) && count($data->inv_items) > 0) {
            foreach ($data->inv_items as $item) {
                $item_data = [
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'item_desc' => $item['item_desc'] ?? '',
                    'item_qty' => $item['item_qty'] ?? 0,
                    'item_unit_amount' => $item['item_unit_amount'] ?? 0,
                    'item_discount_per' => $item['item_discount_per'] ?? 0,
                    'item_discount' => $item['item_discount'] ?? 0,
                    'item_total_amount' => $item['item_total_amount'] ?? 0,
                ];
                $invoice->invoiceItems()->create($item_data);
            }
        }
        //Update invoice amounts
        $collected_inv_amounts = $this->calculateInvAmounts($data);
        $this->invoiceRepository->update($collected_inv_amounts, $invoice->id);

        return $invoice;
    }


    public function update($data)
    {
        $old_data = $this->invoiceRepository->find($data->id);
        $invoice_data = [
            'name' => $data->inv_for,
            'customer_id' => $data->customer_id ?? 0,
            'inv_date' => $data->inv_date,
            'inv_for' => $data->inv_for
        ];

        // update invoice items
        $existing_item_ids = $old_data->invoiceItems->pluck('id')->toArray();
        $submitted_item_ids = [];
        // dd($data->all(),$existing_item_ids);
        if (isset($data->inv_items) && is_array($data->inv_items)) {
            foreach ($data->inv_items as $item) {
                if (isset($item['id']) && in_array($item['id'], $existing_item_ids)) {
                    // Update existing item
                    $item_data = [
                        'item_name' => $item['item_name'],
                        'item_desc' => $item['item_desc'] ?? '',
                        'item_qty' => $item['item_qty'] ?? 0,
                        'item_unit_amount' => $item['item_unit_amount'] ?? 0,
                        'item_discount_per' => $item['item_discount_per'] ?? 0,
                        'item_discount' => $item['item_discount'] ?? 0,
                        'item_total_amount' => $item['item_total_amount'] ?? 0,
                    ];
                    $this->invoiceItemRepository->update($item_data, $item['id']);
                    $submitted_item_ids[] = $item['id'];
                } else {
                    // Create new item
                    $item_data = [
                        'invoice_id' => $data->id,
                        'item_name' => $item['item_name'],
                        'item_desc' => $item['item_desc'] ?? '',
                        'item_qty' => $item['item_qty'] ?? 0,
                        'item_unit_amount' => $item['item_unit_amount'] ?? 0,
                        'item_discount_per' => $item['item_discount_per'] ?? 0,
                        'item_discount' => $item['item_discount'] ?? 0,
                        'item_total_amount' => $item['item_total_amount'] ?? 0,
                    ];
                    $new_item = $this->invoiceItemRepository->create($item_data);
                    $submitted_item_ids[] = $new_item->id;
                }
            }
            // Delete removed items
            $items_to_delete = array_diff($existing_item_ids, $submitted_item_ids);
            if (!empty($items_to_delete)) {
                foreach ($items_to_delete as $item_id) {
                    $this->invoiceItemRepository->delete($item_id);
                }
            }
        } else {
            // If no items submitted, delete all existing items
            $this->invoiceItemRepository->deleteItemsByInvoiceId($data->id);
        }

        // Update invoice amounts
        $collected_inv_amounts = $this->calculateInvAmounts($data);
        $invoice_data = array_merge($invoice_data, $collected_inv_amounts);

        // Save invoice and return
        return $this->invoiceRepository->update($invoice_data, $data->id);
    }

    private function calculateInvAmounts($data)
    {
        $inv_amount = 0;
        $items_discount = 0;
        $inv_total_amount = 0;
        $tax_vat_per = $data->tax_vat_per ?? 0;
        $tax_vat = 0;
        $tax_withdrawal_per = $data->tax_withdrawal_per ?? 0;
        $tax_withdrawal = 0;
        $inv_discount_per = $data->inv_discount_per ?? 0;
        $inv_discount = 0;

        if (isset($data->inv_items) && is_array($data->inv_items)) {
            foreach ($data->inv_items as $item) {
                $qty = $item['item_qty'] ?? 0;
                $unit = $item['item_unit_amount'] ?? 0;
                $discount_per = $item['item_discount_per'] ?? 0;
                $discount = ($qty * $unit) * ($discount_per / 100);
                $item_total_amount = ($qty * $unit) - $discount;

                $inv_amount += $item_total_amount;
            }
        }
        // dd($data->all());
        // Calculate extra invoice-level discount (after items discount)
        //$subtotal_after_items_discount = $inv_amount - $items_discount;
        if ($inv_discount_per > 0) {
            $inv_discount = ($inv_amount * $inv_discount_per) / 100;
        }

        // Calculate taxes
        if ($tax_vat_per > 0) {
            $tax_vat = (($inv_amount - $inv_discount) * $tax_vat_per) / 100;
        }

        if ($tax_withdrawal_per > 0) {
            $tax_withdrawal = (($inv_amount - $inv_discount) * $tax_withdrawal_per) / 100;
        }

        // Final total
        $final_total = $inv_amount - $inv_discount + $tax_vat - $tax_withdrawal;

        return [
            'inv_amount' => $inv_amount,
            'inv_discount_per' => $inv_discount_per,
            'inv_discount' => $inv_discount,
            'tax_vat_per' => $tax_vat_per,
            'tax_vat' => $tax_vat,
            'tax_withdrawal_per' => $tax_withdrawal_per,
            'tax_withdrawal' => $tax_withdrawal,
            'inv_total_amount' => $final_total,
        ];
    }

    public function generateInvNumber()
    {
        $last_inv_number = $this->invoiceRepository->getLastInvoice()->inv_number ?? null;
        $current_year = date('Y');
        if ($last_inv_number) {
            // Extract the year and number part
            $last_year = substr($last_inv_number, 0, 4);
            $last_number = intval(substr($last_inv_number, 4));

            if ($last_year == $current_year) {
                $new_number = $last_number + 1;
            } else {
                $new_number = 1;
            }
            $new_inv_number = $current_year . str_pad($new_number, 3, '0', STR_PAD_LEFT);
        } else {
            $new_inv_number = $current_year . '001';
        }
        return (string)$new_inv_number;
    }

    public function findAll()
    {
        return $this->invoiceRepository->get();
    }

    public function findRandom($rand)
    {
        return $this->invoiceRepository->getRandom($rand);
    }

    public function findOne($id)
    {
        return $this->invoiceRepository->findWhere(['id' => $id])->first();
    }

    public function deleteOne($id)
    {
        return $this->invoiceRepository->delete($id);
    }

    public function deleteMany($arr_ids)
    {
        if (!empty($arr_ids)) {
            foreach ($arr_ids as $id) {
                $this->invoiceRepository->delete($id);
            }
        }
    }

    public function filter($request)
    {
        return $this->invoiceRepository->filter($request);
    }

    public function changeInvoiceActivity($id)
    {
        $invoice = $this->invoiceRepository->find($id);

        if (!$invoice) {
            // Handle the case when the invoice with the given ID is not found
            return null;
        }

        // Toggle the is_active status of the main invoice
        $invoice_is_active = $invoice->is_active;
        $invoice_data = [
            "is_active" => $invoice_is_active == 1 ? 0 : 1
        ];

        $this->invoiceRepository->update($invoice_data, $id);

        // Update the is_active status of subinvoices
        $subinvoices = $this->invoiceRepository->getInvoicesTree($id);

        foreach ($subinvoices as $subinvoice) {
            $subinvoice_data = [
                "is_active" => $invoice_data["is_active"]
            ];

            $this->invoiceRepository->update($subinvoice_data, $subinvoice->id);
        }

        return $invoice;
    }
}
