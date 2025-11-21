<?php

namespace App\Infrastructure\Repositories\TradeIn;

use App\Domain\TradeIn\Models\TradeIn;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use App\Domain\TradeIn\ValueObjects\TradeInStatus;
use App\Models\TradeIn as EloquentTradeIn;

class EloquentTradeInRepository implements TradeInRepositoryInterface
{
    public function save(TradeIn $tradeIn): void
    {
        $eloquent = EloquentTradeIn::updateOrCreate(
            ['id' => $tradeIn->getId()],
            [
                'buyer_id' => $tradeIn->getBuyerId(),
                'status' => $tradeIn->getStatus()->getValue(),
                'requested_at' => $tradeIn->getRequestedAt(),
                'approved_at' => $tradeIn->getApprovedAt(),
                'rejected_at' => $tradeIn->getRejectedAt(),
                'rejection_reason' => $tradeIn->getRejectionReason(),
            ]
        );

        // Update trade-in ID in domain model if it was new
        if (!$tradeIn->getId()) {
            $reflection = new \ReflectionClass($tradeIn);
            $idProperty = $reflection->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($tradeIn, $eloquent->id);
        }
    }

    public function findById(int $id): ?TradeIn
    {
        $eloquent = EloquentTradeIn::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByBuyerId(int $buyerId): array
    {
        $eloquents = EloquentTradeIn::where('buyer_id', $buyerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    private function toDomain(EloquentTradeIn $eloquent): TradeIn
    {
        $status = TradeInStatus::fromString($eloquent->status);

        return new TradeIn(
            id: $eloquent->id,
            buyerId: $eloquent->buyer_id,
            status: $status,
            requestedAt: $eloquent->requested_at?->toImmutable(),
            approvedAt: $eloquent->approved_at?->toImmutable(),
            rejectedAt: $eloquent->rejected_at?->toImmutable(),
            rejectionReason: $eloquent->rejection_reason,
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );
    }
}

