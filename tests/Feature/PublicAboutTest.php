<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicAboutTest extends TestCase
{
    public function test_about_page_renders_hero_with_centered_title(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Votre Partenaire en matériel médical', false)
            ->assertSee('assets/images/hero-about.jpg', false)
            ->assertSee('À propos', false);
    }

    public function test_about_page_renders_values_and_sectors_sections(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Écoute', false)
            ->assertSee('Accompagnement', false)
            ->assertSee('Qualité de service', false)
            ->assertSee('Au service des professionnels de santé', false)
            ->assertSee('Cabinets', false)
            ->assertSee('Cliniques', false)
            ->assertSee('Hôpitaux', false)
            ->assertSee('Laboratoires', false);
    }

    public function test_about_page_renders_project_accompaniment_process(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Comment nous accompagnons votre projet', false)
            ->assertSee('Analyse de vos besoins', false)
            ->assertSee('Proposition et devis', false)
            ->assertSee('Approvisionnement et livraison', false)
            ->assertSee('Suivi et support', false)
            ->assertSee('Demander un devis', false);
    }

    public function test_about_page_renders_contact_cta_section(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Parlons de votre projet', false)
            ->assertSee('Notre équipe est à votre disposition', false)
            ->assertSee('Contactez-nous', false);
    }
}
