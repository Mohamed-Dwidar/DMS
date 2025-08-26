<?php

namespace App\Helpers;

use Illuminate\Http\Request;

trait GeneralHelper
{
    public function listMonths()
    {
        return [
            ['name' => __('messages.january'), 'number' => 1],
            ['name' => __('messages.february'), 'number' => 2],
            ['name' => __('messages.march'), 'number' => 3],
            ['name' => __('messages.april'), 'number' => 4],
            ['name' => __('messages.may'), 'number' => 5],
            ['name' => __('messages.june'), 'number' => 6],
            ['name' => __('messages.july'), 'number' => 7],
            ['name' => __('messages.august'), 'number' => 8],
            ['name' => __('messages.september'), 'number' => 9],
            ['name' => __('messages.october'), 'number' => 10],
            ['name' => __('messages.november'), 'number' => 11],
            ['name' => __('messages.december'), 'number' => 12]
        ];
    }

    public function paymentMethods()
    {
        return [
            'cash' => __('messages.cash'),
            // 'credit_card' => __('messages.credit_card'),
            'bank_transfer' => __('messages.bank_transfer'),
            'check' => __('messages.check'),
            'mobile_payment' => __('messages.mobile_payment'),
            //'other' => __('messages.other')
        ];
    }
}
