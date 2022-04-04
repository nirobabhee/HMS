<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\Appointment;
use App\Models\DoctorNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Noticeboard;
use App\Models\Page;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $activeTemplate = activeTemplate();
        $general = GeneralSetting::first();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname', $activeTemplate)->where('is_default', 0)->get();
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count'   => User::smsUnverified()->count(),
                'pending_ticket_count'         => SupportTicket::whereIN('status', [0, 2])->count(),
                'pending_deposits_count'       => Deposit::pending()->count(),
                'pending_withdraw_count'       => Withdrawal::pending()->count(),
                'super_admin'                  => Admin::where('id', 1)->first(),
                'pending_appointment_count'    => Appointment::pendingAppointment()->count(),
                // 'upcoming_notice_count'        => Noticeboard::where('status',1)->where('start_date','<=',Carbon::now())->where('end_date','>=',Carbon::now())->get(),
                // 'upcoming_notice_count'        => Noticeboard::where('status',1)->where('start_date','>=',Carbon::now())->where('start_date','<=',Carbon::now()->addYear())->count(),
                'upcoming_notice_count'        => Noticeboard::where('status',1)->where('start_date','>',Carbon::now())->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get(),
            ]);
        });
        view()->composer('doctor.partials.topnav', function ($view) {
            $view->with([
                'doctorNotifications' => DoctorNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrap();
    }
}
