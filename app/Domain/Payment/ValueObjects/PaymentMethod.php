<?php

namespace App\Domain\Payment\ValueObjects;

final class PaymentMethod
{
    private const CREDIT_CARD = 'credit_card';
    private const PAYPAL = 'paypal';
    private const STRIPE = 'stripe';
    private const TRADE_IN_CREDIT = 'trade_in_credit';
    private const BANK_TRANSFER = 'bank_transfer';
    private const LOCAL_GATEWAY = 'local_gateway';

    private function __construct(
        private readonly string $value
    ) {
        $allowed = [
            self::CREDIT_CARD,
            self::PAYPAL,
            self::STRIPE,
            self::TRADE_IN_CREDIT,
            self::BANK_TRANSFER,
            self::LOCAL_GATEWAY,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid payment method: {$value}");
        }
    }

    public static function creditCard(): self
    {
        return new self(self::CREDIT_CARD);
    }

    public static function paypal(): self
    {
        return new self(self::PAYPAL);
    }

    public static function stripe(): self
    {
        return new self(self::STRIPE);
    }

    public static function tradeInCredit(): self
    {
        return new self(self::TRADE_IN_CREDIT);
    }

    public static function bankTransfer(): self
    {
        return new self(self::BANK_TRANSFER);
    }

    public static function localGateway(): self
    {
        return new self(self::LOCAL_GATEWAY);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(PaymentMethod $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

