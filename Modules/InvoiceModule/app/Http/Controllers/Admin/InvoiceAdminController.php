<?php

namespace Modules\InvoiceModule\app\Http\Controllers\Admin;

// use App\Helpers\ApiResponseHelper;
use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\InvoiceModule\app\Services\InvoiceService;
use Illuminate\Support\Facades\Session;
use PDF;

class InvoiceAdminController extends Controller
{
    // use ApiResponseHelper;
    use GeneralHelper;
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $invoices = $this->invoiceService->filter($request->all())->orderBy('inv_number', 'desc')->paginate(15);
        return view('invoicemodule::admin.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $inv_number = $this->invoiceService->generateInvNumber();
        $payment_methods = $this->paymentMethods();
        return view('invoicemodule::admin.create', compact('inv_number', 'payment_methods'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //update invoice number with newly generated one
        $request->merge(['inv_number' => $this->invoiceService->generateInvNumber()]);
        $validator = Validator::make(
            $request->all(),
            [
                // 'name' => 'required',
                'customer_id' => 'nullable|integer',
                'inv_number' => 'required|unique:invoices,inv_number',
                'inv_date' => 'required|date',
                'inv_for' => 'required|string|max:255',

                'inv_items' => 'nullable|array',
                'inv_items.*.item_name' => 'required_with:inv_items|string|max:255',
                'inv_items.*.item_desc' => 'nullable|string',
                'inv_items.*.item_qty' => 'required_with:inv_items|numeric|min:1',
                'inv_items.*.item_unit_amount' => 'required_with:inv_items|numeric|min:0',
                'inv_items.*.item_discount_per' => 'nullable|numeric|min:0',
                'inv_items.*.item_discount' => 'nullable|numeric|min:0',
                'inv_items.*.item_total_amount' => 'required_with:inv_items|numeric|min:0',
                'note' => 'nullable|string|max:1000',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->invoiceService->create($request);

        return redirect()->route('invoices.view', $request->id)
            ->with('success', __('messages.successfully_saved'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $invoice = $this->invoiceService->findOne($id);
        $payment_methods = $this->paymentMethods();
        if (!$invoice) {
            return redirect()->route('invoices')
                ->with('error', __('messages.invoice_not_found'));
        }
        return view('invoicemodule::admin.edit', compact('invoice', 'payment_methods'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|integer|exists:invoices,id',
                // 'name' => 'required',
                'customer_id' => 'nullable|integer',
                'inv_date' => 'required|date',
                'inv_for' => 'required|string|max:255',

                'inv_items' => 'nullable|array',
                'inv_items.*.item_name' => 'required_with:inv_items|string|max:255',
                'inv_items.*.item_desc' => 'nullable|string',
                'inv_items.*.item_qty' => 'required_with:inv_items|numeric|min:1',
                'inv_items.*.item_unit_amount' => 'required_with:inv_items|numeric|min:0',
                'inv_items.*.item_discount_per' => 'nullable|numeric|min:0',
                'inv_items.*.item_discount' => 'nullable|numeric|min:0',
                'inv_items.*.item_total_amount' => 'required_with:inv_items|numeric|min:0',
                'note' => 'nullable|string|max:1000',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->invoiceService->update($request);

        return redirect()->route('invoices.view', $request->id)
            ->with('success', __('messages.successfully_updated'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $invoice = $this->invoiceService->findOne($id);
        return view('invoicemodule::admin.show', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->invoiceService->deleteOne($id);
        return redirect()->route('invoices')
            ->with('success', __('messages.successfully_deleted'));
    }


    public function showInvoicePdf(Request $request, $id)
    {
        $invoice = $this->invoiceService->findOne($id);
        if (!$invoice) {
            return redirect()->route('invoices')
                ->with('error', __('messages.invoice_not_found'));
        }
        $pdf = PDF::loadView('invoicemodule::admin.invoice_pdf', compact('invoice'), []);

        return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');
    }
    // {
    //     $receipt_data = $request->all();

    //     $pdf = PDF::loadView('coursemodule::admin.receipt_pdf', compact('receipt_data','payment','student','courses_reg'), [], [
    //         'format' => 'A4-L', 
    //     ]);

    //     return $pdf->download('receipt.pdf');
    // }
}
