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

    /**
     * Avancement public : trois étapes avec libellé et état pour la timeline.
     *
     * @return list<array{number: int, label: string, state: string, subtext: string}>
     */
    public function trackingSteps(): array
    {
        $createdLabel = $this->created_at
            ? $this->created_at->locale('fr')->translatedFormat('d M Y')
            : 'Reçue';

        return match ($this->status) {
            self::STATUS_PROCESSING => [
                ['number' => 1, 'label' => 'Demande reçue', 'state' => 'done', 'subtext' => $createdLabel],
                ['number' => 2, 'label' => 'Étude du besoin', 'state' => 'current', 'subtext' => 'En cours'],
                ['number' => 3, 'label' => 'Proposition de devis', 'state' => 'upcoming', 'subtext' => 'À venir'],
            ],
            self::STATUS_PROCESSED => [
                ['number' => 1, 'label' => 'Demande reçue', 'state' => 'done', 'subtext' => $createdLabel],
                ['number' => 2, 'label' => 'Étude du besoin', 'state' => 'done', 'subtext' => 'Terminée'],
                ['number' => 3, 'label' => 'Proposition de devis', 'state' => 'done', 'subtext' => 'Prête'],
            ],
            self::STATUS_REJECTED => [
                ['number' => 1, 'label' => 'Demande reçue', 'state' => 'done', 'subtext' => $createdLabel],
                ['number' => 2, 'label' => 'Étude du besoin', 'state' => 'done', 'subtext' => 'Sans suite'],
                ['number' => 3, 'label' => 'Proposition de devis', 'state' => 'cancelled', 'subtext' => 'Non retenue'],
            ],
            default => [
                ['number' => 1, 'label' => 'Demande reçue', 'state' => 'done', 'subtext' => $createdLabel],
                ['number' => 2, 'label' => 'Étude du besoin', 'state' => 'upcoming', 'subtext' => 'À venir'],
                ['number' => 3, 'label' => 'Proposition de devis', 'state' => 'upcoming', 'subtext' => 'À venir'],
            ],
        };
    }

    public function trackingStatusTitle(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'En cours d\'étude',
            self::STATUS_PROCESSED => 'Proposition de devis prête',
            self::STATUS_REJECTED => 'Demande sans suite',
            default => 'Demande reçue',
        };
    }

    public function trackingSummary(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'Votre demande est actuellement en cours d\'étude par notre équipe.',
            self::STATUS_PROCESSED => 'Notre proposition de devis a été préparée et vous a été transmise.',
            self::STATUS_REJECTED => 'Cette demande n\'a pas pu être retenue. Contactez notre équipe pour plus de détails.',
            default => 'Notre équipe a bien reçu votre demande et prépare l\'étude de vos besoins.',
        };
    }
}
