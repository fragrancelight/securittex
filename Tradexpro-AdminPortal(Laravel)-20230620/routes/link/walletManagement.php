<?php

use Illuminate\Support\Facades\Route;

Route::group(['group' => 'transaction_all'], function () {
    Route::get('transaction-export', 'TransactionController@adminTransactionHistoryExport')->name('adminTransactionHistoryExport');
    Route::get('transaction-history', 'TransactionController@adminTransactionHistory')->name('adminTransactionHistory');
    Route::get('withdrawal-history', 'TransactionController@adminWithdrawalHistory')->name('adminWithdrawalHistory');
});
Route::group(['group' => 'transaction_withdrawal'], function () {
    Route::get('pending-withdrawal', 'TransactionController@adminPendingWithdrawal')->name('adminPendingWithdrawal');
    Route::get('rejected-withdrawal', 'TransactionController@adminRejectedWithdrawal')->name('adminRejectedWithdrawal');
    Route::get('active-withdrawal', 'TransactionController@adminActiveWithdrawal')->name('adminActiveWithdrawal');
    Route::get('reject-pending-withdrawal-{id}', 'TransactionController@adminRejectPendingWithdrawal')->name('adminRejectPendingWithdrawal')->middleware('check_demo');
    Route::get('accept-pending-withdrawal-{id}', 'TransactionController@adminAcceptPendingWithdrawal')->name('adminAcceptPendingWithdrawal');
    Route::get('withdrawal-referral-history', 'TransactionController@adminWithdrawalReferralHistory')->name('adminWithdrawalReferralHistory');
});
Route::group(['group' => 'transaction_deposit'], function () {
    Route::get('pending-deposit', 'TransactionController@adminPendingDeposit')->name('adminPendingDeposit');
    Route::get('accept-pending-deposit-{id}', 'TransactionController@adminPendingDepositAcceptProcess')->name('adminPendingDepositAcceptProcess')->middleware('check_demo');
});


Route::group(['group' => 'check_deposit'], function () {
    Route::get('check-deposit', 'DepositController@adminCheckDeposit')->name('adminCheckDeposit');
    Route::get('submit-check-deposit', 'DepositController@submitCheckDeposit')->name('submitCheckDeposit');
});

// pending deposit report and action
Route::group(['group' => 'pending_token_deposit'], function () {
    Route::get('pending-token-deposit-history', 'DepositController@adminPendingDepositHistory')->name('adminPendingDepositHistory');
    Route::get('pending-token-deposit-accept-{id}', 'DepositController@adminPendingDepositAccept')->name('adminPendingDepositAccept')->middleware('check_demo');
    Route::get('pending-token-deposit-reject-{id}', 'DepositController@adminPendingDepositReject')->name('adminPendingDepositReject')->middleware('check_demo');

    Route::get('ico-token-buy-list-accept', 'DepositController@icoTokenBuyListAccept')->name('icoTokenBuyListAccept');
    Route::get('admin-ico-token-receive-process/{id}', 'DepositController@adminReceiveBuyTokenAmount')->name('adminReceiveBuyTokenAmount');
});
Route::group(['group' => 'token_gas'], function () {
    Route::get('gas-send-history', 'DepositController@adminGasSendHistory')->name('adminGasSendHistory');
});
Route::group(['group' => 'token_receive_history'], function () {
    Route::get('token-receive-history', 'DepositController@adminTokenReceiveHistory')->name('adminTokenReceiveHistory');
});
