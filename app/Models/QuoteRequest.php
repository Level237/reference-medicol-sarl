<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'reference',
    'status',
    'organization_name',
    'organization_type',
    'contact_name',
    'email',
    'phone',
    'address',
    'postal_code',
    'city',
    'message',
    'estimated_total',
    'admin_notes',
    'processed_at',
])]
class QuoteRequest extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_PROCESSED = 'processed';

    public const STATUS_REJECTED = 'rejected';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'estimated_total' => 'decimal:2',
            'processed_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteRequestItem::class);
    }

    public static function generateReference(): string
    {
        $prefix = 'DEV-'.date('Ym').'-';
        $latest = static::query()
            ->where('reference', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->first();

        $number = 1;
        if ($latest && preg_match('/-(\d+)$/', (string) $latest->reference, $matches)) {
            $number = ((int) $matches[1]) + 1;
        }

        return $prefix.str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'En cours d\'étude',
            self::STATUS_PROCESSED => 'Devis envoyé / Traité',
            self::STATUS_REJECTED => 'Sans suite',
            default => 'En attente',
        };
    }

    public function statusBadgeClasses(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'bg-[#eff8ff] text-[#175cd3] border border-[#b2ddff]',
            self::STATUS_PROCESSED => 'bg-[#ecfdf3] text-[#027a48] border border-[#a6f4c5]',
            self::STATUS_REJECTED => 'bg-[#f2f4f7] text-[#344054] border border-[#eaecf0]',
            default => 'bg-[#fffaeb] text-[#b54708] border border-[#fedf89]',
        };
    }

    public function statusDotColor(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'bg-[#2e90fa]',
            self::STATUS_PROCESSED => 'bg-[#12b76a]',
            self::STATUS_REJECTED => 'bg-[#98a2b3]',
            default => 'bg-[#f79009]',
        };
    }
}
