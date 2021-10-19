<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAdminCommand extends Command
{
    private $user;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Api Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->getAdminData();
        $user = $this->user->create($data);
        $user->assignRole('admin');
        $user->token = $user->createToken('tokens')->plainTextToken;
        return $this->display($user);
    }

    private function getAdminData()
    {
        $details['name'] = $this->ask('Name');
        $details['email'] = $this->ask('Email');
        $details['password'] =$this->secret('Password');
        $details['confirm_password'] = $this->secret('Confirm password');

        while (!$this->isValidPassword($details['password'], $details['confirm_password'])) {
            if (!$this->isRequiredLength($details['password'])) {
                $this->error('Password must be more that six characters');
            }

            if (!$this->isMatch($details['password'], $details['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }
            
            $details['password'] =$this->secret('Password');
            $details['confirm_password'] = $this->secret('Confirm password');
        }
        $details['password'] = Hash::make($details['password']);
        $details['confirm_password'] = Hash::make($details['confirm_password']);
        return $details;

    }
    private function display(User $admin): void
    {
        $headers = ['Name', 'Email', 'Admin'];

        $fields = [
            'Name' => $admin->name,
            'email' => $admin->email,
            'token' => $admin->token,
        ];

        $this->info('Admin created');
        $this->table($headers, [$fields]);
    }
    private function isValidPassword(string $password, string $confirmPassword): bool
    {
        return $this->isRequiredLength($password) &&
            $this->isMatch($password, $confirmPassword);
    }

    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }

    /**
     * Checks if password is longer than six characters.
     *
     * @param string $password
     * @return bool
     */
    private function isRequiredLength(string $password): bool
    {
        return strlen($password) > 6;
    }
}
