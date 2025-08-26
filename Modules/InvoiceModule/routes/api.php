<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/listInvoices', 'Api\InvoiceApiController@listInvoices');
});
