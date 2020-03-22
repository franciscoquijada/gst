<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Department;
use App\Log;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function SetUp(): void
    {
        parent::setUp();
        Log::truncate();
    }

    protected function loginRoute()
    {
        return route('login');
    }

    protected function logoutRoute()
    {
        return route('logout');
    }

    protected function getTooManyLoginAttemptsMessage()
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    public function test_user_can_view_a_login_form()
    {
        $response = $this->get( $this->loginRoute() );


        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user       = factory(User::class)->make();
        $response   = $this->actingAs($user)->get( $this->loginRoute() );

        $response->assertRedirect('/home');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email'     => $user->email,
            'password'  => 'secret'
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $this->assertSame(1 , Log::where([
            'user_id'   => $user->id,
            'event'     => 'Inicio de sesion'
        ])->get()->count() );
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create();
        
        $response = $this->from( $this->loginRoute() )->post( $this->loginRoute(), [
            'email'     =>  $user->email,
            'password'  => 'invalid-password',
        ]);
        
        $response->assertRedirect( $this->loginRoute() );
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    public function test_user_cannot_login_with_email_that_does_not_exist()
    {
        $response = $this
            ->from( $this->loginRoute() )
            ->post( $this->loginRoute(), [
                'email'     => 'nobody@example.com',
                'password'  => 'invalid-password',
            ]);

        $response->assertRedirect( $this->loginRoute() );
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $this->be( $user = factory(User::class)->create() );

        $response = $this->post( $this->logoutRoute() );

        $response->assertRedirect( $this->loginRoute() );
        $this->assertGuest();

        $this->assertSame(1, Log::where([
            'user_id'   => $user->id,
            'event'     => 'Cierre de sesion'
        ])->get()->count() );
    }

    /*
    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $response = $this->post( $this->logoutRoute() );

        $response->assertStatus( 419 );
        $this->assertGuest();
    }*/

    public function test_user_cannot_make_more_than_five_attempts_in_one_minute()
    {
        $user = factory(User::class)->create();

        foreach (range(0, 5) as $_)
        {
            $response = $this
                ->from( $this->loginRoute() )
                ->post( $this->loginRoute(), [
                    'email'     => $user->email,
                    'password'  => 'invalid-password',
                ]);
        }

        $response->assertRedirect( $this->loginRoute() );
        $response->assertSessionHasErrors('email');
        $this->assertRegExp(
            $this->getTooManyLoginAttemptsMessage(),
            collect(
                $response
                ->baseResponse
                ->getSession()
                ->get('errors')
                ->getBag('default')
                ->get('email')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /*
    To Do: Pendiente Forgot Password
    public function test_user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();
      
        $user = factory(User::class)->create();
      
        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
        return Hash::check($notification->token, $token->token) === true; 
        });
        // assertions go here
    }*/
}
