<?php

namespace App\Application\TradeIn\Actions;

use App\Application\TradeIn\DTOs\ApproveTradeInDTO;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class ApproveTradeInAction
{
    public function __construct(
        private TradeInRepositoryInterface $tradeInRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(ApproveTradeInDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $tradeIn = $this->tradeInRepository->findById($dto->tradeInId);

            if (!$tradeIn) {
                throw new \DomainException('Trade-in request not found');
            }

            if (!$tradeIn->getStatus()->isValuated()) {
                throw new \DomainException('Only valuated trade-ins can be approved');
            }

            $tradeIn->approve();
            $this->tradeInRepository->save($tradeIn);

            // TODO: Create credit for user
            // This should be handled by an event listener

            // Dispatch domain events
            foreach ($tradeIn->getDomainEvents() as $event) {
                $this->eventDispatcher->dispatch($event);
            }

            $tradeIn->clearDomainEvents();
        });
    }
}

