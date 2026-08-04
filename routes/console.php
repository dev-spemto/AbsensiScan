<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Artisan Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {

    $this->comment(Inspiring::quote());

})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduler
|--------------------------------------------------------------------------
|
| Alpha otomatis dijalankan setiap hari pukul 15:00 WIB.
| Pastikan menjalankan:
|
| php artisan schedule:work
|
| atau menggunakan Cron Task pada server production.
|
*/

Schedule::command('alpha:generate')
    ->dailyAt('15:00')
    ->withoutOverlapping()
    ->runInBackground();