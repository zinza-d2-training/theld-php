<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\MailServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BirthdayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working fine!");

        $users = User::whereMonth('dob', date('m'))->whereDay('dob', date('d'))->get();
        foreach ($users as $user) {
            MailServices::sendMailBirthday($user->email, $user->name);
        }
        return ;
    }
}
