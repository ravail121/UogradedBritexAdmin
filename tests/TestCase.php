<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const EMAIL = "admin@britex.pw";
    const PASSWORD = "qwerty";

    public function login()
    {
        $this->post('/logout');
        $response = $this->post('/login', [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);
    }
}
