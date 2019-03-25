<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use App\Entity\User;
use App\UseCases\Auth\RegisterService;

class VerifyCommand extends Command
{
    private $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    protected $signature = 'user:verify {email}';

    protected $description = 'Command description';

    public function handle()
    {
        $email = $this->argument('email');

        if(!$user = User::where('email', $email)->first()){
            $this->error('Undefined user with email ' . $email);
            return false;
        }
        try{
            $this->service->verify($user->id);    
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }
        

        $this->info('User is successfully verified!');
        return true;
    }
}
