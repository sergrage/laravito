<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entity\User;

class RegisterTest extends TestCase
{
	use DatabaseTransactions;
// тест регистрации юзера
	public function testRegister(): void
	{
		$user = User::register(
			$name = 'name',
			$email = 'email',
			$password = 'password'
		); 

		// проверка, что пользователь не пустой
		self::assertNotEmpty($user);
		// прверка, что поля user заполнились переданными полями
		self::assertEquals($name, $user->name);
		self::assertEquals($email, $user->email);

		self::assertNotEmpty($user->password);
		self::assertNotEquals($password, $user->password);
		// проверка статуса 
		self::assertTrue($user->isWait());
		self::assertFalse($user->isActive());
		self::assertFalse($user->isAdmin());
	}
// тест подтверждения аккаунта
	public function testVerify(): void
	{
		$user = User::register('name', 'email', 'password'); 

		$user->verify();

		self::assertFalse($user->isWait());
		self::assertTrue($user->isActive());
	}
// тест того что пользователь уже зарегистрирован
	public function testAlreadyVerified(): void
	{
		$user = User::register('name', 'email', 'password');

		$user->verify();

		$this->expectExceptionMessage('User is already verified.');

		$user->verify();
	}
}

