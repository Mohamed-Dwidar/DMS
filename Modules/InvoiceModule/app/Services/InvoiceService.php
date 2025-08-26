<?php

namespace Modules\InvoiceModule\app\Services;

use App\Helpers\UploaderHelper;
use App\Helpers\ApiResponseHelper;

use Illuminate\Support\Facades\File;
use Modules\InvoiceModule\app\Repositories\InvoiceRepository;

class InvoiceService
{
    use ApiResponseHelper;
    private $invoiceRepository;

    use UploaderHelper;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function create($data)
    {
        $invoice_data = [
            'name' => $data->name,
            
        ];
        return $this->invoiceRepository->create($invoice_data);
    }

    public function update($data)
    {
        $old_data = $this->invoiceRepository->find($data->id);
        $invoice_data = [
            'name' => $data->name,

        ];
        return $this->invoiceRepository->update($invoice_data, $data->id);
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
