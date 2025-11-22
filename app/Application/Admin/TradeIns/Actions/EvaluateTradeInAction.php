<?php

namespace App\Application\Admin\TradeIns\Actions;

use App\Application\Admin\TradeIns\DTOs\EvaluateTradeInDTO;
use App\Application\TradeIn\Actions\EvaluateTradeInAction as TradeInEvaluateAction;
use App\Application\TradeIn\DTOs\EvaluateTradeInDTO as TradeInEvaluateDTO;

class EvaluateTradeInAction
{
    public function __construct(
        private TradeInEvaluateAction $tradeInEvaluateAction,
    ) {}

    public function execute(EvaluateTradeInDTO $dto): void
    {
        $tradeInEvaluateDTO = new TradeInEvaluateDTO(
            tradeInId: $dto->tradeInId,
            valuationAmount: $dto->valuationAmount,
            notes: $dto->notes,
        );

        $this->tradeInEvaluateAction->execute($tradeInEvaluateDTO);
    }
}

