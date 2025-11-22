<?php

namespace App\Application\Admin\TradeIns\Actions;

use App\Application\Admin\TradeIns\DTOs\ShowTradeInDTO;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;

class ShowTradeInAction
{
    public function __construct(
        private TradeInRepositoryInterface $tradeInRepository,
    ) {}

    public function execute(ShowTradeInDTO $dto)
    {
        $tradeIn = $this->tradeInRepository->findById($dto->tradeInId);

        if (!$tradeIn) {
            throw new \DomainException('Trade-in not found');
        }

        return $tradeIn;
    }
}

