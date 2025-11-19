# Phase 3 Folder Structure
## Complete Directory Tree

```
app/
├── Domain/
│   ├── Product/
│   │   ├── Models/
│   │   │   └── Product.php
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
│   │   │   └── Inspection.php
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
│   ├── Certification/
│   │   ├── Models/
│   │   │   └── Certification.php
│   │   ├── Events/
│   │   │   └── CertificationGenerated.php
│   │   └── Repositories/
│   │       └── CertificationRepositoryInterface.php
│   └── Shared/
│       ├── Events/
│       │   └── DomainEvent.php
│       └── Exceptions/
│           ├── DomainException.php
│           └── BusinessRuleViolationException.php
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
├── Http/
│   ├── Controllers/
│   │   ├── Product/
│   │   │   ├── ProductController.php
│   │   │   └── ProductImageController.php
│   │   ├── Inspection/
│   │   │   └── InspectionController.php
│   │   └── Certification/
│   │       └── CertificationController.php
│   ├── Requests/
│   │   ├── Product/
│   │   │   ├── CreateProductRequest.php
│   │   │   ├── UpdateProductRequest.php
│   │   │   └── UploadProductImagesRequest.php
│   │   ├── Inspection/
│   │   │   ├── CreateInspectionRequest.php
│   │   │   ├── SubmitInspectionReportRequest.php
│   │   │   └── UploadInspectionImagesRequest.php
│   │   └── Certification/
│   │       └── GenerateCertificationRequest.php
│   └── Resources/
│       ├── ProductResource.php
│       ├── InspectionResource.php
│       └── CertificationResource.php
│
└── Models/ (Eloquent Models)
    ├── Product.php
    ├── ProductImage.php
    ├── ProductCategory.php
    ├── Inspection.php
    ├── InspectionImage.php
    └── Certification.php

resources/views/
├── components/
│   ├── product-card.blade.php
│   ├── filter-panel.blade.php
│   └── image-gallery.blade.php
├── products/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── inspection/
    └── report-pdf.blade.php

database/
├── migrations/
│   ├── 2024_01_02_000001_create_product_categories_table.php
│   ├── 2024_01_02_000002_create_products_table.php
│   ├── 2024_01_02_000003_create_product_images_table.php
│   ├── 2024_01_02_000004_create_inspections_table.php
│   ├── 2024_01_02_000005_create_inspection_images_table.php
│   └── 2024_01_02_000006_create_certifications_table.php
└── factories/
    ├── ProductFactory.php
    └── InspectionFactory.php

tests/
├── Unit/
│   ├── Domain/
│   │   ├── Product/
│   │   │   ├── ProductTest.php
│   │   │   └── ValueObjects/
│   │   │       └── PriceTest.php
│   │   ├── Inspection/
│   │   └── Certification/
└── Feature/
    ├── Product/
    │   └── CreateProductTest.php
    ├── Inspection/
    │   └── CreateInspectionTest.php
    └── Certification/
        └── GenerateCertificationTest.php

docs/phase3/
├── README.md
├── IMPLEMENTATION_SUMMARY.md
├── API_ENDPOINTS.md
└── FOLDER_STRUCTURE.md
```

---

## File Count Summary

- **Domain Layer**: 25 files
- **Application Layer**: 16 files
- **Infrastructure Layer**: 9 files
- **Interface Layer**: 14 files
- **Views**: 7 files
- **Migrations**: 6 files
- **Models**: 6 files
- **Factories**: 2 files
- **Tests**: 5 files
- **Documentation**: 4 files

**Total**: ~94 files

---

## Key Directories

### Domain Layer
- **Models/**: Aggregate Roots and Entities
- **ValueObjects/**: Immutable value objects
- **Events/**: Domain events
- **Repositories/**: Repository interfaces

### Application Layer
- **Actions/**: Use cases (business logic)
- **DTOs/**: Data transfer objects

### Infrastructure Layer
- **Repositories/**: Eloquent implementations
- **Services/**: External service implementations

### Interface Layer
- **Controllers/**: HTTP controllers (thin)
- **Requests/**: Form validation
- **Resources/**: API transformers

---

**Last Updated**: 2024

