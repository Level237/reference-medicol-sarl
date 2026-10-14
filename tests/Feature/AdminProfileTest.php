<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guest_is_sent_to_the_login_page(): void
    {
        $this->get(route('admin.profile.edit'))->assertRedirect(route('access.create'));
    }

    public function test_non_admin_cannot_open_the_profile(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.profile.edit'))
            ->assertForbidden();
    }

    public function test_admin_sees_personal_information(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Awa Ndiaye',
            'email' => 'awa@example.com',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.profile.edit'))
            ->assertOk()
            ->assertSee('Informations personnelles', false)
            ->assertSee('Awa Ndiaye', false)
            ->assertSee('awa@example.com', false)
            ->assertSee('Mot de passe actuel', false)
            ->assertDontSee('Paramètres', false);
    }

    public function test_admin_can_update_name_and_email(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Awa Ndiaye',
            'email' => 'awa@example.com',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'Awa Diop',
                'email' => 'awa.diop@example.com',
                'current_password' => 'password',
            ])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHas('status');

        $admin->refresh();

        $this->assertSame('Awa Diop', $admin->name);
        $this->assertSame('awa.diop@example.com', $admin->email);
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_can_change_password(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'current_password' => 'password',
                'password' => 'nouveau-mot-de-passe',
                'password_confirmation' => 'nouveau-mot-de-passe',
            ])
            ->assertRedirect(route('admin.profile.edit'));

        $this->assertTrue(Hash::check('nouveau-mot-de-passe', $admin->refresh()->password));
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Awa Ndiaye',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.profile.edit'))
            ->put(route('admin.profile.update'), [
                'name' => 'Autre nom',
                'email' => $admin->email,
                'current_password' => 'mauvais-mot-de-passe',
            ])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHasErrors('current_password');

        $this->assertSame('Awa Ndiaye', $admin->refresh()->name);
    }

    public function test_email_already_used_is_rejected(): void
    {
        User::factory()->create(['email' => 'pris@example.com']);
        $admin = User::factory()->admin()->create(['email' => 'awa@example.com']);

        $this->actingAs($admin)
            ->from(route('admin.profile.edit'))
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => 'pris@example.com',
                'current_password' => 'password',
            ])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHasErrors('email');

        $this->assertSame('awa@example.com', $admin->refresh()->email);
    }
}
