# DevOps + Clean Code Implementation Plan
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Phase 1 - Discovery & Architecture

---

## Table of Contents

1. [Overview](#1-overview)
2. [Architecture Structure](#2-architecture-structure)
3. [Code Practices](#3-code-practices)
4. [SOLID Principles Implementation](#4-solid-principles-implementation)
5. [Design Patterns Implementation](#5-design-patterns-implementation)
6. [Exception Handling Structure](#6-exception-handling-structure)
7. [Logging & Monitoring Structure](#7-logging--monitoring-structure)
8. [CI/CD Pipeline](#8-cicd-pipeline)
9. [Git Branching Model](#9-git-branching-model)
10. [Testing Strategy](#10-testing-strategy)
11. [Environment Structure](#11-environment-structure)

---

## 1. Overview

This document outlines the technical implementation plan for the Premium Bikes Managed Marketplace, focusing on Clean Architecture, SOLID principles, DDD, and proper design patterns. The plan ensures scalability, maintainability, and code quality throughout the project lifecycle.

### 1.1 Objectives
- Implement Clean Architecture with clear layer separation
- Apply SOLID principles consistently
- Use Domain-Driven Design with bounded contexts
- Implement appropriate design patterns
- Establish robust CI/CD pipeline
- Ensure high test coverage (≥80%)
- Maintain code quality standards

---

## 2. Architecture Structure

### 2.1 Directory Structure

```
app/
├── Domain/                          # Domain Layer (Core Business Logic)
│   ├── Product/
│   │   ├── Models/
│   │   │   ├── Product.php         # Aggregate Root
│   │   │   ├── ProductCategory.php # Entity
│   │   │   └── ProductImage.php    # Entity
│   │   ├── ValueObjects/
│   │   │   ├── Price.php
│   │   │   ├── Dimensions.php
│   │   │   └── ProductSpecification.php
│   │   ├── States/
│   │   │   └── ProductStatus.php
│   │   ├── Events/
│   │   │   ├── ProductCreated.php
│   │   │   └── ProductCertified.php
│   │   ├── Services/
│   │   │   ├── ProductSearchService.php
│   │   │   └── PricingService.php
│   │   └── Repositories/
│   │       └── ProductRepositoryInterface.php
│   ├── Inspection/
│   │   ├── Models/
│   │   │   ├── Inspection.php      # Aggregate Root
│   │   │   ├── InspectionChecklist.php
│   │   │   └── Certification.php
│   │   ├── ValueObjects/
│   │   │   ├── InspectionStatus.php
│   │   │   └── Appointment.php
│   │   ├── States/
│   │   │   ├── InspectionState.php
│   │   │   ├── PendingState.php
│   │   │   ├── ScheduledState.php
│   │   │   ├── InProgressState.php
│   │   │   └── CompletedState.php
│   │   ├── Events/
│   │   │   ├── InspectionRequested.php
│   │   │   ├── InspectionCompleted.php
│   │   │   └── CertificationIssued.php
│   │   ├── Services/
│   │   │   ├── InspectionSchedulingService.php
│   │   │   └── CertificationService.php
│   │   └── Repositories/
│   │       └── InspectionRepositoryInterface.php
│   ├── Order/
│   │   ├── Models/
│   │   │   ├── Order.php            # Aggregate Root
│   │   │   ├── OrderItem.php
│   │   │   └── Payment.php
│   │   ├── ValueObjects/
│   │   │   ├── ShippingAddress.php
│   │   │   ├── OrderTotal.php
│   │   │   └── PaymentAmount.php
│   │   ├── States/
│   │   │   ├── OrderState.php
│   │   │   └── PaymentState.php
│   │   ├── Events/
│   │   │   ├── OrderPlaced.php
│   │   │   ├── PaymentProcessed.php
│   │   │   └── OrderShipped.php
│   │   ├── Services/
│   │   │   ├── OrderService.php
│   │   │   └── PaymentService.php
│   │   └── Repositories/
│   │       ├── OrderRepositoryInterface.php
│   │       └── PaymentRepositoryInterface.php
│   ├── TradeIn/
│   │   ├── Models/
│   │   │   ├── TradeIn.php          # Aggregate Root
│   │   │   ├── Valuation.php
│   │   │   └── Credit.php
│   │   ├── ValueObjects/
│   │   │   ├── TradeInCondition.php
│   │   │   └── ValuationAmount.php
│   │   ├── States/
│   │   │   └── TradeInState.php
│   │   ├── Events/
│   │   │   ├── TradeInRequested.php
│   │   │   ├── TradeInValuated.php
│   │   │   └── TradeInApproved.php
│   │   ├── Services/
│   │   │   └── ValuationService.php
│   │   └── Repositories/
│   │       └── TradeInRepositoryInterface.php
│   ├── Shipping/
│   │   ├── Models/
│   │   │   ├── Shipping.php         # Aggregate Root
│   │   │   └── TrackingInfo.php
│   │   ├── ValueObjects/
│   │   │   ├── ShippingRate.php
│   │   │   └── TrackingNumber.php
│   │   ├── Services/
│   │   │   ├── ShippingCalculationService.php
│   │   │   └── TrackingService.php
│   │   └── Repositories/
│   │       └── ShippingRepositoryInterface.php
│   ├── Workshop/
│   │   ├── Models/
│   │   │   ├── Workshop.php         # Aggregate Root
│   │   │   └── Appointment.php
│   │   ├── ValueObjects/
│   │   │   └── AppointmentSlot.php
│   │   └── Repositories/
│   │       └── WorkshopRepositoryInterface.php
│   ├── User/
│   │   ├── Models/
│   │   │   ├── User.php             # Aggregate Root
│   │   │   └── Role.php
│   │   ├── ValueObjects/
│   │   │   ├── Email.php
│   │   │   └── PhoneNumber.php
│   │   └── Repositories/
│   │       └── UserRepositoryInterface.php
│   └── Shared/
│       ├── Exceptions/
│       │   ├── DomainException.php
│       │   └── BusinessRuleViolationException.php
│       └── Events/
│           └── DomainEvent.php
│
├── Application/                      # Application Layer (Use Cases)
│   ├── Product/
│   │   ├── Actions/
│   │   │   ├── CreateProductListingAction.php
│   │   │   ├── UpdateProductAction.php
│   │   │   ├── SearchProductsAction.php
│   │   │   └── GetProductDetailsAction.php
│   │   ├── DTOs/
│   │   │   ├── ProductListingDTO.php
│   │   │   └── ProductSearchDTO.php
│   │   ├── Mappers/
│   │   │   └── ProductMapper.php
│   │   └── Validators/
│   │       └── ProductValidator.php
│   ├── Inspection/
│   │   ├── Actions/
│   │   │   ├── RequestInspectionAction.php
│   │   │   ├── ScheduleInspectionAction.php
│   │   │   ├── ExecuteInspectionAction.php
│   │   │   └── IssueCertificationAction.php
│   │   ├── DTOs/
│   │   │   └── InspectionDTO.php
│   │   └── Mappers/
│   │       └── InspectionMapper.php
│   ├── Order/
│   │   ├── Actions/
│   │   │   ├── InitiateCheckoutAction.php
│   │   │   ├── ProcessPaymentAction.php
│   │   │   └── GetOrderDetailsAction.php
│   │   ├── DTOs/
│   │   │   ├── OrderDTO.php
│   │   │   └── PaymentDTO.php
│   │   └── Mappers/
│   │       └── OrderMapper.php
│   └── TradeIn/
│       ├── Actions/
│       │   ├── SubmitTradeInRequestAction.php
│       │   ├── CalculateValuationAction.php
│       │   └── ApproveTradeInAction.php
│       └── DTOs/
│           └── TradeInDTO.php
│
├── Infrastructure/                   # Infrastructure Layer
│   ├── Repositories/
│   │   ├── Product/
│   │   │   └── EloquentProductRepository.php
│   │   ├── Inspection/
│   │   │   └── EloquentInspectionRepository.php
│   │   ├── Order/
│   │   │   └── EloquentOrderRepository.php
│   │   └── TradeIn/
│   │       └── EloquentTradeInRepository.php
│   ├── Services/
│   │   ├── Payment/
│   │   │   ├── StripePaymentService.php
│   │   │   └── PayPalPaymentService.php
│   │   ├── Shipping/
│   │   │   ├── UspsShippingService.php
│   │   │   └── FedexShippingService.php
│   │   └── Notification/
│   │       ├── EmailNotificationService.php
│   │       └── SmsNotificationService.php
│   ├── Strategies/
│   │   ├── Payment/
│   │   │   ├── CreditCardStrategy.php
│   │   │   ├── PayPalStrategy.php
│   │   │   └── TradeInCreditStrategy.php
│   │   ├── Shipping/
│   │   │   ├── StandardShippingStrategy.php
│   │   │   ├── ExpressShippingStrategy.php
│   │   │   └── InternationalShippingStrategy.php
│   │   └── Valuation/
│   │       ├── MarketValueStrategy.php
│   │       └── ConditionBasedStrategy.php
│   ├── Factories/
│   │   ├── ProductFactory.php
│   │   ├── InspectionFactory.php
│   │   ├── PaymentStrategyFactory.php
│   │   └── ShippingStrategyFactory.php
│   ├── Database/
│   │   ├── Casts/
│   │   │   ├── PriceCast.php
│   │   │   └── AddressCast.php
│   │   └── Migrations/
│   └── Events/
│       └── LaravelEventDispatcher.php
│
└── Http/                             # Interface Layer
    ├── Controllers/
    │   ├── ProductController.php
    │   ├── InspectionController.php
    │   ├── OrderController.php
    │   └── TradeInController.php
    ├── Requests/
    │   ├── CreateProductRequest.php
    │   ├── ProcessPaymentRequest.php
    │   └── RequestInspectionRequest.php
    ├── Resources/
    │   ├── ProductResource.php
    │   ├── OrderResource.php
    │   └── InspectionResource.php
    └── Middleware/
        ├── Authenticate.php
        └── AuthorizeRole.php
```

### 2.2 Layer Responsibilities

#### Domain Layer
- **Purpose**: Core business logic, independent of framework
- **Contains**: Aggregates, Entities, Value Objects, Domain Services, Domain Events
- **Dependencies**: None (pure PHP)
- **Rules**: No framework dependencies, no infrastructure concerns

#### Application Layer
- **Purpose**: Use cases, orchestration, application-specific logic
- **Contains**: Actions (Use Cases), DTOs, Mappers, Validators
- **Dependencies**: Domain Layer only
- **Rules**: Depends on Domain interfaces, not implementations

#### Infrastructure Layer
- **Purpose**: External concerns, framework-specific implementations
- **Contains**: Repository implementations, External services, Factories, Strategies
- **Dependencies**: Domain Layer (implements interfaces)
- **Rules**: Implements Domain interfaces, handles external integrations

#### Interface Layer
- **Purpose**: HTTP handling, API endpoints, web controllers
- **Contains**: Controllers, Form Requests, Resources, Middleware
- **Dependencies**: Application Layer
- **Rules**: Thin controllers, delegate to Application layer

---

## 3. Code Practices

### 3.1 Coding Standards

#### PSR Standards
- **PSR-1**: Basic Coding Standard
- **PSR-12**: Extended Coding Style Guide
- **PSR-4**: Autoloading Standard

#### Laravel Conventions
- Follow Laravel naming conventions
- Use Laravel's built-in features where appropriate
- Leverage Eloquent for data access (in Infrastructure layer)

#### Code Quality Tools
- **Laravel Pint**: Code formatting (PSR-12)
- **PHPStan**: Static analysis (Level 5 minimum)
- **PHP CS Fixer**: Code style enforcement
- **Psalm**: Additional static analysis

### 3.2 Repository Pattern Implementation

#### Interface Definition (Domain Layer)
```php
// app/Domain/Product/Repositories/ProductRepositoryInterface.php
namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use App\Domain\Product\ValueObjects\SearchCriteria;

interface ProductRepositoryInterface
{
    public function save(Product $product): Product;
    public function findById(int $id): ?Product;
    public function findBySellerId(int $sellerId): array;
    public function search(SearchCriteria $criteria): array;
    public function delete(Product $product): void;
}
```

#### Implementation (Infrastructure Layer)
```php
// app/Infrastructure/Repositories/Product/EloquentProductRepository.php
namespace App\Infrastructure\Repositories\Product;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\SearchCriteria;
use App\Models\Product as EloquentProduct;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(Product $product): Product
    {
        $eloquent = EloquentProduct::updateOrCreate(
            ['id' => $product->getId()],
            $this->toArray($product)
        );
        
        return $this->toDomain($eloquent);
    }
    
    // ... other methods
}
```

### 3.3 Use Case Pattern Implementation

#### Action Structure
```php
// app/Application/Product/Actions/CreateProductListingAction.php
namespace App\Application\Product\Actions;

use App\Application\Product\DTOs\ProductListingDTO;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\Events\ProductCreated;
use Illuminate\Contracts\Events\Dispatcher;

class CreateProductListingAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private Dispatcher $eventDispatcher
    ) {}
    
    public function execute(ProductListingDTO $dto): Product
    {
        // Validation
        $this->validate($dto);
        
        // Create domain model
        $product = Product::create(
            $dto->sellerId,
            $dto->title,
            $dto->price,
            // ... other attributes
        );
        
        // Persist
        $product = $this->productRepository->save($product);
        
        // Dispatch event
        $this->eventDispatcher->dispatch(
            new ProductCreated($product)
        );
        
        return $product;
    }
    
    private function validate(ProductListingDTO $dto): void
    {
        // Business rule validation
    }
}
```

### 3.4 DTO Pattern Implementation

#### DTO Definition
```php
// app/Application/Product/DTOs/ProductListingDTO.php
namespace App\Application\Product\DTOs;

class ProductListingDTO
{
    public function __construct(
        public readonly int $sellerId,
        public readonly string $title,
        public readonly string $description,
        public readonly float $price,
        public readonly string $brand,
        public readonly string $model,
        public readonly ?int $year = null,
        // ... other properties
    ) {}
    
    public static function fromArray(array $data): self
    {
        return new self(
            sellerId: $data['seller_id'],
            title: $data['title'],
            description: $data['description'],
            price: $data['price'],
            brand: $data['brand'],
            model: $data['model'],
            year: $data['year'] ?? null,
        );
    }
}
```

### 3.5 Form Request Validation

```php
// app/Http/Requests/CreateProductRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            // ... other rules
        ];
    }
    
    public function authorize(): bool
    {
        return $this->user()->hasRole('seller');
    }
}
```

---

## 4. SOLID Principles Implementation

### 4.1 Single Responsibility Principle (SRP)

#### Example: Separate Concerns
```php
// ❌ Bad: Multiple responsibilities
class ProductManager
{
    public function createProduct() { }
    public function sendEmail() { }
    public function generateReport() { }
}

// ✅ Good: Single responsibility
class CreateProductAction { } // Only creates products
class EmailService { } // Only handles emails
class ReportGenerator { } // Only generates reports
```

### 4.2 Open/Closed Principle (OCP)

#### Example: Strategy Pattern
```php
// ✅ Open for extension, closed for modification
interface PaymentStrategy
{
    public function processPayment(float $amount, array $data): PaymentResult;
}

class CreditCardStrategy implements PaymentStrategy { }
class PayPalStrategy implements PaymentStrategy { }
class TradeInCreditStrategy implements PaymentStrategy { }

// Adding new payment method doesn't require changing existing code
```

### 4.3 Liskov Substitution Principle (LSP)

#### Example: Repository Implementations
```php
// ✅ All implementations are interchangeable
interface ProductRepositoryInterface { }

class EloquentProductRepository implements ProductRepositoryInterface { }
class InMemoryProductRepository implements ProductRepositoryInterface { }
// Can swap implementations without breaking code
```

### 4.4 Interface Segregation Principle (ISP)

#### Example: Focused Interfaces
```php
// ❌ Bad: Fat interface
interface ProductRepositoryInterface
{
    public function save();
    public function delete();
    public function sendEmail();
    public function generateReport();
}

// ✅ Good: Segregated interfaces
interface ProductRepositoryInterface
{
    public function save(Product $product): Product;
    public function findById(int $id): ?Product;
}

interface ProductEmailServiceInterface
{
    public function sendProductCreatedEmail(Product $product): void;
}
```

### 4.5 Dependency Inversion Principle (DIP)

#### Example: Depend on Abstractions
```php
// ✅ High-level module depends on abstraction
class CreateProductAction
{
    public function __construct(
        private ProductRepositoryInterface $repository, // Interface, not implementation
        private EventDispatcherInterface $eventDispatcher
    ) {}
}

// Infrastructure provides implementation
class EloquentProductRepository implements ProductRepositoryInterface { }
```

---

## 5. Design Patterns Implementation

### 5.1 Strategy Pattern

#### Payment Strategy
```php
// Domain Interface
interface PaymentStrategy
{
    public function processPayment(float $amount, array $data): PaymentResult;
}

// Implementations
class CreditCardStrategy implements PaymentStrategy
{
    public function processPayment(float $amount, array $data): PaymentResult
    {
        // Stripe integration
    }
}

class PayPalStrategy implements PaymentStrategy
{
    public function processPayment(float $amount, array $data): PaymentResult
    {
        // PayPal integration
    }
}

// Factory
class PaymentStrategyFactory
{
    public function create(string $method): PaymentStrategy
    {
        return match($method) {
            'credit_card' => new CreditCardStrategy(),
            'paypal' => new PayPalStrategy(),
            'trade_in_credit' => new TradeInCreditStrategy(),
            default => throw new InvalidPaymentMethodException(),
        };
    }
}
```

### 5.2 State Pattern

#### Inspection State
```php
// State Interface
interface InspectionState
{
    public function schedule(Inspection $inspection): void;
    public function start(Inspection $inspection): void;
    public function complete(Inspection $inspection): void;
}

// Concrete States
class PendingState implements InspectionState
{
    public function schedule(Inspection $inspection): void
    {
        $inspection->setState(new ScheduledState());
    }
    
    public function start(Inspection $inspection): void
    {
        throw new InvalidStateTransitionException();
    }
}

class ScheduledState implements InspectionState
{
    public function start(Inspection $inspection): void
    {
        $inspection->setState(new InProgressState());
    }
}

// Usage in Aggregate
class Inspection
{
    private InspectionState $state;
    
    public function schedule(): void
    {
        $this->state->schedule($this);
    }
}
```

### 5.3 Factory Pattern

#### Product Factory
```php
class ProductFactory
{
    public function create(
        int $sellerId,
        string $title,
        float $price,
        // ... other parameters
    ): Product {
        return new Product(
            id: null, // New product
            sellerId: $sellerId,
            title: $title,
            price: Price::fromAmount($price),
            status: ProductStatus::draft(),
            // ... other attributes
        );
    }
    
    public function createFromArray(array $data): Product
    {
        return $this->create(
            sellerId: $data['seller_id'],
            title: $data['title'],
            price: $data['price'],
            // ...
        );
    }
}
```

### 5.4 Observer Pattern

#### Domain Events
```php
// Domain Event
class ProductCreated extends DomainEvent
{
    public function __construct(
        public readonly Product $product
    ) {
        parent::__construct();
    }
}

// Event Listener
class SendProductCreatedNotification
{
    public function handle(ProductCreated $event): void
    {
        // Send notification
    }
}

// Registration in EventServiceProvider
protected $listen = [
    ProductCreated::class => [
        SendProductCreatedNotification::class,
    ],
];
```

### 5.5 Repository Pattern

See section 3.2 for detailed implementation.

---

## 6. Exception Handling Structure

### 6.1 Exception Hierarchy

```
Exception
├── DomainException (Domain Layer)
│   ├── BusinessRuleViolationException
│   ├── InvalidStateTransitionException
│   └── EntityNotFoundException
├── ApplicationException (Application Layer)
│   ├── ValidationException
│   └── UseCaseException
└── InfrastructureException (Infrastructure Layer)
    ├── PaymentProcessingException
    └── ShippingServiceException
```

### 6.2 Exception Implementation

```php
// Domain Exception
namespace App\Domain\Shared\Exceptions;

class BusinessRuleViolationException extends DomainException
{
    public function __construct(
        string $message,
        private readonly string $rule,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    public function getRule(): string
    {
        return $this->rule;
    }
}

// Usage
if ($product->getPrice()->getAmount() < 0) {
    throw new BusinessRuleViolationException(
        'Product price cannot be negative',
        'PRICE_MUST_BE_POSITIVE'
    );
}
```

### 6.3 Global Exception Handler

```php
// app/Exceptions/Handler.php
public function render($request, Throwable $exception)
{
    if ($exception instanceof BusinessRuleViolationException) {
        return response()->json([
            'error' => $exception->getMessage(),
            'rule' => $exception->getRule(),
        ], 422);
    }
    
    if ($exception instanceof EntityNotFoundException) {
        return response()->json([
            'error' => 'Resource not found',
        ], 404);
    }
    
    return parent::render($request, $exception);
}
```

---

## 7. Logging & Monitoring Structure

### 7.1 Logging Strategy

#### Log Channels
```php
// config/logging.php
'channels' => [
    'domain' => [
        'driver' => 'daily',
        'path' => storage_path('logs/domain.log'),
        'level' => 'info',
    ],
    'application' => [
        'driver' => 'daily',
        'path' => storage_path('logs/application.log'),
        'level' => 'info',
    ],
    'infrastructure' => [
        'driver' => 'daily',
        'path' => storage_path('logs/infrastructure.log'),
        'level' => 'debug',
    ],
    'payment' => [
        'driver' => 'daily',
        'path' => storage_path('logs/payment.log'),
        'level' => 'info',
    ],
],
```

#### Logging in Code
```php
// Domain Events
class ProductCreated extends DomainEvent
{
    public function __construct(public readonly Product $product)
    {
        parent::__construct();
        Log::channel('domain')->info('Product created', [
            'product_id' => $product->getId(),
            'seller_id' => $product->getSellerId(),
        ]);
    }
}

// Use Cases
class ProcessPaymentAction
{
    public function execute(PaymentDTO $dto): Payment
    {
        Log::channel('payment')->info('Payment processing started', [
            'order_id' => $dto->orderId,
            'amount' => $dto->amount,
        ]);
        
        try {
            // Process payment
        } catch (PaymentProcessingException $e) {
            Log::channel('payment')->error('Payment processing failed', [
                'order_id' => $dto->orderId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
```

### 7.2 Monitoring

#### Key Metrics
- **Application Performance**: Response times, throughput
- **Error Rates**: Exception counts by type
- **Business Metrics**: Orders placed, products listed, inspections completed
- **Infrastructure**: Server resources, database performance

#### Tools
- **Laravel Telescope**: Development debugging
- **Laravel Horizon**: Queue monitoring
- **Sentry**: Error tracking (production)
- **New Relic / DataDog**: APM (optional)

---

## 8. CI/CD Pipeline

### 8.1 Pipeline Stages

```yaml
# .github/workflows/ci.yml
name: CI/CD Pipeline

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main, develop]

jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install Dependencies
        run: composer install
      - name: Run Pint
        run: ./vendor/bin/pint --test
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse
      - name: Run Tests
        run: ./vendor/bin/pest --coverage
      - name: Upload Coverage
        uses: codecov/codecov-action@v3

  deploy-staging:
    needs: tests
    if: github.ref == 'refs/heads/develop'
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Staging
        run: |
          # Deployment script

  deploy-production:
    needs: tests
    if: github.ref == 'refs/heads/main'
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Production
        run: |
          # Deployment script
```

### 8.2 Pipeline Steps

1. **Code Quality**
   - Laravel Pint (formatting)
   - PHPStan (static analysis)
   - PHP CS Fixer (style check)

2. **Testing**
   - Unit tests
   - Feature tests
   - Integration tests
   - Coverage report (minimum 80%)

3. **Security**
   - Dependency scanning
   - Security audit

4. **Deployment**
   - Build artifacts
   - Deploy to environment
   - Run migrations
   - Clear cache

---

## 9. Git Branching Model

### 9.1 Gitflow Model

```
main (production)
  │
  ├── develop (integration)
  │     │
  │     ├── feature/product-listing
  │     ├── feature/inspection-workflow
  │     └── feature/payment-integration
  │
  ├── release/v1.0.0
  │
  └── hotfix/critical-bug
```

### 9.2 Branch Naming Conventions

- **Feature**: `feature/description` (e.g., `feature/product-search`)
- **Bugfix**: `bugfix/description` (e.g., `bugfix/payment-error`)
- **Hotfix**: `hotfix/description` (e.g., `hotfix/security-patch`)
- **Release**: `release/version` (e.g., `release/v1.0.0`)

### 9.3 Commit Message Format

```
type(scope): subject

body (optional)

footer (optional)
```

**Types**: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

**Example**:
```
feat(product): add product search functionality

Implement search with filters for brand, price range, and condition.
Add full-text search support using MySQL fulltext indexes.

Closes #123
```

---

## 10. Testing Strategy

### 10.1 Testing Pyramid

```
        /\
       /  \      E2E Tests (10%)
      /____\     
     /      \    Integration Tests (20%)
    /________\   
   /          \  Unit Tests (70%)
  /____________\
```

### 10.2 Test Types

#### Unit Tests
- **Location**: `tests/Unit/`
- **Coverage**: Domain models, Value Objects, Services
- **Framework**: Pest PHP
- **Target**: 100% coverage for Domain layer

```php
// tests/Unit/Domain/Product/ProductTest.php
test('product cannot have negative price', function () {
    expect(fn() => new Product(
        sellerId: 1,
        title: 'Test',
        price: Price::fromAmount(-100)
    ))->toThrow(BusinessRuleViolationException::class);
});
```

#### Feature Tests
- **Location**: `tests/Feature/`
- **Coverage**: Use cases, API endpoints
- **Framework**: Pest PHP
- **Target**: All use cases covered

```php
// tests/Feature/Product/CreateProductTest.php
test('seller can create product listing', function () {
    $seller = User::factory()->seller()->create();
    
    $response = $this->actingAs($seller)
        ->postJson('/api/products', [
            'title' => 'Test Bike',
            'price' => 1000,
            // ...
        ]);
    
    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'title', 'price']);
});
```

#### Integration Tests
- **Location**: `tests/Integration/`
- **Coverage**: Cross-layer interactions, external services
- **Framework**: Pest PHP

### 10.3 Test Coverage Requirements

- **Domain Layer**: 100%
- **Application Layer**: 90%
- **Infrastructure Layer**: 80%
- **Interface Layer**: 70%
- **Overall**: Minimum 80%

### 10.4 Test Data Management

- **Factories**: Laravel model factories
- **Seeders**: Test data seeders
- **Fixtures**: JSON fixtures for complex data
- **Database**: Use separate test database

---

## 11. Environment Structure

### 11.1 Environment Files

```
.env.example          # Template
.env.local            # Local development
.env.staging          # Staging environment
.env.production       # Production environment
```

### 11.2 Environment Variables

```env
# Application
APP_NAME="Premium Bikes Marketplace"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=premium_bikes
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

# Services
STRIPE_KEY=
STRIPE_SECRET=
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=

# Shipping
USPS_API_KEY=
FEDEX_API_KEY=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

### 11.3 Environment-Specific Configuration

#### Local
- Debug enabled
- Detailed error pages
- Telescope enabled
- Slower cache TTL

#### Staging
- Debug disabled
- Production-like settings
- Test payment gateways
- Monitoring enabled

#### Production
- Debug disabled
- Optimized cache
- Production payment gateways
- Full monitoring
- Error tracking (Sentry)

---

## Appendix A: Code Quality Tools Configuration

### A.1 PHPStan Configuration
```neon
# phpstan.neon
parameters:
    level: 5
    paths:
        - app/Domain
        - app/Application
    excludePaths:
        - app/Infrastructure/Repositories/*/Mappers
```

### A.2 Laravel Pint Configuration
```json
{
    "preset": "laravel",
    "rules": {
        "array_syntax": {"syntax": "short"}
    }
}
```

---

## Appendix B: Deployment Checklist

### B.1 Pre-Deployment
- [ ] All tests passing
- [ ] Code coverage ≥ 80%
- [ ] Static analysis passing
- [ ] Security audit passed
- [ ] Database migrations tested
- [ ] Environment variables configured

### B.2 Deployment
- [ ] Backup database
- [ ] Run migrations
- [ ] Clear cache
- [ ] Optimize autoloader
- [ ] Restart queue workers
- [ ] Verify deployment

### B.3 Post-Deployment
- [ ] Smoke tests
- [ ] Monitor error logs
- [ ] Check performance metrics
- [ ] Verify external integrations

---

**Document Status**: Complete  
**Next Steps**: Proceed to Project Charter

