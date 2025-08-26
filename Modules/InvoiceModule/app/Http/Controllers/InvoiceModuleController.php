<?php

namespace Modules\InvoiceModule\app\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\InvoiceModule\app\Services\InvoiceService;

class InvoiceModuleController extends Controller
{
    private $categoryService;
    private $courseService;
    private $courseDateService;
    private $invoiceService;

    use GeneralHelper;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = $this->invoiceService->filter(['have_upcoming_courses' => true])->get();
        return view('invoicemodule::front.index', compact('invoices'));
    }
    
    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {

        $invoice = $this->invoiceService->findOne($id);
        if (!$invoice) {
            abort(404);
        }

        // Apply filters
        $filter = ['invoice_id' => $invoice->id, 'upcoming' => true];


        if ($request->filled('category_id')) {
            $filter['category_id'] = $request->input('category_id');
        }
        if ($request->filled('keyword')) {
            $filter['keyword'] = $request->input('keyword');
        }
        if ($request->filled('type')) {
            $filter['type'] = $request->input('type');
        }
        if ($request->filled('period')) {
            $filter['period'] = $request->input('period');
        }
        if ($request->filled('month')) {
            $filter['month'] = $request->input('month');
        }
        if ($request->filled('year')) {
            $filter['year'] = $request->input('year');
        }
        ///////////////////////////////////////////////////////////////////

        $course_dates = $this->courseDateService->filter($filter)->orderBy('start_date')->paginate(10);
        return view('invoicemodule::front.show', compact('invoice', 'course_dates'));
    }
    
}
