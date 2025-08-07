<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that user can be created with hashed password.
     */
    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plaintext-password'
        ]);

        $this->assertTrue(Hash::check('plaintext-password', $user->password));
        $this->assertNotEquals('plaintext-password', $user->password);
    }

    /**
     * Test that user has correct fillable attributes.
     */
    public function test_user_fillable_attributes(): void
    {
        $user = new User();
        $fillable = $user->getFillable();

        $expectedFillable = ['name', 'email', 'password'];
        
        foreach ($expectedFillable as $attribute) {
            $this->assertContains($attribute, $fillable);
        }
    }

    /**
     * Test that user has correct hidden attributes.
     */
    public function test_user_hidden_attributes(): void
    {
        $user = new User();
        $hidden = $user->getHidden();

        $expectedHidden = ['password', 'remember_token'];
        
        foreach ($expectedHidden as $attribute) {
            $this->assertContains($attribute, $hidden);
        }
    }

    /**
     * Test that user email is unique.
     */
    public function test_user_email_is_unique(): void
    {
        $user1 = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::factory()->create([
            'email' => 'test@example.com'
        ]);
    }

    /**
     * Test that user can be found by email.
     */
    public function test_user_can_be_found_by_email(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $foundUser = User::where('email', 'test@example.com')->first();
        
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
        $this->assertEquals('test@example.com', $foundUser->email);
    }

    /**
     * Test that user model has expected attributes.
     */
    public function test_user_has_expected_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertNotNull($user->password);
        $this->assertInstanceOf(\DateTime::class, $user->created_at);
        $this->assertInstanceOf(\DateTime::class, $user->updated_at);
    }

    /**
     * Test that user can verify password.
     */
    public function test_user_can_verify_password(): void
    {
        $plainPassword = 'test-password-123';
        $user = User::factory()->create([
            'password' => Hash::make($plainPassword)
        ]);

        $this->assertTrue(Hash::check($plainPassword, $user->password));
        $this->assertFalse(Hash::check('wrong-password', $user->password));
    }
}