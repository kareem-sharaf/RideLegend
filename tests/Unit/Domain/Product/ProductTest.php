<?php

use App\Domain\Product\Events\ProductCreated;
use App\Domain\Product\Models\Product;
use App\Domain\Product\ValueObjects\BikeType;
use App\Domain\Product\ValueObjects\BrakeType;
use App\Domain\Product\ValueObjects\FrameMaterial;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Product\ValueObjects\Title;
use App\Domain\Product\ValueObjects\WheelSize;

test('product can be created', function () {
    $product = Product::create(
        sellerId: 1,
        title: Title::fromString('Premium Road Bike'),
        description: 'A high-quality road bike',
        price: Price::fromAmount(2500.00),
        bikeType: BikeType::fromString('road'),
        frameMaterial: FrameMaterial::fromString('carbon'),
        brakeType: BrakeType::fromString('disc_brake_hydraulic'),
        wheelSize: WheelSize::fromString('700c'),
        brand: 'Trek',
        model: 'Domane',
        year: 2023
    );

    expect($product->getTitle()->toString())->toBe('Premium Road Bike')
        ->and($product->getPrice()->getAmount())->toBe(2500.00)
        ->and($product->getBikeType()->toString())->toBe('road')
        ->and($product->getStatus())->toBe('draft');
});

test('product creation dispatches ProductCreated event', function () {
    $product = Product::create(
        sellerId: 1,
        title: Title::fromString('Test Bike'),
        description: 'Test',
        price: Price::fromAmount(1000),
        bikeType: BikeType::fromString('road'),
        frameMaterial: FrameMaterial::fromString('carbon'),
        brakeType: BrakeType::fromString('rim_brake'),
        wheelSize: WheelSize::fromString('700c')
    );

    $events = $product->getDomainEvents();

    expect($events)->toHaveCount(1)
        ->and($events->first())->toBeInstanceOf(ProductCreated::class);
});

test('product can be updated', function () {
    $product = Product::create(
        sellerId: 1,
        title: Title::fromString('Original Title'),
        description: 'Original',
        price: Price::fromAmount(1000),
        bikeType: BikeType::fromString('road'),
        frameMaterial: FrameMaterial::fromString('carbon'),
        brakeType: BrakeType::fromString('rim_brake'),
        wheelSize: WheelSize::fromString('700c')
    );

    $product->update(
        title: Title::fromString('Updated Title'),
        price: Price::fromAmount(1500)
    );

    expect($product->getTitle()->toString())->toBe('Updated Title')
        ->and($product->getPrice()->getAmount())->toBe(1500.00);
});

test('product can change status', function () {
    $product = Product::create(
        sellerId: 1,
        title: Title::fromString('Test'),
        description: 'Test',
        price: Price::fromAmount(1000),
        bikeType: BikeType::fromString('road'),
        frameMaterial: FrameMaterial::fromString('carbon'),
        brakeType: BrakeType::fromString('rim_brake'),
        wheelSize: WheelSize::fromString('700c')
    );

    $product->changeStatus('active');

    expect($product->getStatus())->toBe('active');
});

test('product can assign certification', function () {
    $product = Product::create(
        sellerId: 1,
        title: Title::fromString('Test'),
        description: 'Test',
        price: Price::fromAmount(1000),
        bikeType: BikeType::fromString('road'),
        frameMaterial: FrameMaterial::fromString('carbon'),
        brakeType: BrakeType::fromString('rim_brake'),
        wheelSize: WheelSize::fromString('700c')
    );

    $product->assignCertification(1);

    expect($product->isCertified())->toBeTrue()
        ->and($product->getCertificationId())->toBe(1);
});

