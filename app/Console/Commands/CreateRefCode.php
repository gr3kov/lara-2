<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateRefCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ref:code:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create referral code';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNull('ref_code')->get();
        foreach ($users as $user) {
            $user->ref_code = $this->generateRefCode();
            $user->save();
        }
    }

    private function generateRefCode()
    {
        $code = Str::random(8);
        $userCode = User::where('ref_code', $code)->first();
        if ($userCode) {
            return $this->generateRefCode();
        }
        return $code;
    }
}
