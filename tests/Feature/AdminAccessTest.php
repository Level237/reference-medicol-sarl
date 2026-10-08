<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_the_account_from_configuration(): void
    {
        config([
            'access.admin.name' => 'Responsable',
            'access.admin.email' => 'admin@example.com',
            'access.admin.password' => 'mot-de-passe-solide',
        ]);

        $this->seed(AdminSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->first();

        $this->assertNotNull($admin);
        $this->assertTrue($admin->is_admin);
        $this->assertSame('Responsable', $admin->name);

        $this->post(route('access.store'), [
            'email' => 'admin@example.com',
            'password' => 'mot-de-passe-solide',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_seeder_refuses_missing_or_short_credentials(): void
    {
        config([
            'access.admin.email' => 'pas-un-email',
            'access.admin.password' => 'court',
        ]);

        $this->expectException(RuntimeException::class);

        $this->seed(AdminSeeder::class);
    }

    public function test_non_admin_cannot_open_a_session(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('access.create'))->post(route('access.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('access.create'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited_per_email_and_address(): void
    {
        $payload = [
            'email' => 'intrus@example.com',
            'password' => 'mauvais-mot-de-passe',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from(route('access.create'))
                ->post(route('access.store'), $payload)
                ->assertRedirect(route('access.create'))
                ->assertSessionHasErrors('email');
        }

        $this->from(route('access.create'))
            ->post(route('access.store'), $payload)
            ->assertRedirect(route('access.create'))
            ->assertSessionHasErrors([
                'email' => 'Trop de tentatives. Réessayez dans une minute.',
            ]);

        $this->assertGuest();
    }

    public function test_admin_middleware_sends_guests_to_the_login_page(): void
    {
        Route::middleware('admin')->get('/_internal/admin-probe', fn () => 'ok');

        $this->get('/_internal/admin-probe')->assertRedirect(route('access.create'));
    }

    public function test_admin_middleware_blocks_a_non_admin(): void
    {
        Route::middleware('admin')->get('/_internal/admin-probe', fn () => 'ok');

        $this->actingAs(User::factory()->create())
            ->get('/_internal/admin-probe')
            ->assertForbidden();
    }

    public function test_admin_middleware_allows_an_admin(): void
    {
        Route::middleware('admin')->get('/_internal/admin-probe', fn () => 'espace');

        $this->actingAs(User::factory()->admin()->create())
            ->get('/_internal/admin-probe')
            ->assertOk()
            ->assertSee('espace');
    }
}
