<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFooterTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_footer_correctly(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Pied de page', false)
            ->assertSee('Référence Médico Sarl', false)
            ->assertSee('Matériel médical & hospitalier', false)
            ->assertSee('+237 699 850 500', false)
            ->assertSee('jacquesmaud@referencemedicosarl.com', false)
            ->assertSee('Douala, Cameroun', false)
            ->assertSee('Hôpitaux régionaux & généraux', false)
            ->assertSee('Mentions légales', false)
            ->assertSee('Tous droits réservés', false);
    }

    public function test_about_page_renders_footer_correctly(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Pied de page', false)
            ->assertSee('Référence Médico Sarl', false)
            ->assertSee('+237 699 850 500', false)
            ->assertSee('Catalogue', false)
            ->assertSee('Demander un devis', false)
            ->assertSee('Espace pro', false);
    }
}
