<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicQuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_form_redirects_when_cart_is_empty(): void
    {
        $this->get(route('quotes.create'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_quote_form_lists_cart_products(): void
    {
        $product = $this->product('Tensiomètre de poignet');
        app(CartService::class)->add($product, 2);

        $this->get(route('quotes.create'))
            ->assertOk()
            ->assertSee('Votre demande', false)
            ->assertSee('Établissement', false)
            ->assertSee('Téléphone', false)
            ->assertSee('Tensiomètre de poignet', false)
            ->assertSee('Finaliser ma demande', false)
            ->assertSee('id="mobile-sticky-cta"', false)
            ->assertSee('+237 699 850 500', false);
    }

    public function test_store_persists_quote_items_and_clears_cart(): void
    {
        $product = $this->product('Microscope binoculaire', '450000');
        app(CartService::class)->add($product, 2);

        $response = $this->post(route('quotes.store'), [
            'organization_name' => 'Clinique des Manguiers',
            'contact_name' => 'Aline Ngo',
            'phone' => '+237 699 112 448',
            'email' => 'achats@clinique-manguiers.cm',
            'message' => 'Livraison au bloc opératoire, délai souhaité sous trois semaines.',
        ]);

        $quote = QuoteRequest::query()->first();

        $this->assertNotNull($quote);
        $response->assertRedirect(route('quotes.sent'));
        $this->assertSame('Clinique des Manguiers', $quote->organization_name);
        $this->assertSame('Aline Ngo', $quote->contact_name);
        $this->assertSame('pending', $quote->status);
        $this->assertSame(1, $quote->items()->count());
        $this->assertSame('Microscope binoculaire', $quote->items()->first()->product_name);
        $this->assertSame(2, $quote->items()->first()->quantity);
        $this->assertSame(0, app(CartService::class)->count());

        $this->get(route('quotes.sent'))
            ->assertOk()
            ->assertSee($quote->reference, false)
            ->assertSee('Votre demande a bien été envoyée', false)
            ->assertSee('Votre sélection', false)
            ->assertSee('Microscope binoculaire', false)
            ->assertSee('Quantité : 2', false)
            ->assertSee('Demande reçue', false)
            ->assertSee('Étude du besoin', false)
            ->assertSee('Proposition de devis', false)
            ->assertSee('Suivre ma demande', false)
            ->assertSee('reference='.$quote->reference, false)
            ->assertSee('email=achats%40clinique-manguiers.cm', false)
            ->assertSee('+237 699 850 500', false);
    }

    public function test_confirmation_without_session_returns_to_cart(): void
    {
        $this->get(route('quotes.sent'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_store_rejects_missing_contact_fields(): void
    {
        $product = $this->product('Autoclave');
        app(CartService::class)->add($product, 1);

        $this->from(route('quotes.create'))
            ->post(route('quotes.store'), [
                'organization_name' => '',
                'contact_name' => '',
                'phone' => '',
                'email' => 'pas-un-email',
                'message' => '',
            ])
            ->assertRedirect(route('quotes.create'))
            ->assertSessionHasErrors(['organization_name', 'contact_name', 'phone', 'email', 'message']);

        $this->assertSame(0, QuoteRequest::query()->count());
        $this->assertSame(1, app(CartService::class)->count());
    }

    public function test_track_form_is_public(): void
    {
        $this->get(route('quotes.track'))
            ->assertOk()
            ->assertSee('Où en est votre demande ?', false)
            ->assertSee('Consulter le suivi', false)
            ->assertDontSee('assets/images/hero.png', false)
            ->assertDontSee('Résultat de votre demande', false);
    }

    public function test_track_shows_progress_and_hides_private_fields(): void
    {
        $product = $this->product('Tensiomètre de suivi');
        app(CartService::class)->add($product, 1);

        $this->post(route('quotes.store'), [
            'organization_name' => 'Clinique des Manguiers',
            'contact_name' => 'Aline Ngo',
            'phone' => '+237 699 112 448',
            'email' => 'achats@clinique-manguiers.cm',
            'message' => 'Livraison au bloc, note confidentielle du client.',
        ]);

        $quote = QuoteRequest::query()->first();
        $quote->forceFill([
            'status' => QuoteRequest::STATUS_PROCESSING,
            'admin_notes' => 'Marge interne secrète',
        ])->save();

        $this->get(route('quotes.track', ['reference' => strtolower($quote->reference)]))
            ->assertOk()
            ->assertSee($quote->reference)
            ->assertSee('achats@clinique-manguiers.cm')
            ->assertSee('Résultat de votre demande')
            ->assertSee('assets/images/hero.png', false)
            ->assertSee('Tensiomètre de suivi')
            ->assertSee('Quantité')
            ->assertSee('Une précision à apporter ?')
            ->assertSee('Contacter')
            ->assertSee('+237 699 850 500')
            ->assertDontSee('+237 699 112 448')
            ->assertDontSee('Clinique des Manguiers')
            ->assertDontSee('Livraison au bloc')
            ->assertDontSee('Marge interne secrète');
    }

    public function test_track_requires_matching_email_without_session(): void
    {
        $product = $this->product('Moniteur multiparamétrique');
        $quote = QuoteRequest::query()->create([
            'reference' => 'DEV-202610-0042',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Hôpital Général',
            'contact_name' => 'Dr. Mbarga',
            'email' => 'contact@hopital.cm',
            'phone' => '+237 699 000 111',
            'message' => 'Demande d\'évaluation',
        ]);
        $quote->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
        ]);

        // Sans e-mail ni session : retour au formulaire, sans paramètres dans l'adresse
        $this->get(route('quotes.track', ['reference' => $quote->reference]))
            ->assertRedirect(route('quotes.track'));

        $this->followingRedirects()
            ->get(route('quotes.track', ['reference' => $quote->reference]))
            ->assertOk()
            ->assertSee('Veuillez renseigner l\'adresse e-mail associée à cette demande.')
            ->assertDontSee('Résultat de votre demande', false)
            ->assertDontSee('assets/images/hero.png', false);

        // Avec mauvais e-mail
        $this->post(route('quotes.track'), [
            'reference' => $quote->reference,
            'email' => 'inconnu@test.cm',
        ])->assertRedirect(route('quotes.track'));

        $this->followingRedirects()
            ->post(route('quotes.track'), [
                'reference' => $quote->reference,
                'email' => 'inconnu@test.cm',
            ])
            ->assertOk()
            ->assertSee('L\'adresse e-mail ne correspond pas à cette référence.')
            ->assertDontSee('Résultat de votre demande', false)
            ->assertDontSee('assets/images/hero.png', false);

        // Avec bon e-mail
        $this->get(route('quotes.track', ['reference' => $quote->reference, 'email' => 'contact@hopital.cm']))
            ->assertOk()
            ->assertSee('Résultat de votre demande')
            ->assertSee($quote->reference)
            ->assertSee('contact@hopital.cm');
    }

    public function test_track_unknown_reference_stays_generic(): void
    {
        $this->post(route('quotes.track'), [
            'reference' => 'DEV-202610-9999',
            'email' => 'test@test.cm',
        ])->assertRedirect(route('quotes.track'));

        $this->followingRedirects()
            ->post(route('quotes.track'), [
                'reference' => 'DEV-202610-9999',
                'email' => 'test@test.cm',
            ])
            ->assertOk()
            ->assertSee('Aucune demande ne correspond à cette référence.', false)
            ->assertDontSee('assets/images/hero.png', false);
    }

    public function test_track_rejects_malformed_reference(): void
    {
        $this->post(route('quotes.track'), [
            'reference' => 'pas-une-ref',
            'email' => 'a@example.com',
        ])->assertRedirect(route('quotes.track'));

        $this->followingRedirects()
            ->post(route('quotes.track'), [
                'reference' => 'pas-une-ref',
                'email' => 'a@example.com',
            ])
            ->assertOk()
            ->assertSee('La référence doit ressembler à DEV-AAAAMM-0001.', false)
            ->assertSee('pas-une-ref', false)
            ->assertDontSee('Aucune demande ne correspond', false)
            ->assertDontSee('assets/images/hero.png', false);
    }

    private function product(string $name, ?string $price = null): Product
    {
        $category = Category::query()->create([
            'name' => 'Diagnostic',
            'slug' => 'diagnostic-'.str()->slug($name),
            'is_published' => true,
        ]);

        return Product::query()->create([
            'category_id' => $category->id,
            'name' => $name,
            'slug' => str()->slug($name),
            'price' => $price,
            'is_published' => true,
        ]);
    }
}
