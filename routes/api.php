<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use JagdishJP\FpxPayment\Fpx;

$transactionStatusEnabled = Config::get('fpx.routes.transaction_status_enabled');

if ($transactionStatusEnabled) {
	Route::get('fpx/transaction/status/{reference_id?}', function ($reference_id = '') {

		$response = Fpx::getTransactionStatus($reference_id);
		return $response;
	})->name('fpx.transaction.status');
}
