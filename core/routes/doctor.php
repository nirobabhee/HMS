<?php

use Illuminate\Support\Facades\Route;




Route::namespace('Auth')->group(function () {
    Route::get('/', 'LoginController@showLoginForm')->name('login');
    Route::post('/', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    // Doctor Password Reset
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
    Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
});

Route::middleware('doctor')->group(function () {
    Route::get('dashboard', 'DoctorController@dashboard')->name('dashboard');
    Route::get('list', 'DoctorController@dashboard')->name('list');
    Route::get('profile', 'DoctorController@profile')->name('profile');
    Route::post('profile', 'DoctorController@profileUpdate')->name('profile.update');
    Route::get('password', 'DoctorController@password')->name('password');
    Route::post('password', 'DoctorController@passwordUpdate')->name('password.update');

    //Notification
    Route::get('notifications','DoctorController@notifications')->name('notifications');
    Route::get('notification/read/{id}','DoctorController@notificationRead')->name('notification.read');
    Route::get('notifications/read-all','DoctorController@readAll')->name('notifications.readAll');

    Route::get('system-info','DoctorController@systemInfo')->name('system.info');



    // Doctor Support
    Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
    Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
    Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
    Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
    Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
    Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
    Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
    Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


});
