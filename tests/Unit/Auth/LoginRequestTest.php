<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that email is required for login request.
     */
    public function test_email_is_required(): void
    {
        $request = new LoginRequest();
        $validator = Validator::make([], $request->rules());
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('email'));
    }

    /**
     * Test that email must be a valid email format.
     */
    public function test_email_must_be_valid_format(): void
    {
        $request = new LoginRequest();
        $validator = Validator::make([
            'email' => 'invalid-email'
        ], $request->rules());
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('email'));
    }

    /**
     * Test that password is required for login request.
     */
    public function test_password_is_required(): void
    {
        $request = new LoginRequest();
        $validator = Validator::make([
            'email' => 'test@example.com'
        ], $request->rules());
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('password'));
    }

    /**
     * Test that password must be a string.
     */
    public function test_password_must_be_string(): void
    {
        $request = new LoginRequest();
        $validator = Validator::make([
            'email' => 'test@example.com',
            'password' => 123456
        ], $request->rules());
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('password'));
    }

    /**
     * Test that valid data passes validation.
     */
    public function test_valid_data_passes_validation(): void
    {
        $request = new LoginRequest();
        $validator = Validator::make([
            'email' => 'test@example.com',
            'password' => 'password123'
        ], $request->rules());
        
        $this->assertTrue($validator->passes());
    }

    /**
     * Test that remember field is optional and handled by Laravel's boolean helper.
     */
    public function test_remember_field_validation(): void
    {
        $request = new LoginRequest();
        
        // Test without remember field (should pass)
        $validator = Validator::make([
            'email' => 'test@example.com',
            'password' => 'password123'
        ], $request->rules());
        $this->assertTrue($validator->passes());
        
        // Test with remember field - Laravel's boolean() method handles conversion
        // so validation doesn't fail even with 'invalid' string
        $validator = Validator::make([
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => 'invalid'
        ], $request->rules());
        $this->assertTrue($validator->passes()); // This should pass because remember is not in rules
    }
}