

<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_WAIT = 'waiting';
    public const STATUS_ACTIVE = 'active';


    // тут указаны поля которые необходимо заполнить при массовом присваивании all()
    protected $fillable = [
        'name', 'email', 'password', 'status'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function register(string $name, string $email, string $password): self
    {
    	return static::create([
    		'name' => $name,
    		'email' => $email,
    		'password' => bcrypt($password),
    		'verify_token' => Str::uuid(),
    		'status' => self::STATUS_WAIT,
    	]); 
    }

    public static function new($name, $email): self
    {
    	return static::create([
    		'name' => $name,
    		'email' => $email,
    		'password' => bcrypt($password),
    		'status' => self::STATUS_ACTIVE,
    	]); 
    }

    public function isWait(): bool
    {
    	return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
    	return $this->status === self::STATUS_ACTIVE;
    }


// данный метод проверяет, прошел ли пользователь проверку через почту.
// если sel::status = 	
    public function verify(): void
    {
    	if(!$this->isWait()){
    		throw new \DomainException('User is already verified');
    	}

    	$this->update([
    		'status' => self::STATUS_ACTIVE,
    		'verify_token' => null,
    	]);
    }
}
