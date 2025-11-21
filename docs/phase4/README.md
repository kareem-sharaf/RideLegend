# Phase 4: Orders, Payments, Trade-in, Warranty & Shipping
## Complete Documentation

**Version:** 1.0  
**Status:** 🚧 In Progress  
**Date:** 2024

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Domain Layer](#domain-layer)
4. [Database Schema](#database-schema)
5. [Workflows](#workflows)
6. [API Endpoints](#api-endpoints)
7. [Implementation Status](#implementation-status)

---

## Overview

Phase 4 يهدف إلى بناء الجزء التجاري الكامل للمنصة، ويتضمن:

1. **نظام الدفع Checkout** - دفع كامل عبر المنصة مع دعم Stripe/PayPal/بوابة محلية
2. **نظام البيع Orders** - سلة + Checkout + إدارة الطلبات
3. **نظام Trade-in** - تقييم الدراجات القديمة وتطبيقها كرصيد خصم
4. **نظام الضمان Warranty** - ضمانات مجانية/مدفوعة مرتبطة بالطلبات
5. **الشحن والتوصيل** - تسعير الشحن، إنشاء Labels، تتبع الشحنات

---

## Architecture

### Clean Architecture Layers

#### Domain Layer
- **Order Aggregate**: Order, OrderItem
- **Payment Aggregate**: Payment
- **TradeIn Aggregate**: TradeIn
- **Warranty Entity**: Warranty
- **Shipping Aggregate**: Shipping

#### Application Layer
- Use Cases for all business operations
- DTOs for data transfer
- Mappers for domain/application conversion

#### Infrastructure Layer
- Repository Implementations (Eloquent)
- Payment Services (Stripe, PayPal, Local Gateway)
- Shipping Services (Rate Calculator, Label Generator)
- Trade-in Valuation Service

#### Interface Layer
- Controllers (REST API + Web)
- Form Requests (Validation)
- API Resources (Transformers)
- Blade Views (UI)

---

## Domain Layer

### Order Aggregate

**Location**: `app/Domain/Order/`

**Components**:
- `Models/Order.php` - Aggregate Root
- `Models/OrderItem.php` - Entity
- `ValueObjects/OrderNumber.php` - Unique order identifier
- `ValueObjects/OrderStatus.php` - Order state management
- `Events/OrderCreated.php` - Domain event
- `Events/OrderStatusChanged.php` - Domain event
- `Repositories/OrderRepositoryInterface.php` - Repository contract

**Order Status Flow**:
```
draft → pending → confirmed → processing → shipped → delivered
                                    ↓
                                cancelled / refunded
```

### Payment Aggregate

**Location**: `app/Domain/Payment/`

**Components**:
- `Models/Payment.php` - Aggregate Root
- `ValueObjects/PaymentMethod.php` - Payment method types
- `ValueObjects/PaymentStatus.php` - Payment state
- `Events/PaymentCompleted.php` - Domain event
- `Events/PaymentFailed.php` - Domain event
- `Repositories/PaymentRepositoryInterface.php` - Repository contract

**Payment Methods**:
- `credit_card` - Credit card payment
- `paypal` - PayPal payment
- `stripe` - Stripe payment
- `trade_in_credit` - Trade-in credit
- `bank_transfer` - Bank transfer
- `local_gateway` - Local payment gateway

**Payment Status Flow**:
```
pending → processing → completed / failed
                          ↓
                      refunded
```

### TradeIn Aggregate

**Location**: `app/Domain/TradeIn/`

**Components**:
- `Models/TradeIn.php` - Aggregate Root
- `ValueObjects/TradeInStatus.php` - Trade-in state
- `Events/TradeInValuated.php` - Domain event
- `Events/TradeInApproved.php` - Domain event
- `Events/TradeInRejected.php` - Domain event
- `Repositories/TradeInRepositoryInterface.php` - Repository contract

**Trade-in Status Flow**:
```
pending → valuated → approved → completed
                ↓
            rejected
```

### Warranty Entity

**Location**: `app/Domain/Warranty/`

**Components**:
- `Models/Warranty.php` - Entity
- `Repositories/WarrantyRepositoryInterface.php` - Repository contract

**Warranty Types**:
- `free` - Free warranty
- `paid` - Paid warranty
- `extended` - Extended warranty

### Shipping Aggregate

**Location**: `app/Domain/Shipping/`

**Components**:
- `Models/Shipping.php` - Aggregate Root
- `ValueObjects/ShippingStatus.php` - Shipping state
- `Repositories/ShippingRepositoryInterface.php` - Repository contract

**Shipping Status Flow**:
```
pending → label_created → picked_up → in_transit → 
out_for_delivery → delivered
                    ↓
                exception
```

---

## Database Schema

### Core Tables

#### orders
- `id` - Primary key
- `order_number` - Unique order identifier
- `buyer_id` - Foreign key to users
- `status` - Order status (enum)
- `subtotal`, `tax`, `shipping_cost`, `discount`, `total` - Decimal amounts
- `currency` - Currency code (default: USD)
- `placed_at` - Timestamp when order was placed

#### order_items
- `id` - Primary key
- `order_id` - Foreign key to orders
- `product_id` - Foreign key to products
- `quantity` - Item quantity
- `unit_price`, `total_price` - Decimal amounts

#### payments
- `id` - Primary key
- `order_id` - Foreign key to orders
- `user_id` - Foreign key to users
- `payment_method` - Payment method (enum)
- `amount` - Payment amount
- `status` - Payment status (enum)
- `transaction_id` - Gateway transaction ID
- `gateway_response` - JSON response from gateway

#### trade_ins
- `id` - Primary key
- `buyer_id` - Foreign key to users
- `status` - Trade-in status (enum)
- `requested_at`, `approved_at`, `rejected_at` - Timestamps

#### credits
- `id` - Primary key
- `user_id` - Foreign key to users
- `trade_in_id` - Foreign key to trade_ins (nullable)
- `amount`, `balance` - Decimal amounts
- `status` - Credit status (enum)
- `expires_at` - Expiration timestamp

#### warranties
- `id` - Primary key
- `order_id` - Foreign key to orders
- `product_id` - Foreign key to products (nullable)
- `type` - Warranty type (enum)
- `price` - Warranty price
- `duration_months` - Warranty duration
- `starts_at`, `expires_at` - Timestamps

#### shippings
- `id` - Primary key
- `order_id` - Foreign key to orders
- `carrier` - Shipping carrier name
- `service_type` - Service type (enum)
- `status` - Shipping status (enum)
- `tracking_number` - Unique tracking number
- `cost` - Shipping cost
- `shipped_at`, `delivered_at` - Timestamps

---

## Workflows

### Order Creation Workflow

```
1. User adds items to cart
2. User proceeds to checkout
3. System calculates totals (subtotal, tax, shipping, discount)
4. User selects payment method
5. Payment is processed
6. Order is created with status "pending"
7. Payment is completed
8. Order status changes to "confirmed"
9. Order status changes to "processing"
10. Shipping label is created
11. Order status changes to "shipped"
12. Order status changes to "delivered"
```

### Trade-in Workflow

```
1. User submits trade-in request (bike details, images, specs)
2. System valuates the bike
3. Trade-in status changes to "valuated"
4. Admin reviews and approves/rejects
5. If approved:
   - Trade-in status changes to "approved"
   - Credit is generated for user
   - Credit can be applied to orders
6. Trade-in status changes to "completed"
```

### Payment Processing Workflow

```
1. Payment is created with status "pending"
2. Payment gateway is called
3. Payment status changes to "processing"
4. Gateway responds:
   - Success: Payment status changes to "completed"
   - Failure: Payment status changes to "failed"
5. If refund needed: Payment status changes to "refunded"
```

---

## API Endpoints

### Cart Endpoints
- `GET /api/cart` - Get user's cart
- `POST /api/cart` - Add item to cart
- `PUT /api/cart/{id}` - Update cart item
- `DELETE /api/cart/{id}` - Remove item from cart
- `DELETE /api/cart` - Clear cart

### Checkout Endpoints
- `POST /api/checkout` - Process checkout
- `GET /api/checkout/summary` - Get checkout summary

### Order Endpoints
- `GET /api/orders` - Get user's orders
- `GET /api/orders/{id}` - Get order details
- `POST /api/orders/{id}/cancel` - Cancel order

### Payment Endpoints
- `POST /api/payments` - Create payment
- `GET /api/payments/{id}` - Get payment details
- `POST /api/payments/{id}/refund` - Refund payment

### Trade-in Endpoints
- `POST /api/trade-ins` - Submit trade-in request
- `GET /api/trade-ins` - Get user's trade-ins
- `GET /api/trade-ins/{id}` - Get trade-in details

### Shipping Endpoints
- `GET /api/shipping/rates` - Calculate shipping rates
- `POST /api/shipping/labels` - Create shipping label
- `GET /api/shipping/{id}/track` - Track shipping

---

## Implementation Status

### ✅ Completed
- Database Migrations (13 tables)
- Domain Layer (Order, Payment, TradeIn, Warranty, Shipping)
- Eloquent Models (13 models)
- Repository Interfaces

### 🚧 In Progress
- Application Layer (Use Cases)
- Infrastructure Layer (Repository Implementations, Services)
- Interface Layer (Controllers, Views)

### ⏳ Pending
- Payment Gateway Integrations (Stripe, PayPal)
- Shipping Service Integrations
- PDF Invoice Generation
- Tests
- Documentation Completion

---

**Last Updated**: 2024

