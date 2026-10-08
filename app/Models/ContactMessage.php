<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'organization',
    'email',
    'phone',
    'subject',
    'message',
    'is_read',
    'read_at',
    'admin_notes',
])]
class ContactMessage extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => $this->read_at ?? now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function statusLabel(): string
    {
        return $this->is_read ? 'Lu' : 'Non lu';
    }

    public function statusBadgeClasses(): string
    {
        return $this->is_read
            ? 'bg-[#f2f4f7] text-[#344054] border border-[#eaecf0]'
            : 'bg-[#fffaeb] text-[#b54708] border border-[#fedf89]';
    }

    public function statusDotColor(): string
    {
        return $this->is_read ? 'bg-[#98a2b3]' : 'bg-[#f79009]';
    }
}
