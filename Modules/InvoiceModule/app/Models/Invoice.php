<?php

namespace Modules\InvoiceModule\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CourseModule\app\Models\CourseDate;

class Invoice extends Model
{
    protected $guarded = [];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function scopeFilter($query, $request)
    {
        $request_array = (!is_array($request)) ? collect($request)->toArray() : $request;

        if (key_exists('name', $request_array) && $request_array['name'] != null) {
            $query->where('name', 'like', '%' . $request_array['name'] . '%');
        }

        if (key_exists('inv_number', $request_array) && $request_array['inv_number'] != null) {
            $query->where('inv_number', 'like', '%' . $request_array['inv_number'] . '%');
        }

        if (key_exists('inv_date', $request_array) && $request_array['inv_date'] != null) {
            $query->whereDate('inv_date', $request_array['inv_date']);
        }



        return $query;
    }
}
