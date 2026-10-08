<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\QuoteRequestItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_quotes_index(): void
    {
        $response = $this->get('/k8f3c1a9e2/quotes');

        $response->assertRedirect('/k8f3c1a9e2');
    }

    public function test_admin_can_view_quotes_index(): void
    {
        $quote = QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'CHU de Lille',
            'contact_name' => 'Dr. Thomas Laurent',
            'email' => 't.laurent@chu-lille.fr',
            'phone' => '03 20 00 00 00',
            'estimated_total' => 15000.00,
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/quotes');

        $response->assertOk();
        $response->assertSee('DEV-202610-0001');
        $response->assertSee('CHU de Lille');
        $response->assertSee('Dr. Thomas Laurent');
    }

    public function test_admin_can_filter_quotes_by_status(): void
    {
        QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Hôpital St-Jean',
            'contact_name' => 'Alice',
            'email' => 'alice@stjean.fr',
            'phone' => '01 00 00 00 00',
        ]);

        QuoteRequest::create([
            'reference' => 'DEV-202610-0002',
            'status' => QuoteRequest::STATUS_PROCESSED,
            'organization_name' => 'Clinique des Lilas',
            'contact_name' => 'Bob',
            'email' => 'bob@lilas.fr',
            'phone' => '02 00 00 00 00',
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/quotes?status=pending');

        $response->assertOk();
        $response->assertSee('DEV-202610-0001');
        $response->assertDontSee('DEV-202610-0002');
    }

    public function test_admin_can_fetch_quote_details_json_for_slide_over_preview(): void
    {
        $category = Category::create([
            'name' => 'Imagerie médicale',
            'slug' => 'imagerie-medicale',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Échographe Doppler Portable',
            'slug' => 'echographe-doppler-portable',
            'reference' => 'ECH-001',
            'price' => 7500.00,
            'is_published' => true,
        ]);

        $quote = QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Clinique Ambroise Paré',
            'contact_name' => 'Marie Martin',
            'email' => 'marie.martin@clinique-pare.fr',
            'phone' => '04 50 11 22 33',
            'message' => 'Besoin de livraison urgente sous 3 semaines.',
            'estimated_total' => 7500.00,
        ]);

        QuoteRequestItem::create([
            'quote_request_id' => $quote->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_reference' => $product->reference,
            'quantity' => 1,
            'unit_price' => 7500.00,
            'total_price' => 7500.00,
        ]);

        $response = $this->actingAs($this->admin)->getJson("/k8f3c1a9e2/quotes/{$quote->id}");

        $response->assertOk();
        $response->assertJsonPath('reference', 'DEV-202610-0001');
        $response->assertJsonPath('organization_name', 'Clinique Ambroise Paré');
        $response->assertJsonPath('items.0.product_name', 'Échographe Doppler Portable');
    }

    public function test_admin_can_update_quote_status(): void
    {
        $quote = QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Hôpital Militaire',
            'contact_name' => 'Colonel Vallet',
            'email' => 'vallet@defense.gouv.fr',
            'phone' => '01 44 00 00 00',
        ]);

        $response = $this->actingAs($this->admin)->put("/k8f3c1a9e2/quotes/{$quote->id}/status", [
            'status' => QuoteRequest::STATUS_PROCESSED,
            'admin_notes' => 'Devis chiffré transmis ce matin par e-mail.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('quote_requests', [
            'id' => $quote->id,
            'status' => QuoteRequest::STATUS_PROCESSED,
            'admin_notes' => 'Devis chiffré transmis ce matin par e-mail.',
        ]);
    }

    public function test_admin_can_delete_quote(): void
    {
        $quote = QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Centre Médical Sud',
            'contact_name' => 'M. Durand',
            'email' => 'durand@cmsud.fr',
            'phone' => '04 00 00 00 00',
        ]);

        $response = $this->actingAs($this->admin)->delete("/k8f3c1a9e2/quotes/{$quote->id}");

        $response->assertRedirect('/k8f3c1a9e2/quotes');
        $this->assertDatabaseMissing('quote_requests', [
            'id' => $quote->id,
        ]);
    }

    public function test_dashboard_displays_recent_quotes_and_stats(): void
    {
        QuoteRequest::create([
            'reference' => 'DEV-202610-0001',
            'status' => QuoteRequest::STATUS_PENDING,
            'organization_name' => 'Polyclinique du Nord',
            'contact_name' => 'Sophie V.',
            'email' => 'sophie@nord.fr',
            'phone' => '03 20 11 22 33',
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/board');

        $response->assertOk();
        $response->assertSee('DEV-202610-0001');
        $response->assertSee('Polyclinique du Nord');
        $response->assertSee('Dernières demandes de devis reçues');
    }
}
