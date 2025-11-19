# Sequence Diagrams
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Phase 1 - Discovery & Architecture

---

## Table of Contents

1. [Overview](#1-overview)
2. [Adding Product + Requesting Inspection](#2-adding-product--requesting-inspection)
3. [Checkout Flow with Payment Strategy](#3-checkout-flow-with-payment-strategy)
4. [Issuing Certified Report with State Pattern](#4-issuing-certified-report-with-state-pattern)
5. [Trade-in Flow with Domain Events](#5-trade-in-flow-with-domain-events)

---

## 1. Overview

This document contains sequence diagrams illustrating key workflows in the Premium Bikes Managed Marketplace. Each diagram follows Clean Architecture principles, highlighting:

- **Use Cases** (Application Layer)
- **Repositories** (Infrastructure Layer)
- **Domain Services** (Domain Layer)
- **Event Dispatching** (Observer Pattern)
- **State Transitions** (State Pattern)
- **Strategy Pattern** implementations

All diagrams are written in PlantUML format and can be rendered using PlantUML tools or VS Code extensions.

---

## 2. Adding Product + Requesting Inspection

### 2.1 Use Case Description

**Actor**: Seller  
**Goal**: Create a product listing and immediately request inspection  
**Preconditions**: User authenticated as seller  
**Postconditions**: Product created, inspection requested, notifications sent

### 2.2 Sequence Diagram

```plantuml
@startuml Add_Product_Request_Inspection

actor Seller
participant "ProductController\n(Interface)" as Controller
participant "CreateProductListingAction\n(Application)" as CreateAction
participant "RequestInspectionAction\n(Application)" as InspectAction
participant "ProductFactory\n(Domain)" as Factory
participant "ProductRepository\n(Infrastructure)" as ProductRepo
participant "InspectionRepository\n(Infrastructure)" as InspectRepo
participant "Product\n(Aggregate Root)" as Product
participant "Inspection\n(Aggregate Root)" as Inspection
participant "EventDispatcher\n(Infrastructure)" as Events
participant "NotificationService\n(Domain)" as NotifyService
participant "EmailService\n(Infrastructure)" as EmailService

Seller -> Controller: POST /products
activate Controller

Controller -> Controller: Validate CreateProductRequest
Controller -> CreateAction: execute(ProductListingDTO)
activate CreateAction

CreateAction -> Factory: create(ProductData)
activate Factory
Factory -> Product: new Product(...)
activate Product
Product -> Product: validate()
deactivate Product
deactivate Factory

CreateAction -> ProductRepo: save(Product)
activate ProductRepo
ProductRepo -> ProductRepo: persist to database
ProductRepo --> CreateAction: Product (persisted)
deactivate ProductRepo

CreateAction -> Events: dispatch(ProductCreated)
activate Events
Events -> NotifyService: handle(ProductCreated)
activate NotifyService
NotifyService -> EmailService: sendWelcomeEmail(Seller)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
deactivate NotifyService
deactivate Events

CreateAction --> Controller: ProductResource
deactivate CreateAction

Controller --> Seller: 201 Created + Product Data

Seller -> Controller: POST /products/{id}/inspection
activate Controller

Controller -> Controller: Validate RequestInspectionRequest
Controller -> InspectAction: execute(productId, workshopId)
activate InspectAction

InspectAction -> ProductRepo: findById(productId)
activate ProductRepo
ProductRepo --> InspectAction: Product
deactivate ProductRepo

InspectAction -> InspectAction: validateProductEligible(Product)

InspectAction -> Factory: createInspection(productId, sellerId, workshopId)
activate Factory
Factory -> Inspection: new Inspection(...)
activate Inspection
Inspection -> Inspection: setStatus(Pending)
Inspection -> Inspection: validate()
deactivate Inspection
deactivate Factory

InspectAction -> InspectRepo: save(Inspection)
activate InspectRepo
InspectRepo -> InspectRepo: persist to database
InspectRepo --> InspectAction: Inspection (persisted)
deactivate InspectRepo

InspectAction -> Events: dispatch(InspectionRequested)
activate Events
Events -> NotifyService: handle(InspectionRequested)
activate NotifyService
NotifyService -> EmailService: sendInspectionRequestEmail(Workshop)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
NotifyService -> EmailService: sendConfirmationEmail(Seller)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
deactivate NotifyService
deactivate Events

InspectAction --> Controller: InspectionResource
deactivate InspectAction

Controller --> Seller: 201 Created + Inspection Data
deactivate Controller

@enduml
```

### 2.3 Clean Architecture Highlights

- **Interface Layer**: `ProductController` handles HTTP requests
- **Application Layer**: `CreateProductListingAction`, `RequestInspectionAction` orchestrate use cases
- **Domain Layer**: `Product`, `Inspection` aggregates contain business logic
- **Infrastructure Layer**: `ProductRepository`, `InspectionRepository` handle persistence
- **Patterns**: Factory Pattern (ProductFactory), Observer Pattern (EventDispatcher), Repository Pattern

---

## 3. Checkout Flow with Payment Strategy

### 3.1 Use Case Description

**Actor**: Buyer  
**Goal**: Complete checkout with selected payment method  
**Preconditions**: Cart has items, all items certified, user authenticated  
**Postconditions**: Order created, payment processed, notifications sent

### 3.2 Sequence Diagram

```plantuml
@startuml Checkout_Flow_Payment_Strategy

actor Buyer
participant "OrderController\n(Interface)" as Controller
participant "InitiateCheckoutAction\n(Application)" as CheckoutAction
participant "ProcessPaymentAction\n(Application)" as PaymentAction
participant "CartRepository\n(Infrastructure)" as CartRepo
participant "OrderRepository\n(Infrastructure)" as OrderRepo
participant "PaymentRepository\n(Infrastructure)" as PaymentRepo
participant "Cart\n(Aggregate)" as Cart
participant "Order\n(Aggregate Root)" as Order
participant "Payment\n(Aggregate Root)" as Payment
participant "PaymentStrategyFactory\n(Domain)" as StrategyFactory
participant "PaymentStrategy\n(Domain Interface)" as StrategyInterface
participant "CreditCardStrategy\n(Infrastructure)" as CCStrategy
participant "PayPalStrategy\n(Infrastructure)" as PayPalStrategy
participant "TradeInCreditStrategy\n(Infrastructure)" as TradeInStrategy
participant "ShippingService\n(Domain)" as ShippingService
participant "EventDispatcher\n(Infrastructure)" as Events
participant "NotificationService\n(Domain)" as NotifyService

Buyer -> Controller: POST /checkout
activate Controller

Controller -> Controller: Validate CheckoutRequest
Controller -> CheckoutAction: execute(CheckoutDTO)
activate CheckoutAction

CheckoutAction -> CartRepo: findByUserId(buyerId)
activate CartRepo
CartRepo --> CheckoutAction: Cart
deactivate CartRepo

CheckoutAction -> Cart: validateItems()
activate Cart
Cart -> Cart: checkAllItemsCertified()
Cart -> Cart: calculateTotal()
Cart --> CheckoutAction: CartTotal
deactivate Cart

CheckoutAction -> ShippingService: calculateShipping(address, items)
activate ShippingService
ShippingService --> CheckoutAction: ShippingCost
deactivate ShippingService

CheckoutAction -> Order: create(cartItems, shippingAddress, totals)
activate Order
Order -> Order: setStatus(Draft)
Order -> Order: validate()
deactivate Order

CheckoutAction -> OrderRepo: save(Order)
activate OrderRepo
OrderRepo --> CheckoutAction: Order (persisted)
deactivate OrderRepo

CheckoutAction --> Controller: OrderResource
deactivate CheckoutAction

Controller --> Buyer: 201 Created + Order Data

Buyer -> Controller: POST /orders/{id}/payment
activate Controller

Controller -> Controller: Validate PaymentRequest
Controller -> PaymentAction: execute(orderId, paymentMethod, paymentData)
activate PaymentAction

PaymentAction -> OrderRepo: findById(orderId)
activate OrderRepo
OrderRepo --> PaymentAction: Order
deactivate OrderRepo

PaymentAction -> PaymentAction: validateOrderStatus(Order)

PaymentAction -> StrategyFactory: create(paymentMethod)
activate StrategyFactory

alt paymentMethod == 'credit_card'
    StrategyFactory -> CCStrategy: new CreditCardStrategy()
    activate CCStrategy
    StrategyFactory --> PaymentAction: CCStrategy
else paymentMethod == 'paypal'
    StrategyFactory -> PayPalStrategy: new PayPalStrategy()
    activate PayPalStrategy
    StrategyFactory --> PaymentAction: PayPalStrategy
else paymentMethod == 'trade_in_credit'
    StrategyFactory -> TradeInStrategy: new TradeInCreditStrategy()
    activate TradeInStrategy
    StrategyFactory --> PaymentAction: TradeInStrategy
end
deactivate StrategyFactory

PaymentAction -> StrategyInterface: processPayment(amount, paymentData)
activate StrategyInterface

alt CreditCardStrategy
    StrategyInterface -> CCStrategy: processPayment()
    activate CCStrategy
    CCStrategy -> CCStrategy: validateCardData()
    CCStrategy -> CCStrategy: callStripeAPI()
    CCStrategy --> StrategyInterface: PaymentResult
    deactivate CCStrategy
else PayPalStrategy
    StrategyInterface -> PayPalStrategy: processPayment()
    activate PayPalStrategy
    PayPalStrategy -> PayPalStrategy: validatePayPalData()
    PayPalStrategy -> PayPalStrategy: callPayPalAPI()
    PayPalStrategy --> StrategyInterface: PaymentResult
    deactivate PayPalStrategy
else TradeInCreditStrategy
    StrategyInterface -> TradeInStrategy: processPayment()
    activate TradeInStrategy
    TradeInStrategy -> TradeInStrategy: validateCreditBalance()
    TradeInStrategy -> TradeInStrategy: deductCredit()
    TradeInStrategy --> StrategyInterface: PaymentResult
    deactivate TradeInStrategy
end
deactivate StrategyInterface

PaymentAction -> Payment: create(orderId, amount, paymentMethod, result)
activate Payment
Payment -> Payment: setStatus(result.status)
Payment -> Payment: setTransactionId(result.transactionId)
Payment -> Payment: validate()
deactivate Payment

PaymentAction -> PaymentRepo: save(Payment)
activate PaymentRepo
PaymentRepo --> PaymentAction: Payment (persisted)
deactivate PaymentRepo

PaymentAction -> Order: confirmPayment(Payment)
activate Order
Order -> Order: setStatus(Confirmed)
Order -> Order: validate()
deactivate Order

PaymentAction -> OrderRepo: update(Order)
activate OrderRepo
OrderRepo --> PaymentAction: Order (updated)
deactivate OrderRepo

PaymentAction -> Events: dispatch(OrderPlaced)
activate Events
Events -> NotifyService: handle(OrderPlaced)
activate NotifyService
NotifyService -> NotifyService: sendOrderConfirmation(Buyer)
NotifyService -> NotifyService: sendOrderNotification(Seller)
deactivate NotifyService
deactivate Events

PaymentAction -> Events: dispatch(PaymentProcessed)
activate Events
Events -> NotifyService: handle(PaymentProcessed)
activate NotifyService
NotifyService -> NotifyService: sendPaymentReceipt(Buyer)
deactivate NotifyService
deactivate Events

PaymentAction --> Controller: PaymentResource
deactivate PaymentAction

Controller --> Buyer: 200 OK + Payment Data
deactivate Controller

@enduml
```

### 3.3 Clean Architecture Highlights

- **Strategy Pattern**: `PaymentStrategy` interface with multiple implementations
- **Factory Pattern**: `PaymentStrategyFactory` selects appropriate strategy
- **State Pattern**: `Order` state transitions (Draft → Confirmed)
- **Observer Pattern**: Domain events trigger notifications
- **Repository Pattern**: Data persistence abstraction

---

## 4. Issuing Certified Report with State Pattern

### 4.1 Use Case Description

**Actor**: Workshop (System)  
**Goal**: Complete inspection and issue certification report  
**Preconditions**: Inspection in "InProgress" state, all checklist items completed  
**Postconditions**: Certification issued, product status updated, notifications sent

### 4.2 Sequence Diagram

```plantuml
@startuml Issue_Certification_State_Pattern

actor Workshop
participant "InspectionController\n(Interface)" as Controller
participant "CompleteInspectionAction\n(Application)" as CompleteAction
participant "IssueCertificationAction\n(Application)" as IssueAction
participant "InspectionRepository\n(Infrastructure)" as InspectRepo
participant "CertificationRepository\n(Infrastructure)" as CertRepo
participant "ProductRepository\n(Infrastructure)" as ProductRepo
participant "Inspection\n(Aggregate Root)" as Inspection
participant "InspectionState\n(Domain)" as State
participant "PendingState\n(Concrete State)" as PendingState
participant "ScheduledState\n(Concrete State)" as ScheduledState
participant "InProgressState\n(Concrete State)" as InProgressState
participant "CompletedState\n(Concrete State)" as CompletedState
participant "Certification\n(Aggregate Root)" as Certification
participant "CertificationFactory\n(Domain)" as CertFactory
participant "Product\n(Aggregate Root)" as Product
participant "EventDispatcher\n(Infrastructure)" as Events
participant "NotificationService\n(Domain)" as NotifyService
participant "ReportGeneratorService\n(Domain)" as ReportService

Workshop -> Controller: POST /inspections/{id}/complete
activate Controller

Controller -> Controller: Validate CompleteInspectionRequest
Controller -> CompleteAction: execute(inspectionId, results)
activate CompleteAction

CompleteAction -> InspectRepo: findById(inspectionId)
activate InspectRepo
InspectRepo --> CompleteAction: Inspection
deactivate InspectRepo

CompleteAction -> Inspection: addResults(results)
activate Inspection

Inspection -> State: getCurrentState()
activate State
State --> Inspection: InProgressState
deactivate State

Inspection -> InProgressState: canComplete()
activate InProgressState
InProgressState -> InProgressState: validateAllChecklistItemsCompleted()
InProgressState --> Inspection: true
deactivate InProgressState

Inspection -> InProgressState: complete()
activate InProgressState
InProgressState -> Inspection: setState(CompletedState)
Inspection -> Inspection: setCompletedAt(now())
InProgressState --> Inspection: State transitioned
deactivate InProgressState

Inspection -> Inspection: validate()
deactivate Inspection

CompleteAction -> InspectRepo: update(Inspection)
activate InspectRepo
InspectRepo --> CompleteAction: Inspection (updated)
deactivate InspectRepo

CompleteAction -> Events: dispatch(InspectionCompleted)
activate Events
Events -> IssueAction: handle(InspectionCompleted)
activate IssueAction

IssueAction -> InspectRepo: findById(inspectionId)
activate InspectRepo
InspectRepo --> IssueAction: Inspection
deactivate InspectRepo

IssueAction -> IssueAction: validateInspectionPassed(Inspection)

IssueAction -> CertFactory: create(inspectionId, productId, workshopId, grade)
activate CertFactory
CertFactory -> Certification: new Certification(...)
activate Certification
Certification -> Certification: setStatus(Active)
Certification -> Certification: setIssuedAt(now())
Certification -> Certification: calculateExpirationDate()
Certification -> Certification: validate()
deactivate Certification
deactivate CertFactory

IssueAction -> ReportService: generateReport(Certification, Inspection)
activate ReportService
ReportService -> ReportService: createPDFReport()
ReportService -> ReportService: uploadToStorage()
ReportService --> IssueAction: reportUrl
deactivate ReportService

IssueAction -> Certification: setReportUrl(reportUrl)
activate Certification
deactivate Certification

IssueAction -> CertRepo: save(Certification)
activate CertRepo
CertRepo --> IssueAction: Certification (persisted)
deactivate CertRepo

IssueAction -> ProductRepo: findById(productId)
activate ProductRepo
ProductRepo --> IssueAction: Product
deactivate ProductRepo

IssueAction -> Product: assignCertification(Certification)
activate Product
Product -> Product: setStatus(Active)
Product -> Product: validate()
deactivate Product

IssueAction -> ProductRepo: update(Product)
activate ProductRepo
ProductRepo --> IssueAction: Product (updated)
deactivate ProductRepo

IssueAction -> Events: dispatch(CertificationIssued)
activate Events
Events -> NotifyService: handle(CertificationIssued)
activate NotifyService
NotifyService -> NotifyService: sendCertificationEmail(Seller)
NotifyService -> NotifyService: sendProductActiveNotification(Seller)
deactivate NotifyService
deactivate Events

IssueAction --> IssueAction: Certification issued
deactivate IssueAction
deactivate Events

CompleteAction --> Controller: InspectionResource
deactivate CompleteAction

Controller --> Workshop: 200 OK + Inspection Data
deactivate Controller

@enduml
```

### 4.3 Clean Architecture Highlights

- **State Pattern**: `InspectionState` interface with concrete states (Pending, Scheduled, InProgress, Completed)
- **State Transitions**: Controlled transitions via state methods
- **Factory Pattern**: `CertificationFactory` creates certification aggregates
- **Domain Service**: `ReportGeneratorService` handles report generation
- **Observer Pattern**: Events trigger certification issuance workflow

### 4.4 State Pattern Implementation Details

```php
// Domain Layer: InspectionState interface
interface InspectionState
{
    public function canSchedule(): bool;
    public function canStart(): bool;
    public function canComplete(): bool;
    public function schedule(Inspection $inspection): void;
    public function start(Inspection $inspection): void;
    public function complete(Inspection $inspection): void;
}

// Concrete States
class PendingState implements InspectionState { ... }
class ScheduledState implements InspectionState { ... }
class InProgressState implements InspectionState { ... }
class CompletedState implements InspectionState { ... }
```

---

## 5. Trade-in Flow with Domain Events

### 5.1 Use Case Description

**Actor**: Buyer  
**Goal**: Submit trade-in request, receive valuation, and get credit approval  
**Preconditions**: User authenticated as buyer  
**Postconditions**: Trade-in request created, valuation calculated, credit approved (if applicable), notifications sent

### 5.2 Sequence Diagram

```plantuml
@startuml Trade_In_Flow_Domain_Events

actor Buyer
participant "TradeInController\n(Interface)" as Controller
participant "SubmitTradeInRequestAction\n(Application)" as SubmitAction
participant "CalculateValuationAction\n(Application)" as ValuationAction
participant "ApproveTradeInAction\n(Application)" as ApproveAction
participant "TradeInRepository\n(Infrastructure)" as TradeInRepo
participant "ValuationRepository\n(Infrastructure)" as ValuationRepo
participant "CreditRepository\n(Infrastructure)" as CreditRepo
participant "TradeIn\n(Aggregate Root)" as TradeIn
participant "ValuationService\n(Domain Service)" as ValuationService
participant "ValuationStrategy\n(Domain Interface)" as StrategyInterface
participant "MarketValueStrategy\n(Infrastructure)" as MarketStrategy
participant "ConditionBasedStrategy\n(Infrastructure)" as ConditionStrategy
participant "Credit\n(Aggregate Root)" as Credit
participant "EventDispatcher\n(Infrastructure)" as Events
participant "NotificationService\n(Domain)" as NotifyService
participant "EmailService\n(Infrastructure)" as EmailService

Buyer -> Controller: POST /trade-ins
activate Controller

Controller -> Controller: Validate TradeInRequest
Controller -> SubmitAction: execute(TradeInDTO)
activate SubmitAction

SubmitAction -> TradeIn: create(buyerId, bikeDetails, condition)
activate TradeIn
TradeIn -> TradeIn: setStatus(Pending)
TradeIn -> TradeIn: validate()
deactivate TradeIn

SubmitAction -> TradeInRepo: save(TradeIn)
activate TradeInRepo
TradeInRepo --> SubmitAction: TradeIn (persisted)
deactivate TradeInRepo

SubmitAction -> Events: dispatch(TradeInRequested)
activate Events
Events -> ValuationAction: handle(TradeInRequested)
activate ValuationAction

ValuationAction -> TradeInRepo: findById(tradeInId)
activate TradeInRepo
TradeInRepo --> ValuationAction: TradeIn
deactivate TradeInRepo

ValuationAction -> ValuationService: calculateValuation(TradeIn)
activate ValuationService

ValuationService -> ValuationService: selectStrategy(condition, marketData)

alt condition == 'excellent' && marketData.available
    ValuationService -> MarketStrategy: new MarketValueStrategy()
    activate MarketStrategy
    ValuationService -> StrategyInterface: calculate(TradeIn)
    StrategyInterface -> MarketStrategy: calculate()
    MarketStrategy -> MarketStrategy: fetchMarketPrices()
    MarketStrategy -> MarketStrategy: applyMarketFactors()
    MarketStrategy --> StrategyInterface: ValuationAmount
    deactivate MarketStrategy
else
    ValuationService -> ConditionStrategy: new ConditionBasedStrategy()
    activate ConditionStrategy
    ValuationService -> StrategyInterface: calculate(TradeIn)
    StrategyInterface -> ConditionStrategy: calculate()
    ConditionStrategy -> ConditionStrategy: assessCondition()
    ConditionStrategy -> ConditionStrategy: applyDepreciation()
    ConditionStrategy --> StrategyInterface: ValuationAmount
    deactivate ConditionStrategy
end
deactivate ValuationService

ValuationAction -> Valuation: create(tradeInId, amount, strategy)
activate Valuation
Valuation -> Valuation: setCalculatedAt(now())
Valuation -> Valuation: validate()
deactivate Valuation

ValuationAction -> ValuationRepo: save(Valuation)
activate ValuationRepo
ValuationRepo --> ValuationAction: Valuation (persisted)
deactivate ValuationRepo

ValuationAction -> TradeIn: assignValuation(Valuation)
activate TradeIn
TradeIn -> TradeIn: setStatus(Valuated)
TradeIn -> TradeIn: validate()
deactivate TradeIn

ValuationAction -> TradeInRepo: update(TradeIn)
activate TradeInRepo
TradeInRepo --> ValuationAction: TradeIn (updated)
deactivate TradeInRepo

ValuationAction -> Events: dispatch(TradeInValuated)
activate Events
Events -> NotifyService: handle(TradeInValuated)
activate NotifyService
NotifyService -> EmailService: sendValuationEmail(Buyer, Valuation)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
deactivate NotifyService
deactivate Events

ValuationAction --> ValuationAction: Valuation completed
deactivate ValuationAction
deactivate Events

SubmitAction --> Controller: TradeInResource
deactivate SubmitAction

Controller --> Buyer: 201 Created + TradeIn Data

note over Buyer,EmailService: Admin reviews and approves trade-in

Admin -> Controller: POST /trade-ins/{id}/approve
activate Controller

Controller -> ApproveAction: execute(tradeInId)
activate ApproveAction

ApproveAction -> TradeInRepo: findById(tradeInId)
activate TradeInRepo
TradeInRepo --> ApproveAction: TradeIn
deactivate TradeInRepo

ApproveAction -> ApproveAction: validateTradeInApproved(TradeIn)

ApproveAction -> Credit: create(userId, tradeInId, valuationAmount)
activate Credit
Credit -> Credit: setStatus(Active)
Credit -> Credit: setBalance(valuationAmount)
Credit -> Credit: calculateExpirationDate()
Credit -> Credit: validate()
deactivate Credit

ApproveAction -> CreditRepo: save(Credit)
activate CreditRepo
CreditRepo --> ApproveAction: Credit (persisted)
deactivate CreditRepo

ApproveAction -> TradeIn: approve(Credit)
activate TradeIn
TradeIn -> TradeIn: setStatus(Approved)
TradeIn -> TradeIn: setApprovedAt(now())
TradeIn -> TradeIn: validate()
deactivate TradeIn

ApproveAction -> TradeInRepo: update(TradeIn)
activate TradeInRepo
TradeInRepo --> ApproveAction: TradeIn (updated)
deactivate TradeInRepo

ApproveAction -> Events: dispatch(TradeInApproved)
activate Events
Events -> NotifyService: handle(TradeInApproved)
activate NotifyService
NotifyService -> EmailService: sendApprovalEmail(Buyer, Credit)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
NotifyService -> EmailService: sendCreditNotification(Buyer, Credit)
activate EmailService
EmailService --> NotifyService: Email sent
deactivate EmailService
deactivate NotifyService
deactivate Events

ApproveAction --> Controller: TradeInResource
deactivate ApproveAction

Controller --> Admin: 200 OK + TradeIn Data
deactivate Controller

@enduml
```

### 5.3 Clean Architecture Highlights

- **Domain Events**: `TradeInRequested`, `TradeInValuated`, `TradeInApproved` trigger workflows
- **Strategy Pattern**: `ValuationStrategy` with multiple calculation strategies
- **Domain Service**: `ValuationService` orchestrates valuation logic
- **Event-Driven**: Asynchronous processing via event listeners
- **State Pattern**: Trade-in status transitions (Pending → Valuated → Approved)

### 5.4 Domain Events Flow

1. **TradeInRequested**: Triggers automatic valuation calculation
2. **TradeInValuated**: Notifies buyer of valuation result
3. **TradeInApproved**: Creates credit and notifies buyer

---

## Appendix A: PlantUML Rendering

### A.1 VS Code Extension
Install "PlantUML" extension by jebbs to render diagrams

### A.2 Online Renderer
Use http://www.plantuml.com/plantuml/uml/ for online rendering

### A.3 Command Line
```bash
java -jar plantuml.jar sequence-diagrams.md
```

---

## Appendix B: Diagram Conventions

### B.1 Participant Naming
- **Controllers**: `{Module}Controller (Interface)`
- **Actions**: `{Action}Action (Application)`
- **Repositories**: `{Entity}Repository (Infrastructure)`
- **Aggregates**: `{Entity} (Aggregate Root)`
- **Services**: `{Service}Service (Domain)` or `(Infrastructure)`

### B.2 Activation Boxes
- Activate/deactivate to show method execution scope
- Nested activations show call hierarchy

### B.3 Notes
- Use `note over` for important clarifications
- Use `note right/left` for side comments

### B.4 Alt Blocks
- Use `alt/else/end` for conditional flows
- Use `loop/end` for iterations (if needed)

---

**Document Status**: Complete  
**Next Steps**: Proceed to Wireframes documentation

