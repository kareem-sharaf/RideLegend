<?php

namespace App\Application\Admin\TradeIns\Actions;

use App\Application\Admin\TradeIns\DTOs\ApproveTradeInDTO;
use App\Application\TradeIn\Actions\ApproveTradeInAction as TradeInApproveAction;
use App\Application\TradeIn\DTOs\ApproveTradeInDTO as TradeInApproveDTO;

class ApproveTradeInAction
{
    public function __construct(
        private TradeInApproveAction $tradeInApproveAction,
    ) {}

    public function execute(ApproveTradeInDTO $dto): void
    {
        $tradeInApproveDTO = new TradeInApproveDTO(
            tradeInId: $dto->tradeInId,
        );

        $this->tradeInApproveAction->execute($tradeInApproveDTO);
    }
}

