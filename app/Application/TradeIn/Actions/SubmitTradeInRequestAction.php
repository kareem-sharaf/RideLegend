<?php

namespace App\Application\TradeIn\Actions;

use App\Application\TradeIn\DTOs\SubmitTradeInRequestDTO;
use App\Domain\TradeIn\Models\TradeIn;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class SubmitTradeInRequestAction
{
    public function __construct(
        private TradeInRepositoryInterface $tradeInRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(SubmitTradeInRequestDTO $dto): TradeIn
    {
        $tradeIn = TradeIn::create($dto->buyerId);
        
        $this->tradeInRepository->save($tradeIn);

        // Dispatch domain events
        foreach ($tradeIn->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $tradeIn->clearDomainEvents();

        return $tradeIn;
    }
}

