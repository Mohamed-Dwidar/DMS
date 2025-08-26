<?php

namespace Modules\InvoiceModule\app\Repositories;

use Modules\InvoiceModule\app\Models\Invoice;
use Prettus\Repository\Eloquent\BaseRepository;

class InvoiceRepository extends BaseRepository
{

    public function model()
    {
        return Invoice::class;
    }

    function filter($request)
    {
        return Invoice::filter($request);
    }

    public function getLastInvoice()
    {
        return Invoice::orderBy('id', 'desc')->first();
    }

    public function deleteItemsByInvoiceId($invoice_id)
    {
        return Invoice::find($invoice_id)->invoiceItems()->delete();
    }
}
