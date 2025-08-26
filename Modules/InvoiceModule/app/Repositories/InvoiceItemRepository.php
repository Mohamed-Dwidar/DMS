<?php

namespace Modules\InvoiceModule\app\Repositories;

use Modules\InvoiceModule\app\Models\InvoiceItem;
use Prettus\Repository\Eloquent\BaseRepository;

class InvoiceItemRepository extends BaseRepository
{

    public function model()
    {
        return InvoiceItem::class;
    }

    public function deleteItemsByInvoiceId($invoice_id)
    {
        return InvoiceItem::where('invoice_id', $invoice_id)->delete();
    }
}
