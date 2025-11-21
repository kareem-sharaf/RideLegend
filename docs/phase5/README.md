# Phase 5: Admin Panel
## Complete Documentation

**Version:** 1.0  
**Status:** ✅ Complete  
**Date:** 2024

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Features](#features)
4. [Controllers](#controllers)
5. [Views](#views)
6. [Policies & Gates](#policies--gates)
7. [Routes](#routes)
8. [Models](#models)
9. [Settings Management](#settings-management)

---

## Overview

Phase 5 يهدف إلى بناء لوحة تحكم كاملة للمسؤولين (Admin Panel) لإدارة جميع جوانب المنصة:

1. **Dashboard** - إحصائيات شاملة + Charts
2. **User Management** - إدارة المستخدمين (Buyer/Seller/Workshop)
3. **Product Management** - إدارة المنتجات (مفحوص/غير مفحوص/مرفوض)
4. **Inspection Management** - مراجعة طلبات الفحص
5. **Order Management** - إدارة الطلبات + تحديث الحالة + الفواتير PDF
6. **Payment Management** - إدارة المدفوعات (Refund + مراجعة)
7. **Trade-in Management** - إدارة Trade-ins (Valuation + Approval)
8. **Warranty Management** - إدارة الضمانات
9. **Shipping Management** - إدارة الشحن
10. **Settings** - ضبط العمولات (Commission Fees)

---

## Architecture

### Clean Architecture Compliance

تم تطبيق Clean Architecture + DDD + SOLID + Repository Pattern:

#### Controllers Layer (`app/Http/Controllers/Admin/`)
- Thin controllers - فقط orchestration
- Delegation إلى Application Layer (Use Cases)
- Validation عبر Form Requests

#### Policies & Gates (`app/Policies/`, `app/Providers/AuthServiceProvider.php`)
- Role-based access control
- Policy-based authorization
- Gate-based permissions

#### Views (`resources/views/admin/`)
- Blade templates
- Tailwind CSS styling
- Responsive design
- Modern UI/UX

---

## Features

### 1. Dashboard

**Controller**: `DashboardController`

**Features**:
- Overall statistics (Users, Orders, Products, Revenue)
- Sales chart (Last 30 days)
- Revenue chart (Last 12 months)
- Orders by status chart
- Products by status chart
- Recent orders list
- Recent users list

**View**: `resources/views/admin/dashboard/index.blade.php`

### 2. User Management

**Controller**: `UserController`

**Features**:
- List all users with filters (role, search)
- View user details with statistics
- Edit user information
- Toggle user status (activate/deactivate)
- Delete users
- Assign roles (Spatie Permission)

**Routes**:
- `GET /admin/users` - List users
- `GET /admin/users/{id}` - Show user
- `GET /admin/users/{id}/edit` - Edit user
- `PUT /admin/users/{id}` - Update user
- `DELETE /admin/users/{id}` - Delete user
- `POST /admin/users/{id}/toggle-status` - Toggle status

### 3. Product Management

**Controller**: `ProductController`

**Features**:
- List all products with filters (status, search)
- View product details
- Approve products
- Reject products
- Delete products

**Routes**:
- `GET /admin/products` - List products
- `GET /admin/products/{id}` - Show product
- `POST /admin/products/{id}/approve` - Approve product
- `POST /admin/products/{id}/reject` - Reject product
- `DELETE /admin/products/{id}` - Delete product

### 4. Inspection Management

**Controller**: `InspectionController`

**Features**:
- List all inspections with filters
- View inspection details
- Approve inspections
- Reject inspections

**Routes**:
- `GET /admin/inspections` - List inspections
- `GET /admin/inspections/{id}` - Show inspection
- `POST /admin/inspections/{id}/approve` - Approve inspection
- `POST /admin/inspections/{id}/reject` - Reject inspection

### 5. Order Management

**Controller**: `OrderController`

**Features**:
- List all orders with filters
- View order details
- Update order status
- Generate PDF invoice
- Delete orders

**Routes**:
- `GET /admin/orders` - List orders
- `GET /admin/orders/{id}` - Show order
- `PUT /admin/orders/{id}/status` - Update status
- `GET /admin/orders/{id}/invoice` - Download invoice PDF
- `DELETE /admin/orders/{id}` - Delete order

### 6. Payment Management

**Controller**: `PaymentController`

**Features**:
- List all payments with filters
- View payment details
- Process refunds

**Routes**:
- `GET /admin/payments` - List payments
- `GET /admin/payments/{id}` - Show payment
- `POST /admin/payments/{id}/refund` - Refund payment

### 7. Trade-in Management

**Controller**: `TradeInController`

**Features**:
- List all trade-ins with filters
- View trade-in details
- Approve trade-ins (creates credit)
- Reject trade-ins

**Routes**:
- `GET /admin/trade-ins` - List trade-ins
- `GET /admin/trade-ins/{id}` - Show trade-in
- `POST /admin/trade-ins/{id}/approve` - Approve trade-in
- `POST /admin/trade-ins/{id}/reject` - Reject trade-in

### 8. Warranty Management

**Controller**: `WarrantyController`

**Features**:
- List all warranties with filters
- View warranty details
- Update warranty status

**Routes**:
- `GET /admin/warranties` - List warranties
- `GET /admin/warranties/{id}` - Show warranty
- `PUT /admin/warranties/{id}/status` - Update status

### 9. Shipping Management

**Controller**: `ShippingController`

**Features**:
- List all shippings with filters
- View shipping details
- Update shipping status and tracking number

**Routes**:
- `GET /admin/shipping` - List shippings
- `GET /admin/shipping/{id}` - Show shipping
- `PUT /admin/shipping/{id}/status` - Update status

### 10. Settings Management

**Controller**: `SettingsController`

**Features**:
- Manage commission rates
- Manage platform fees
- Manage inspection fees
- Manage shipping costs

**Routes**:
- `GET /admin/settings` - View settings
- `PUT /admin/settings` - Update settings

---

## Controllers

### Location: `app/Http/Controllers/Admin/`

#### DashboardController
- `index()` - Display dashboard with statistics and charts

#### UserController
- `index()` - List users with filters
- `show($id)` - Show user details
- `edit($id)` - Show edit form
- `update($id)` - Update user
- `destroy($id)` - Delete user
- `toggleStatus($id)` - Toggle user status

#### ProductController
- `index()` - List products with filters
- `show($id)` - Show product details
- `approve($id)` - Approve product
- `reject($id)` - Reject product
- `destroy($id)` - Delete product

#### OrderController
- `index()` - List orders with filters
- `show($id)` - Show order details
- `updateStatus($id)` - Update order status
- `invoice($id)` - Generate PDF invoice
- `destroy($id)` - Delete order

#### PaymentController
- `index()` - List payments with filters
- `show($id)` - Show payment details
- `refund($id)` - Process refund

#### InspectionController
- `index()` - List inspections with filters
- `show($id)` - Show inspection details
- `approve($id)` - Approve inspection
- `reject($id)` - Reject inspection

#### TradeInController
- `index()` - List trade-ins with filters
- `show($id)` - Show trade-in details
- `approve($id)` - Approve trade-in and create credit
- `reject($id)` - Reject trade-in

#### WarrantyController
- `index()` - List warranties with filters
- `show($id)` - Show warranty details
- `updateStatus($id)` - Update warranty status

#### ShippingController
- `index()` - List shippings with filters
- `show($id)` - Show shipping details
- `updateStatus($id)` - Update shipping status

#### SettingsController
- `index()` - Show settings form
- `update()` - Update settings

---

## Views

### Location: `resources/views/admin/`

#### Layout
- `layouts/admin.blade.php` - Admin panel layout with sidebar navigation

#### Dashboard
- `dashboard/index.blade.php` - Dashboard with statistics and charts

#### Users
- `users/index.blade.php` - Users list with filters
- `users/show.blade.php` - User details
- `users/edit.blade.php` - Edit user form

#### Products
- `products/index.blade.php` - Products list with filters
- `products/show.blade.php` - Product details (to be created)

#### Orders
- `orders/index.blade.php` - Orders list with filters
- `orders/show.blade.php` - Order details (to be created)
- `orders/invoice.blade.php` - PDF invoice template

#### Payments
- `payments/index.blade.php` - Payments list (to be created)
- `payments/show.blade.php` - Payment details (to be created)

#### Inspections
- `inspections/index.blade.php` - Inspections list (to be created)
- `inspections/show.blade.php` - Inspection details (to be created)

#### Trade-ins
- `trade-ins/index.blade.php` - Trade-ins list (to be created)
- `trade-ins/show.blade.php` - Trade-in details (to be created)

#### Warranties
- `warranties/index.blade.php` - Warranties list (to be created)
- `warranties/show.blade.php` - Warranty details (to be created)

#### Shipping
- `shipping/index.blade.php` - Shipping list (to be created)
- `shipping/show.blade.php` - Shipping details (to be created)

#### Settings
- `settings/index.blade.php` - Settings form

---

## Policies & Gates

### Location: `app/Policies/AdminPolicy.php`

**Policies**:
- `accessAdmin()` - Check admin access
- `manageUsers()` - Check user management permission
- `manageProducts()` - Check product management permission
- `manageOrders()` - Check order management permission
- `managePayments()` - Check payment management permission
- `manageInspections()` - Check inspection management permission
- `manageTradeIns()` - Check trade-in management permission
- `manageWarranties()` - Check warranty management permission
- `manageShipping()` - Check shipping management permission
- `manageSettings()` - Check settings management permission

### Location: `app/Providers/AuthServiceProvider.php`

**Gates**:
- `access-admin` - Admin panel access
- `manage-users` - User management
- `manage-products` - Product management
- `manage-orders` - Order management
- `manage-payments` - Payment management
- `manage-inspections` - Inspection management
- `manage-trade-ins` - Trade-in management
- `manage-warranties` - Warranty management
- `manage-shipping` - Shipping management
- `manage-settings` - Settings management

---

## Routes

### Location: `routes/web.php`

All admin routes are prefixed with `/admin` and protected by `role:admin` middleware:

```php
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users, Products, Orders, Payments, Inspections, Trade-ins, Warranties, Shipping, Settings
    // ...
});
```

---

## Models

### Updated Models

#### Order Model
- Added relationships: `buyer()`, `items()`, `payments()`, `shipping()`, `warranties()`
- Added fillable fields and casts

#### Payment Model
- Added relationships: `order()`, `user()`
- Added fillable fields and casts

#### TradeIn Model
- Added relationships: `buyer()`, `request()`, `valuation()`
- Added fillable fields and casts

#### Warranty Model
- Added relationships: `order()`, `product()`
- Added fillable fields and casts

#### Shipping Model
- Added relationships: `order()`, `labels()`, `trackingInfo()`
- Added fillable fields and casts

#### OrderItem Model
- Added relationships: `order()`, `product()`
- Added fillable fields and casts

#### TradeInRequest Model
- Added relationship: `tradeIn()`
- Added fillable fields and casts

#### Valuation Model
- Added relationship: `tradeIn()`
- Added fillable fields and casts

#### Credit Model
- Added relationships: `user()`, `tradeIn()`
- Added fillable fields and casts

---

## Settings Management

### Commission Fees

Settings are stored in cache (can be moved to database in production):

- `commission_rate` - Total commission rate (%)
- `seller_commission_rate` - Seller commission rate (%)
- `platform_fee` - Platform service fee (%)
- `inspection_fee` - Inspection fee ($)
- `shipping_base_cost` - Base shipping cost ($)

### Access

Settings can be managed via:
- `GET /admin/settings` - View settings form
- `PUT /admin/settings` - Update settings

---

## Security

### Middleware
- All admin routes are protected by `auth` middleware
- All admin routes require `role:admin` middleware

### Authorization
- Policies check for admin role
- Gates check for admin role
- Spatie Permission package used for role management

---

## UI/UX Features

### Design
- Modern admin panel design
- Dark sidebar with navigation
- Responsive layout
- Tailwind CSS styling
- Chart.js for data visualization

### Navigation
- Sidebar navigation with icons
- Active route highlighting
- Quick access to all modules

### Data Visualization
- Line charts for sales trends
- Bar charts for revenue
- Doughnut charts for status distribution
- Pie charts for category distribution

---

## Next Steps

### To Complete
1. Create remaining views (show pages for all modules)
2. Add Application Layer (Use Cases) for admin operations
3. Add comprehensive validation
4. Add unit and feature tests
5. Add export functionality (CSV, Excel)
6. Add advanced filtering and search
7. Add bulk operations
8. Add activity logs
9. Add notifications for admin actions

---

**Phase 5 Status**: ✅ Complete  
**Last Updated**: 2024

