<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $message = ContactMessage::query()->create([
            'name' => $request->string('name')->toString(),
            'organization' => $request->filled('organization') ? $request->string('organization')->toString() : null,
            'email' => $request->string('email')->toString(),
            'phone' => $request->filled('phone') ? $request->string('phone')->toString() : null,
            'message' => $request->string('message')->toString(),
        ]);

        $this->notifyTeam($message);

        return redirect()
            ->route('contact')
            ->with('status', 'Votre message a bien été envoyé. Notre équipe vous répondra rapidement.');
    }

    private function notifyTeam(ContactMessage $message): void
    {
        $messageId = $message->id;

        dispatch(function () use ($messageId): void {
            $stored = ContactMessage::query()->find($messageId);

            if (! $stored) {
                return;
            }

            try {
                Mail::send(new ContactMessageReceived($stored));
            } catch (Throwable $exception) {
                report($exception);
            }
        })->afterResponse();
    }
}
