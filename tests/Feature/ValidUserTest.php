<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ValidUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $userExists = User::where('email', 'admin@fintech.com')->exists();

        $this->assertTrue($userExists);
    }
}
