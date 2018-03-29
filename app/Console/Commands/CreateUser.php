<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
        $name = $this->ask('Name');

        $email = $this->ask('E-mail');

        $password = $this->secret('Password');
        $confirm = $this->secret('Confirm password');

        if ($password !== $confirm) {
            $this->error('ERROR: Password and confirmation do not match');

            return false;
        }

        if (strlen($password) < 6) {
            $this->error('ERROR: The password at least 6 characters');

            return false;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('The user is created!');

        return true;
    }
}
