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
            ->assertSee('lecpaarnaud@referencemedicosarl.com', false)
            ->assertSee('tous vos besoins de matériels et consommables médicaux', false)
            ->assertSee('https://maps.google.com/?cid=16209078626882780232&amp;g_mp=CiVnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLkdldFBsYWNlEAMYASAF', false)
            ->assertDontSee('jacquesmaud@referencemedicosarl.com', false)
            ->assertSee('Douala, Cameroun', false)
            ->assertSee('Hôpitaux régionaux & généraux', false)
            ->assertSee('Tous droits réservés', false)
            ->assertDontSee('Mentions légales', false)
            ->assertDontSee('Confidentialité', false)
            ->assertDontSee('Espace pro', false)
            ->assertSee('https://www.facebook.com/share/1E1Joi9BnE/', false)
            ->assertSee('https://www.instagram.com/p/DXWx1PDjDcX/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==', false)
            ->assertSee('https://cm.linkedin.com/company/reference-medico-sarl', false)
            ->assertSee('aria-label="Facebook"', false)
            ->assertSee('aria-label="Instagram"', false)
            ->assertSee('aria-label="LinkedIn"', false);
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
            ->assertSee('Tous droits réservés', false)
            ->assertDontSee('Espace pro', false);
    }
}
