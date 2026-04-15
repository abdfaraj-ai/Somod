<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $name = $this->ask('Enter name');
        $email = $this->ask('Enter email');
        $password = $this->secret('Enter password');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'area' => 'مدينة غزة',
            'role' => 'admin'
        ]);

        $this->info('Admin user created successfully!');
        return Command::SUCCESS;
    }
}