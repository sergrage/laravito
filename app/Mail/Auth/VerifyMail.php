<?php

namespace App\Mail\Auth;

use App\Entity\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// это если надо поставить в очередь
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMail extends Mailable
{
    use SerializesModels;

    public $user;
    // в конструкторе принимаем user, и передаем переменной public $user, экземпляр класса User
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function build()
    {
        return $this
            ->subject('Signup Confirmation')
            ->markdown('emails.auth.register.verify');
    }
}
