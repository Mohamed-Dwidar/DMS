<?php

namespace Modules\InvoiceModule\app\Http\Controllers\Admin;

use App\Helpers\ApiResponseHelper;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\InvoiceModule\app\Services\InvoiceService;
use Illuminate\Support\Facades\Session;

class InvoiceAdminController extends Controller
{
    use ApiResponseHelper;
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
        $invoices = $this->invoiceService->filter($request->all())->paginate(15);
        return view('invoicemodule::admin.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('invoicemodule::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',

            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->invoiceService->create($request);

        return redirect()->route('admin.invoices')
            ->with('success', __('messages.successfully_saved'));
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $invoice = $this->invoiceService->findOne($id);
        if (!$invoice) {
            return redirect()->route('admin.invoices')
                ->with('error', __('messages.invoice_not_found'));
        }
        $days = [
            'sun' => __('messages.sunday'),
            'mon' => __('messages.monday'),
            // 'tue' => __('messages.tuesday'),
            // 'wed' => __('messages.wednesday'),
            // 'thu' => __('messages.thursday'),
            // 'fri' => __('messages.friday'),
            // 'sat' => __('messages.saturday'),
        ];
        return view('invoicemodule::admin.edit', compact('invoice', 'days'));
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
                'name' => 'required',
                'country' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'hotel' => 'required',
                'hotel_link' => 'nullable|url|max:255',
                'price_1w' => 'nullable|numeric',
                'price_2w' => 'nullable|numeric',
                'price_3w' => 'nullable|numeric',
                'price_4w' => 'nullable|numeric',
                'price_8w' => 'nullable|numeric',
                'price_3m' => 'nullable|numeric',
                'price_6m' => 'nullable|numeric',
                'price_9m' => 'nullable|numeric',
                'price_1y' => 'nullable|numeric',
                'price_2y' => 'nullable|numeric',
                'week_start' => 'nullable|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->invoiceService->update($request);

        //$this->invoiceService->buildInvoiceNavbar();

        return redirect()->route('admin.invoices.edit', $request->id)
            ->with('success', __('messages.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->invoiceService->deleteOne($id);
        return redirect()->route('admin.invoices')
            ->with('success', __('messages.successfully_deleted'));
    }

    public function changeInvoiceActivity($id)
    {
        $product = $this->invoiceService->changeInvoiceActivity($id);
        $this->invoiceService->buildInvoiceNavbar();

        return redirect()->route('admin.invoices')
            ->with('success', 'Activity changed.');
    }
}
