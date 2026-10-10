<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicHomeTest extends TestCase
{
    public function test_home_renders_the_public_header_and_topbar(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Référence Médico Sarl', false)
            ->assertSee('assets/images/logo.png', false)
            ->assertSee('+237 699 850 500', false)
            ->assertSee('jacquesmaud@referencemedicosarl.com', false)
            ->assertSee('Catalogue', false)
            ->assertSee('Nos services', false)
            ->assertSee('À propos', false)
            ->assertSee('Contact', false)
            ->assertSee('Demander un devis', false)
            ->assertSee('id="menu-mobile"', false)
            ->assertSee('Tout le matériel', false)
            ->assertSee('pour vos soins.', false)
            ->assertSee('Des équipements fiables pour les professionnels de santé', false)
            ->assertSee('assets/images/hero.png', false)
            ->assertSee('Rechercher un produit ou une référence...', false);
    }
}
