<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guessable_admin_paths_are_not_registered(): void
    {
        $this->get('/admin')->assertNotFound();
        $this->get('/dashboard')->assertNotFound();
    }

    public function test_guest_is_sent_to_the_login_page(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('access.create'));
    }

    public function test_non_admin_cannot_open_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_sees_the_static_shell(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Awa Ndiaye',
            'email' => 'awa@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Tableau de bord', false);
        $response->assertSee('Navigation', false);
        $response->assertSee('Produits', false);
        $response->assertSee('Demandes de devis', false);
        $response->assertSee('Messages', false);
        $response->assertSee('Awa Ndiaye', false);
        $response->assertSee('Se déconnecter', false);
        $response->assertSee('Rechercher un appareil, une référence, un devis...', false);
        $response->assertSee('assets/images/logo.jpeg', false);
        $response->assertSee('noindex, nofollow', false);
        $response->assertSee('<main', false);
        $response->assertSee('<aside', false);
        $response->assertSee('<header', false);
        $response->assertSee('Dernières demandes & activités', false);
        $response->assertSee('Actions & Raccourcis', false);
    }

    public function test_admin_can_sign_out(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.logout'));

        $response->assertRedirect(route('access.create'));
        $this->assertGuest();
    }
}
