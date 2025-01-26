<?php

namespace App\Console\Commands;

use App\Models\Tax;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class initalSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initial-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Creating the initial settings for the application');
        if(!Tax::where('name', 'IVA')->exists()){
            Tax::create([
                'name' => 'IVA',
                'tax_percentage' => 19,
                'tax_multiplier' => 0.19,
                'total_with_tax_multiplier' => 1.19
            ]);
            $this->info('IVA created successfully');
        }else {
            $this->info('IVA already exists');
        }

        $name = $this->ask('Enter the name of the user');
        $email = $this->ask('Enter the email of the user');
        $password = $this->secret('Enter the password for the user');
        // Validate if the email is already in use
        if (User::where('email', $email)->exists()) {
            $this->error('The email is already in use. Please use a different email.');
            return 1;
        }

        // Create the user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("The user has been created successfully!");
    }
}
