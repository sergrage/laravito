<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_WAIT = 'waiting';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';


    public static function rolesList(): array
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_MODERATOR => 'Moderator',
            self::ROLE_ADMIN => 'Admin',
        ];
    }


    // тут указаны поля которые необходимо заполнить при массовом присваивании all()
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'status', 'verify_token', 'role'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'phone_verify_token_expire' => 'datetime',

    ];

// это метод для тестов. Создание User
    public static function register(string $name, string $email, string $password): self
    {
    	return static::create([
    		'name' => $name,
    		'email' => $email,
    		'password' => bcrypt($password),
    		'verify_token' => Str::uuid(),
    		'status' => self::STATUS_WAIT,
            'role' => self::ROLE_USER,
    	]); 
    }

// это метод для тестов. Создание User от администратора.
    public static function new($name, $email): self
    {
    	return static::create([
    		'name' => $name,
    		'email' => $email,
    		'password' => bcrypt($password),
    		'status' => self::STATUS_ACTIVE,
            'role' => self::ROLE_USER,
    	]); 
    }

        public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty.');
        }
        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new \DomainException('Token is already requested.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }

    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token.');
        }
        if ($this->phone_verify_token_expire->lt($now)) {
            throw new \DomainException('Token is expired.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }


    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAdmin(): bool
    {
    	return $this->role === self::ROLE_ADMIN;
    }
    
    public function isModerator(): bool
    {
    	return $this->role === self::ROLE_MODERATOR;
    }

    public function isUser(): bool
    {
    	return $this->role === self::ROLE_USER;
    }

// функция используется в консольной команде user:role
    public function changeRole($role): void
    {
        if (!array_key_exists($role, self::rolesList())) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }


// этот метод для тестов
// этот метод завязан на кнопку в админке в show.blade.php
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

    public function hasFilledProfile()
    {
        return $this->last_name;
    }
}
