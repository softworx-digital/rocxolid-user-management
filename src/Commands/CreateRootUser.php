<?php

namespace Softworx\RocXolid\UserManagement\Commands;

use Hash;
use Illuminate\Console\Command;
use Softworx\RocXolid\UserManagement\Models\User;

class CreateRootUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rx:user:create-root';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates root user for RocXolid based application';

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('e-mail:');
        $password = $this->ask('Password:');

        $user = User::create([
            'name' => 'Root',
            'email' => $email,
            'login' => $email,
            'password' => $password,
        ]);
        
        $user->save();
    }
}