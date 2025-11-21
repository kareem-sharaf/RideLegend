<?php

namespace App\Application\TradeIn\Actions;

use App\Application\TradeIn\DTOs\EvaluateTradeInDTO;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class EvaluateTradeInAction
{
    public function __construct(
        private TradeInRepositoryInterface $tradeInRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(EvaluateTradeInDTO $dto): void
    {
        $tradeIn = $this->tradeInRepository->findById($dto->tradeInId);

        if (!$tradeIn) {
            throw new \DomainException('Trade-in request not found');
        }

        $tradeIn->valuate();
        $this->tradeInRepository->save($tradeIn);

        // Dispatch domain events
        foreach ($tradeIn->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $tradeIn->clearDomainEvents();
    }
}

