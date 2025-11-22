<?php

namespace App\Application\Admin\TradeIns\Actions;

use App\Application\Admin\TradeIns\DTOs\RejectTradeInDTO;
use App\Application\TradeIn\Actions\RejectTradeInAction as TradeInRejectAction;
use App\Application\TradeIn\DTOs\RejectTradeInDTO as TradeInRejectDTO;

class RejectTradeInAction
{
    public function __construct(
        private TradeInRejectAction $tradeInRejectAction,
    ) {}

    public function execute(RejectTradeInDTO $dto): void
    {
        $tradeInRejectDTO = new TradeInRejectDTO(
            tradeInId: $dto->tradeInId,
            reason: $dto->reason,
        );

        $this->tradeInRejectAction->execute($tradeInRejectDTO);
    }
}

