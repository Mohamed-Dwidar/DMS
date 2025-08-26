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

    public function coursesPeriods()
    {
        return [
            ['name' => __('messages.one_week'), 'value' => '1w'],
            ['name' => __('messages.two_weeks'), 'value' => '2w'],
            ['name' => __('messages.three_weeks'), 'value' => '3w'],
            ['name' => __('messages.four_weeks'), 'value' => '4w'],
            ['name' => __('messages.eight_weeks'), 'value' => '8w'],
            ['name' => __('messages.three_months'), 'value' => '3m'],
            ['name' => __('messages.six_months'), 'value' => '6m'],
            ['name' => __('messages.nine_months'), 'value' => '9m'],
            // ['name' => __('messages.one_year'), 'value' => '1y'],
            // ['name' => __('messages.two_years'), 'value' => '2y']
        ];
    }
}
