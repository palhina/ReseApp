<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Models\Reservation;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $today = now()->format('Y-m-d');
            $reservations = Reservation::where('rsv_date', $today)->get();
            foreach ($reservations as $reservation) {
                $user = $reservation->user; 
                Mail::to($user->email)->send(new ReminderMail($reservation));
            }
        })->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
