<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicServicesTest extends TestCase
{
    public function test_services_page_is_public_and_has_single_hero_title(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Accompagnement et équipements pour établissements de santé', false)
            ->assertSee('assets/images/about/laboratoire.jpg', false)
            ->assertSee('Nos services', false);
    }

    public function test_services_page_renders_offerings_and_conversion_links(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Conseil & sélection', false)
            ->assertSee('Devis & chiffrage', false)
            ->assertSee('Suivi de demande', false)
            ->assertSee(route('quotes.create'), false)
            ->assertSee(route('quotes.track'), false)
            ->assertSee(route('contact'), false);
    }

    public function test_services_page_differs_from_about_process_detail(): void
    {
        $response = $this->get(route('services'));

        $response->assertOk();
        $response->assertSee('Trois étapes pour avancer sereinement', false);
        $response->assertDontSee('Approvisionnement et livraison', false);
        $response->assertDontSee('Analyse de vos besoins', false);
    }

    public function test_services_page_renders_audiences_and_final_cta(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Pour qui intervenons-nous ?', false)
            ->assertSee('Hôpitaux', false)
            ->assertSee('Laboratoires', false)
            ->assertSee('assets/images/about/hopital.jpg', false)
            ->assertSee('assets/images/about/laboratoire.jpg', false)
            ->assertSee('Parlons de votre projet', false);
    }
}
