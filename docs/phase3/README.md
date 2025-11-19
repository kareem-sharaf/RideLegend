# Phase 3: Products, Inspection & Certification
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Complete

---

## Table of Contents

1. [Overview](#1-overview)
2. [Architecture Overview](#2-architecture-overview)
3. [Folder Structure](#3-folder-structure)
4. [Domain Layer](#4-domain-layer)
5. [Application Layer](#5-application-layer)
6. [Infrastructure Layer](#6-infrastructure-layer)
7. [Interface Layer](#7-interface-layer)
8. [API Documentation](#8-api-documentation)
9. [UML Diagrams](#9-uml-diagrams)
10. [Testing](#10-testing)

---

## 1. Overview

Phase 3 implements three core modules:
- **Products Module**: Product listing, management, and filtering
- **Inspection Module**: Inspection workflow and reporting
- **Certification Module**: Certification generation and management

All modules follow Clean Architecture principles with complete separation of concerns.

---

## 2. Architecture Overview

### 2.1 Clean Architecture Layers

```
┌─────────────────────────────────────────┐
│ Interface Layer (HTTP/Blade)            │
│ - Controllers (Thin)                     │
│ - Form Requests                           │
│ - Resources (API)                         │
│ - Blade Views                             │
└─────────────────┬───────────────────────┘
                  │ depends on
┌─────────────────▼───────────────────────┐
│ Application Layer (Use Cases)             │
│ - Actions (Use Cases)                     │
│ - DTOs                                     │
└─────────────────┬───────────────────────┘
                  │ depends on
┌─────────────────▼───────────────────────┐
│ Domain Layer (Business Logic)              │
│ - Aggregates                               │
│ - Entities                                 │
│ - Value Objects                            │
│ - Domain Events                            │
│ - Repository Interfaces                    │
└─────────────────┬───────────────────────┘
                  ↑ implements
┌─────────────────┴───────────────────────┐
│ Infrastructure Layer                     │
│ - Repository Implementations              │
│ - External Services                       │
│ - File Storage                            │
└─────────────────────────────────────────┘
```

---

## 3. Folder Structure

```
app/
├── Domain/
│   ├── Product/
│   │   ├── Models/
│   │   │   └── Product.php              # Aggregate Root
│   │   ├── ValueObjects/
│   │   │   ├── Title.php
│   │   │   ├── Price.php
│   │   │   ├── Weight.php
│   │   │   ├── FrameMaterial.php
│   │   │   ├── BrakeType.php
│   │   │   ├── WheelSize.php
│   │   │   ├── BikeType.php
│   │   │   └── ProductImage.php
│   │   ├── Events/
│   │   │   ├── ProductCreated.php
│   │   │   └── ProductUpdated.php
│   │   └── Repositories/
│   │       └── ProductRepositoryInterface.php
│   ├── Inspection/
│   │   ├── Models/
│   │   │   └── Inspection.php           # Aggregate Root
│   │   ├── ValueObjects/
│   │   │   ├── FrameCondition.php
│   │   │   ├── BrakeCondition.php
│   │   │   ├── GroupsetCondition.php
│   │   │   ├── WheelsCondition.php
│   │   │   └── OverallGrade.php
│   │   ├── Events/
│   │   │   ├── InspectionRequested.php
│   │   │   └── InspectionCompleted.php
│   │   └── Repositories/
│   │       └── InspectionRepositoryInterface.php
│   └── Certification/
│       ├── Models/
│       │   └── Certification.php        # Entity
│       ├── Events/
│       │   └── CertificationGenerated.php
│       └── Repositories/
│           └── CertificationRepositoryInterface.php
│
├── Application/
│   ├── Product/
│   │   ├── Actions/
│   │   │   ├── CreateProductAction.php
│   │   │   ├── UpdateProductAction.php
│   │   │   ├── DeleteProductAction.php
│   │   │   ├── ChangeProductStatusAction.php
│   │   │   ├── FilterProductsAction.php
│   │   │   └── UploadProductImagesAction.php
│   │   └── DTOs/
│   │       ├── CreateProductDTO.php
│   │       ├── UpdateProductDTO.php
│   │       └── FilterProductsDTO.php
│   ├── Inspection/
│   │   ├── Actions/
│   │   │   ├── CreateInspectionRequestAction.php
│   │   │   ├── SubmitInspectionReportAction.php
│   │   │   └── UploadInspectionImagesAction.php
│   │   └── DTOs/
│   │       ├── CreateInspectionRequestDTO.php
│   │       └── SubmitInspectionReportDTO.php
│   └── Certification/
│       ├── Actions/
│       │   └── GenerateCertificationAction.php
│       └── DTOs/
│           └── GenerateCertificationDTO.php
│
├── Infrastructure/
│   ├── Repositories/
│   │   ├── Product/
│   │   │   └── EloquentProductRepository.php
│   │   ├── Inspection/
│   │   │   └── EloquentInspectionRepository.php
│   │   └── Certification/
│   │       └── EloquentCertificationRepository.php
│   └── Services/
│       ├── ProductImage/
│       │   ├── ProductImageServiceInterface.php
│       │   └── LocalStorageProductImageService.php
│       ├── InspectionImage/
│       │   ├── InspectionImageServiceInterface.php
│       │   └── LocalStorageInspectionImageService.php
│       └── InspectionReport/
│           ├── InspectionReportPdfServiceInterface.php
│           └── DomPdfInspectionReportService.php
│
└── Http/
    ├── Controllers/
    │   ├── Product/
    │   │   ├── ProductController.php
    │   │   └── ProductImageController.php
    │   ├── Inspection/
    │   │   └── InspectionController.php
    │   └── Certification/
    │       └── CertificationController.php
    ├── Requests/
    │   ├── Product/
    │   ├── Inspection/
    │   └── Certification/
    └── Resources/
        ├── ProductResource.php
        ├── InspectionResource.php
        └── CertificationResource.php
```

---

## 4. Domain Layer

### 4.1 Product Aggregate

**Aggregate Root**: `Product`

**Value Objects**:
- `Title`: Product title with validation
- `Price`: Price with currency
- `Weight`: Weight with unit conversion
- `FrameMaterial`: Frame material enum
- `BrakeType`: Brake type enum
- `WheelSize`: Wheel size enum
- `BikeType`: Bike type enum
- `ProductImage`: Image value object

**Domain Events**:
- `ProductCreated`: Dispatched when product is created
- `ProductUpdated`: Dispatched when product is updated

**Business Rules**:
- Product must have valid price (> 0)
- Product status transitions: draft → pending → active
- Only one certification per product

### 4.2 Inspection Aggregate

**Aggregate Root**: `Inspection`

**Value Objects**:
- `FrameCondition`: Frame condition grade + notes
- `BrakeCondition`: Brake condition grade + notes
- `GroupsetCondition`: Groupset condition grade + notes
- `WheelsCondition`: Wheels condition grade + notes
- `OverallGrade`: Overall grade (A+, A, B, C)

**Domain Events**:
- `InspectionRequested`: Dispatched when inspection is requested
- `InspectionCompleted`: Dispatched when inspection report is submitted

**State Transitions**:
- pending → scheduled → in_progress → completed

### 4.3 Certification Entity

**Entity**: `Certification`

**Domain Events**:
- `CertificationGenerated`: Dispatched when certification is generated

**Business Rules**:
- Certification can only be generated after inspection completion
- One certification per product
- Certification expires after 1 year (default)

---

## 5. Application Layer

### 5.1 Product Use Cases

#### CreateProductAction
- **DTO**: `CreateProductDTO`
- **Purpose**: Create new product listing
- **Validations**: All required fields, valid value objects
- **Events**: Dispatches `ProductCreated`

#### UpdateProductAction
- **DTO**: `UpdateProductDTO`
- **Purpose**: Update existing product
- **Validations**: Product exists, seller owns product
- **Events**: Dispatches `ProductUpdated`

#### DeleteProductAction
- **Purpose**: Delete product
- **Validations**: Product exists, seller owns product

#### FilterProductsAction
- **DTO**: `FilterProductsDTO`
- **Purpose**: Search and filter products
- **Filters**: Category, bike type, price range, certification status, etc.

#### UploadProductImagesAction
- **Purpose**: Upload multiple product images
- **Service**: Uses `ProductImageServiceInterface`

#### ChangeProductStatusAction
- **Purpose**: Change product status
- **Validations**: Valid status transition

### 5.2 Inspection Use Cases

#### CreateInspectionRequestAction
- **DTO**: `CreateInspectionRequestDTO`
- **Purpose**: Create inspection request
- **Events**: Dispatches `InspectionRequested`

#### SubmitInspectionReportAction
- **DTO**: `SubmitInspectionReportDTO`
- **Purpose**: Submit inspection report with grades
- **Validations**: All condition grades required
- **Events**: Dispatches `InspectionCompleted`

#### UploadInspectionImagesAction
- **Purpose**: Upload inspection images
- **Service**: Uses `InspectionImageServiceInterface`

### 5.3 Certification Use Cases

#### GenerateCertificationAction
- **DTO**: `GenerateCertificationDTO`
- **Purpose**: Generate certification after inspection
- **Validations**: Inspection must be completed
- **Services**: Uses `InspectionReportPdfServiceInterface` for PDF generation
- **Events**: Dispatches `CertificationGenerated`

---

## 6. Infrastructure Layer

### 6.1 Repositories

#### EloquentProductRepository
- Implements `ProductRepositoryInterface`
- Handles product persistence
- Maps Eloquent models to Domain models
- Handles product images

#### EloquentInspectionRepository
- Implements `InspectionRepositoryInterface`
- Handles inspection persistence
- Maps condition value objects

#### EloquentCertificationRepository
- Implements `CertificationRepositoryInterface`
- Handles certification persistence

### 6.2 Services

#### ProductImageService
- **Interface**: `ProductImageServiceInterface`
- **Implementation**: `LocalStorageProductImageService`
- Stores images in `storage/app/public/products/{productId}/`

#### InspectionImageService
- **Interface**: `InspectionImageServiceInterface`
- **Implementation**: `LocalStorageInspectionImageService`
- Stores images in `storage/app/public/inspections/{inspectionId}/`

#### InspectionReportPdfService
- **Interface**: `InspectionReportPdfServiceInterface`
- **Implementation**: `DomPdfInspectionReportService`
- Generates PDF reports using DomPDF
- Stores PDFs in `storage/app/public/certifications/{productId}/`

---

## 7. Interface Layer

### 7.1 Controllers

#### ProductController
- `index()`: List/filter products
- `show()`: Show product details
- `create()`: Show create form
- `store()`: Create product
- `edit()`: Show edit form
- `update()`: Update product
- `destroy()`: Delete product

#### ProductImageController
- `store()`: Upload product images

#### InspectionController
- `store()`: Create inspection request
- `submitReport()`: Submit inspection report
- `uploadImages()`: Upload inspection images

#### CertificationController
- `generate()`: Generate certification
- `show()`: Show certification details

### 7.2 Form Requests

All controllers use Form Requests for validation:
- `CreateProductRequest`
- `UpdateProductRequest`
- `UploadProductImagesRequest`
- `CreateInspectionRequest`
- `SubmitInspectionReportRequest`
- `GenerateCertificationRequest`

### 7.3 Resources

- `ProductResource`: Transforms Product aggregate to JSON
- `InspectionResource`: Transforms Inspection aggregate to JSON
- `CertificationResource`: Transforms Certification entity to JSON

### 7.4 Blade Views

#### Product Views
- `products/index.blade.php`: Product listing with filters
- `products/show.blade.php`: Product detail page
- `products/create.blade.php`: Create product form
- `products/edit.blade.php`: Edit product form

#### Components
- `product-card.blade.php`: Product card component
- `filter-panel.blade.php`: Filter sidebar component
- `image-gallery.blade.php`: Image gallery component

---

## 8. API Documentation

### 8.1 Product Endpoints

#### GET `/api/products`
List products with filtering.

**Query Parameters**:
- `category_id`: Filter by category
- `bike_type`: Filter by bike type
- `frame_material`: Filter by frame material
- `brake_type`: Filter by brake type
- `min_price`: Minimum price
- `max_price`: Maximum price
- `certified_only`: Show only certified products (true/false)
- `status`: Filter by status
- `search`: Search in title, description, brand, model
- `page`: Page number
- `per_page`: Items per page

**Response**:
```json
{
  "products": [
    {
      "id": 1,
      "title": "Premium Road Bike",
      "price": 2500.00,
      "bike_type": "road",
      "is_certified": true,
      "images": [...]
    }
  ]
}
```

#### POST `/api/products`
Create new product (requires authentication, seller role).

**Request**:
```json
{
  "title": "Premium Road Bike",
  "description": "High-quality road bike",
  "price": 2500.00,
  "bike_type": "road",
  "frame_material": "carbon",
  "brake_type": "disc_brake_hydraulic",
  "wheel_size": "700c",
  "brand": "Trek",
  "model": "Domane",
  "year": 2023
}
```

#### GET `/api/products/{id}`
Get product details.

#### PUT `/api/products/{id}`
Update product (requires authentication, seller owns product).

#### DELETE `/api/products/{id}`
Delete product (requires authentication, seller owns product).

#### POST `/api/products/{id}/images`
Upload product images (requires authentication).

**Request**: Multipart form data
- `images[]`: Array of image files
- `primary_index`: Index of primary image (optional)

### 8.2 Inspection Endpoints

#### POST `/api/inspections`
Create inspection request (requires authentication).

**Request**:
```json
{
  "product_id": 1,
  "workshop_id": 2
}
```

#### POST `/api/inspections/{id}/report`
Submit inspection report (requires authentication, workshop role).

**Request**:
```json
{
  "frame_grade": "excellent",
  "frame_notes": "No damage",
  "brake_grade": "very_good",
  "brake_notes": "Good condition",
  "groupset_grade": "good",
  "groupset_notes": "Minor wear",
  "wheels_grade": "excellent",
  "wheels_notes": "Perfect",
  "overall_grade": "A",
  "notes": "Overall excellent condition"
}
```

#### POST `/api/inspections/{id}/images`
Upload inspection images (requires authentication, workshop role).

### 8.3 Certification Endpoints

#### POST `/api/certifications/generate`
Generate certification (requires authentication, workshop role).

**Request**:
```json
{
  "product_id": 1,
  "inspection_id": 1,
  "workshop_id": 2,
  "grade": "A"
}
```

#### GET `/api/certifications/{id}`
Get certification details.

---

## 9. UML Diagrams

### 9.1 Product Aggregate Diagram

```
┌─────────────────────────────────────┐
│ Product (Aggregate Root)            │
├─────────────────────────────────────┤
│ - id: int                           │
│ - sellerId: int                      │
│ - title: Title (VO)                 │
│ - price: Price (VO)                 │
│ - bikeType: BikeType (VO)           │
│ - frameMaterial: FrameMaterial (VO) │
│ - brakeType: BrakeType (VO)         │
│ - wheelSize: WheelSize (VO)        │
│ - weight: Weight (VO)               │
│ - status: string                    │
│ - certificationId: int              │
├─────────────────────────────────────┤
│ + create()                          │
│ + update()                          │
│ + changeStatus()                    │
│ + assignCertification()             │
│ + addImage()                        │
└─────────────────────────────────────┘
         │
         │ contains
         ▼
┌─────────────────────────────────────┐
│ ProductImage (Value Object)          │
├─────────────────────────────────────┤
│ - path: string                       │
│ - isPrimary: bool                    │
│ - order: int                         │
└─────────────────────────────────────┘
```

### 9.2 Inspection Workflow

```
Seller                    Workshop                  System
  │                          │                        │
  │──Request Inspection──────>│                        │
  │                          │                        │
  │                          │──Schedule─────────────>│
  │                          │                        │
  │                          │──Perform Inspection───>│
  │                          │                        │
  │                          │──Submit Report────────>│
  │                          │                        │
  │                          │                        │──Generate PDF
  │                          │                        │
  │                          │<──PDF Report────────────│
  │                          │                        │
  │                          │──Generate Certification>│
  │                          │                        │
  │<──Certification──────────│                        │
```

### 9.3 Certification Lifecycle

```
Product
  │
  │──Request Inspection
  ▼
Inspection (pending)
  │
  │──Schedule
  ▼
Inspection (scheduled)
  │
  │──Start
  ▼
Inspection (in_progress)
  │
  │──Submit Report
  ▼
Inspection (completed)
  │
  │──Generate Certification
  ▼
Certification (active)
  │
  │──[1 year later]
  ▼
Certification (expired)
```

---

## 10. Testing

### 10.1 Unit Tests

#### Domain Tests
- `tests/Unit/Domain/Product/ProductTest.php`
- `tests/Unit/Domain/Product/ValueObjects/PriceTest.php`
- Value Object validation tests
- Aggregate business rule tests

### 10.2 Feature Tests

#### Product Tests
- `tests/Feature/Product/CreateProductTest.php`
- Product creation flow
- Image upload
- Filtering

#### Inspection Tests
- `tests/Feature/Inspection/CreateInspectionTest.php`
- Inspection request flow
- Report submission

#### Certification Tests
- `tests/Feature/Certification/GenerateCertificationTest.php`
- Certification generation flow

### 10.3 Test Coverage

- **Domain Layer**: 100% coverage target
- **Application Layer**: 90% coverage target
- **Overall**: 80%+ coverage

---

## Appendix A: Use Cases & DTOs List

### Product Use Cases
1. **CreateProductAction**
   - DTO: `CreateProductDTO`
   - Creates product aggregate
   - Dispatches `ProductCreated` event

2. **UpdateProductAction**
   - DTO: `UpdateProductDTO`
   - Updates product
   - Dispatches `ProductUpdated` event

3. **DeleteProductAction**
   - Deletes product
   - Validates ownership

4. **ChangeProductStatusAction**
   - Changes product status
   - Validates status transition

5. **FilterProductsAction**
   - DTO: `FilterProductsDTO`
   - Searches and filters products

6. **UploadProductImagesAction**
   - Uploads multiple images
   - Sets primary image

### Inspection Use Cases
1. **CreateInspectionRequestAction**
   - DTO: `CreateInspectionRequestDTO`
   - Creates inspection request
   - Dispatches `InspectionRequested` event

2. **SubmitInspectionReportAction**
   - DTO: `SubmitInspectionReportDTO`
   - Submits inspection report
   - Dispatches `InspectionCompleted` event

3. **UploadInspectionImagesAction**
   - Uploads inspection images

### Certification Use Cases
1. **GenerateCertificationAction**
   - DTO: `GenerateCertificationDTO`
   - Generates certification
   - Creates PDF report
   - Dispatches `CertificationGenerated` event

---

## Appendix B: Repository Interfaces

### ProductRepositoryInterface
```php
interface ProductRepositoryInterface
{
    public function save(Product $product): Product;
    public function findById(int $id): ?Product;
    public function findBySellerId(int $sellerId): Collection;
    public function findByCategoryId(int $categoryId): Collection;
    public function findByStatus(string $status): Collection;
    public function search(array $criteria): Collection;
    public function delete(Product $product): void;
}
```

### InspectionRepositoryInterface
```php
interface InspectionRepositoryInterface
{
    public function save(Inspection $inspection): Inspection;
    public function findById(int $id): ?Inspection;
    public function findByProductId(int $productId): ?Inspection;
    public function findByWorkshopId(int $workshopId): Collection;
    public function findByStatus(string $status): Collection;
    public function delete(Inspection $inspection): void;
}
```

### CertificationRepositoryInterface
```php
interface CertificationRepositoryInterface
{
    public function save(Certification $certification): Certification;
    public function findById(int $id): ?Certification;
    public function findByProductId(int $productId): ?Certification;
    public function delete(Certification $certification): void;
}
```

---

**Phase 3 Status**: ✅ Complete  
**Next Steps**: Phase 4 - Orders & Payments

