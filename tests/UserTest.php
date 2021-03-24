<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserRegistration()
    {
        $this->json('POST', '/api/register', [
            'first_name' => 'A',
            'last_name' => 'B',
            'email' => 'test@test.test',
            'password' => 'qwer1234',
            'phone' => '12-13-14',
            ])
            ->seeJson([
                'status' => true,
                'message' => 'Registration success!',
            ]);
    }
    public function testUserLogin()
    {
        $this->json('POST', '/api/register', [
            'first_name' => 'A',
            'last_name' => 'B',
            'email' => 'test@test.test',
            'password' => 'qwer1234',
            'phone' => '12-13-14',
        ]);
        $this->json('POST', '/api/sign-in', [
            'email' => 'test@test.test',
            'password' => 'qwer1234',
        ])
            ->seeJson([
                'status' => true,
                'message' => 'Success login'
            ]);
    }
}
