<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessSessionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_login_page_is_served_on_the_unlisted_path(): void
    {
        $response = $this->get('/'.config('access.path'));

        $response->assertOk();
        $response->assertSee('Heureux de vous', false);
        $response->assertSee('retrouver.', false);
        $response->assertSee('assets/images/logo.jpeg', false);
        $response->assertSee('Retour à la page d\'accueil', false);
        $response->assertDontSee('Créer un compte', false);
        $response->assertSee('assets/images/login.jpeg', false);
        $response->assertSee('noindex, nofollow', false);
        $this->assertStringNotContainsString('admin/login', config('access.path'));
    }

    public function test_common_login_paths_are_not_registered(): void
    {
        $this->get('/login')->assertNotFound();
        $this->get('/admin/login')->assertNotFound();
    }

    public function test_admin_can_sign_in_with_valid_credentials(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->post(route('access.store'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_stay_on_the_login_page(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->from(route('access.create'))->post(route('access.store'), [
            'email' => $user->email,
            'password' => 'mauvais-mot-de-passe',
        ]);

        $response->assertRedirect(route('access.create'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_admin_is_sent_to_the_dashboard(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get(route('access.create'));

        $response->assertRedirect(route('admin.dashboard'));
    }
}
