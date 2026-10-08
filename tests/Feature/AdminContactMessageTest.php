<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactMessageTest extends TestCase
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

    public function test_guest_cannot_access_messages_index(): void
    {
        $response = $this->get('/k8f3c1a9e2/messages');

        $response->assertRedirect('/k8f3c1a9e2');
    }

    public function test_admin_can_view_messages_index(): void
    {
        $message = ContactMessage::create([
            'name' => 'Professeur Benali',
            'organization' => 'Clinique Pasteur',
            'email' => 'benali@pasteur.org',
            'phone' => '01 40 50 60 70',
            'subject' => 'Renseignements sur les autoclaves',
            'message' => 'Bonjour, nous souhaiterions des informations sur vos équipements de stérilisation.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/messages');

        $response->assertOk();
        $response->assertSee('Professeur Benali');
        $response->assertSee('Clinique Pasteur');
        $response->assertSee('Renseignements sur les autoclaves');
    }

    public function test_admin_can_filter_messages_by_read_status(): void
    {
        ContactMessage::create([
            'name' => 'Message Non Lu',
            'email' => 'unread@test.fr',
            'message' => 'Ceci est un message non lu.',
            'is_read' => false,
        ]);

        ContactMessage::create([
            'name' => 'Message Lu',
            'email' => 'read@test.fr',
            'message' => 'Ceci est un message lu.',
            'is_read' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/messages?status=unread');

        $response->assertOk();
        $response->assertSee('Message Non Lu');
        $response->assertDontSee('Message Lu');
    }

    public function test_admin_can_fetch_message_details_json_for_preview(): void
    {
        $message = ContactMessage::create([
            'name' => 'Dr. Claire Dupont',
            'organization' => 'Hôpital Saint-Louis',
            'email' => 'c.dupont@aphp.fr',
            'phone' => '06 11 22 33 44',
            'subject' => 'Devis complémentaire bloc chirurgie',
            'message' => 'Nous aimerions tester le moniteur multiparamétrique pendant 2 semaines.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->getJson("/k8f3c1a9e2/messages/{$message->id}");

        $response->assertOk();
        $response->assertJsonPath('name', 'Dr. Claire Dupont');
        $response->assertJsonPath('organization', 'Hôpital Saint-Louis');
        $response->assertJsonPath('subject', 'Devis complémentaire bloc chirurgie');
        $response->assertJsonPath('is_read', false);
    }

    public function test_admin_can_toggle_message_read_status(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jean Martin',
            'email' => 'j.martin@cabinet.fr',
            'message' => 'Demande d informations.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->patchJson("/k8f3c1a9e2/messages/{$message->id}/read");

        $response->assertOk();
        $response->assertJsonPath('is_read', true);
        $this->assertTrue($message->fresh()->is_read);
        $this->assertNotNull($message->fresh()->read_at);

        // Bascule inverse
        $response2 = $this->actingAs($this->admin)->patchJson("/k8f3c1a9e2/messages/{$message->id}/read");
        $response2->assertOk();
        $response2->assertJsonPath('is_read', false);
        $this->assertFalse($message->fresh()->is_read);
    }

    public function test_admin_can_update_message_notes(): void
    {
        $message = ContactMessage::create([
            'name' => 'Marc Lefebvre',
            'email' => 'marc@lefebvre.com',
            'message' => 'Rappelez-moi svp.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->put("/k8f3c1a9e2/messages/{$message->id}", [
            'admin_notes' => 'Rappel effectué le 08/10, intéressé par la cardiologie.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'admin_notes' => 'Rappel effectué le 08/10, intéressé par la cardiologie.',
        ]);
    }

    public function test_admin_can_delete_message(): void
    {
        $message = ContactMessage::create([
            'name' => 'Spam Bot',
            'email' => 'spam@bot.com',
            'message' => 'Offre publicitaire.',
            'is_read' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/k8f3c1a9e2/messages/{$message->id}");

        $response->assertRedirect('/k8f3c1a9e2/messages');
        $this->assertDatabaseMissing('contact_messages', [
            'id' => $message->id,
        ]);
    }

    public function test_dashboard_displays_recent_messages_and_unread_stats(): void
    {
        ContactMessage::create([
            'name' => 'Docteur Valérie',
            'organization' => 'CHU de Bordeaux',
            'email' => 'valerie@chu-bordeaux.fr',
            'message' => 'Urgent: besoin d un devis pour 3 respirateurs.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/k8f3c1a9e2/board');

        $response->assertOk();
        $response->assertSee('Docteur Valérie');
        $response->assertSee('CHU de Bordeaux');
        $response->assertSee('Derniers messages de contact reçus');
    }
}
