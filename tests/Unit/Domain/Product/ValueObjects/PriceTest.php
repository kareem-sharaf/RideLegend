<?php

use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

test('price cannot be negative', function () {
    expect(fn() => Price::fromAmount(-100))
        ->toThrow(BusinessRuleViolationException::class);
});

test('price can be created with valid amount', function () {
    $price = Price::fromAmount(1000.50);

    expect($price->getAmount())->toBe(1000.50)
        ->and($price->getCurrency())->toBe('USD');
});

test('price can be compared', function () {
    $price1 = Price::fromAmount(1000);
    $price2 = Price::fromAmount(1000);
    $price3 = Price::fromAmount(2000);

    expect($price1->equals($price2))->toBeTrue()
        ->and($price1->equals($price3))->toBeFalse();
});

