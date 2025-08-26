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
}
