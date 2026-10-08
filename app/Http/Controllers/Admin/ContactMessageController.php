<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('organization', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            if ($status === 'unread') {
                $query->where('is_read', false);
            } elseif ($status === 'read') {
                $query->where('is_read', true);
            }
        }

        $messages = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => ContactMessage::query()->count(),
            'unread' => ContactMessage::query()->where('is_read', false)->count(),
            'read' => ContactMessage::query()->where('is_read', true)->count(),
        ];

        return view('admin.messages.index', [
            'messages' => $messages,
            'counts' => $counts,
            'currentStatus' => $request->query('status'),
            'search' => $request->query('search'),
        ]);
    }

    public function show(Request $request, ContactMessage $message): View|JsonResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'id' => $message->id,
                'name' => $message->name,
                'organization' => $message->organization,
                'email' => $message->email,
                'phone' => $message->phone,
                'subject' => $message->subject ?: 'Sans objet',
                'message' => $message->message,
                'is_read' => $message->is_read,
                'status_label' => $message->statusLabel(),
                'status_badge' => $message->statusBadgeClasses(),
                'status_dot' => $message->statusDotColor(),
                'admin_notes' => $message->admin_notes,
                'read_at' => $message->read_at?->format('d/m/Y à H:i'),
                'created_at' => $message->created_at->format('d/m/Y à H:i'),
                'created_at_human' => $message->created_at->diffForHumans(),
                'toggle_read_url' => route('admin.messages.toggle-read', $message),
                'update_url' => route('admin.messages.update', $message),
                'destroy_url' => route('admin.messages.destroy', $message),
            ]);
        }

        return view('admin.messages.show', [
            'message' => $message,
        ]);
    }

    public function toggleRead(Request $request, ContactMessage $message): RedirectResponse|JsonResponse
    {
        if ($message->is_read) {
            $message->markAsUnread();
            $statusText = 'Message marqué comme non lu.';
        } else {
            $message->markAsRead();
            $statusText = 'Message marqué comme lu.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'is_read' => $message->is_read,
                'status_label' => $message->statusLabel(),
                'status_badge' => $message->statusBadgeClasses(),
                'status_dot' => $message->statusDotColor(),
                'message' => $statusText,
            ]);
        }

        return back()->with('status', $statusText);
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'admin_notes' => $validated['admin_notes'] ?? $message->admin_notes,
        ];

        if (array_key_exists('is_read', $validated)) {
            $data['is_read'] = (bool) $validated['is_read'];
            $data['read_at'] = $data['is_read'] ? ($message->read_at ?? now()) : null;
        }

        $message->update($data);

        return back()->with('status', "Le message de {$message->name} a été mis à jour.");
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $name = $message->name;
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('status', "Le message de {$name} a été supprimé.");
    }
}
