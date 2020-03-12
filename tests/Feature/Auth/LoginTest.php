<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Department;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user       = factory(User::class)->make();
        $response   = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'rut'           => '11111111-1',
            'department_id' => factory(Department::class),
            'password'      => \Hash::make( $password = 'i-love-laravel' ),
        ]);

        //User::find($user->id)->assignRole(['super-Admin']);

        $response = $this->post('/login', [
            'email'     => $user->email,
            'password'  => $password,
            //'_token' => csrf_token()
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }
}
