<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_is_public(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Contactez-nous', false)
            ->assertSee('assets/images/about/hopital.jpg', false)
            ->assertSee('Numéro WhatsApp', false)
            ->assertSee('Envoyer le message', false)
            ->assertSee('Adresse', false)
            ->assertSee('contact-map', false)
            ->assertDontSee('Signalez un problème', false)
            ->assertSee('+237 699 850 500', false)
            ->assertSee('lecpaarnaud@referencemedicosarl.com', false)
            ->assertSee('maps.google.com/maps?cid=16209078626882780232', false);
    }

    public function test_store_persists_message_and_notifies_the_team(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'name' => 'Aline Ngo',
            'organization' => 'Clinique des Manguiers',
            'email' => 'aline@clinique-manguiers.cm',
            'phone' => '+237 699 112 448',
            'message' => 'Besoin d\'un devis pour un analyseur d\'électrolytes.',
        ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Aline Ngo',
            'organization' => 'Clinique des Manguiers',
            'email' => 'aline@clinique-manguiers.cm',
            'phone' => '+237 699 112 448',
            'is_read' => false,
        ]);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail): bool {
            return $mail->hasTo('lecpaarnaud@referencemedicosarl.com');
        });

        $this->followingRedirects()
            ->post(route('contact.store'), [
                'name' => 'Aline Ngo',
                'email' => 'aline@clinique-manguiers.cm',
                'message' => 'Second message.',
            ])
            ->assertOk()
            ->assertSee('Votre message a bien été envoyé.', false);
    }

    public function test_store_rejects_invalid_input_and_keeps_the_message_private(): void
    {
        Mail::fake();

        $this->from(route('contact'))
            ->post(route('contact.store'), [
                'name' => '',
                'email' => 'pas-un-email',
                'message' => '',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertSame(0, ContactMessage::query()->count());
        Mail::assertNothingSent();
    }

    public function test_confirmation_does_not_render_the_submitted_markup(): void
    {
        Mail::fake();

        $payload = '<img src=x onerror=alert(1)>';

        $this->followingRedirects()
            ->post(route('contact.store'), [
                'name' => 'Visiteur',
                'email' => 'visiteur@exemple.cm',
                'message' => $payload,
            ])
            ->assertOk()
            ->assertDontSee('onerror=alert', false)
            ->assertSee('Votre message a bien été envoyé.', false);

        $this->assertSame($payload, ContactMessage::query()->first()->message);
    }
}
