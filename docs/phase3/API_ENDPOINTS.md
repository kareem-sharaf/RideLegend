# API Endpoints Documentation
## Phase 3: Products, Inspection & Certification

---

## Products API

### GET `/api/products`
List and filter products.

**Query Parameters**:
- `category_id` (integer): Filter by category
- `bike_type` (string): road, mountain, gravel, etc.
- `frame_material` (string): carbon, aluminum, steel, etc.
- `brake_type` (string): rim_brake, disc_brake_mechanical, etc.
- `wheel_size` (string): 26, 27.5, 29, 700c, etc.
- `min_price` (float): Minimum price
- `max_price` (float): Maximum price
- `min_weight` (float): Minimum weight
- `max_weight` (float): Maximum weight
- `certified_only` (boolean): Show only certified products
- `status` (string): draft, pending, active, sold, inactive
- `search` (string): Search in title, description, brand, model
- `page` (integer): Page number
- `per_page` (integer): Items per page

**Response**: 200 OK
```json
{
  "products": [
    {
      "id": 1,
      "seller_id": 2,
      "title": "Premium Road Bike",
      "description": "High-quality road bike",
      "price": 2500.00,
      "currency": "USD",
      "bike_type": "road",
      "bike_type_display": "Road Bike",
      "frame_material": "carbon",
      "frame_material_display": "Carbon Fiber",
      "brake_type": "disc_brake_hydraulic",
      "brake_type_display": "Disc Brake (Hydraulic)",
      "wheel_size": "700c",
      "weight": 8.5,
      "weight_unit": "kg",
      "brand": "Trek",
      "model": "Domane",
      "year": 2023,
      "status": "active",
      "category_id": null,
      "certification_id": 1,
      "is_certified": true,
      "images": [
        {
          "path": "http://example.com/storage/products/1/image.jpg",
          "is_primary": true,
          "order": 0
        }
      ],
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

### GET `/api/products/{id}`
Get product details.

**Response**: 200 OK
```json
{
  "product": {
    "id": 1,
    "title": "Premium Road Bike",
    ...
  }
}
```

### POST `/api/products`
Create new product (requires authentication, seller role).

**Request Body**:
```json
{
  "title": "Premium Road Bike",
  "description": "High-quality road bike with carbon frame",
  "price": 2500.00,
  "bike_type": "road",
  "frame_material": "carbon",
  "brake_type": "disc_brake_hydraulic",
  "wheel_size": "700c",
  "weight": 8.5,
  "weight_unit": "kg",
  "brand": "Trek",
  "model": "Domane",
  "year": 2023,
  "category_id": 1
}
```

**Response**: 201 Created
```json
{
  "message": "Product created successfully",
  "product": { ... }
}
```

### PUT `/api/products/{id}`
Update product (requires authentication, seller owns product).

**Request Body**: Same as POST, all fields optional

**Response**: 200 OK

### DELETE `/api/products/{id}`
Delete product (requires authentication, seller owns product).

**Response**: 200 OK
```json
{
  "message": "Product deleted successfully"
}
```

### POST `/api/products/{id}/images`
Upload product images (requires authentication).

**Request**: Multipart form data
- `images[]`: Array of image files (max 10)
- `primary_index`: Index of primary image (optional)

**Response**: 200 OK
```json
{
  "message": "Images uploaded successfully",
  "product": { ... }
}
```

---

## Inspection API

### POST `/api/inspections`
Create inspection request (requires authentication).

**Request Body**:
```json
{
  "product_id": 1,
  "workshop_id": 3
}
```

**Response**: 201 Created
```json
{
  "message": "Inspection request created successfully",
  "inspection": {
    "id": 1,
    "product_id": 1,
    "seller_id": 2,
    "workshop_id": 3,
    "status": "pending",
    "requested_at": "2024-01-01T00:00:00Z"
  }
}
```

### POST `/api/inspections/{id}/report`
Submit inspection report (requires authentication, workshop role).

**Request Body**:
```json
{
  "frame_grade": "excellent",
  "frame_notes": "No damage, perfect condition",
  "brake_grade": "very_good",
  "brake_notes": "Good condition, minor wear",
  "groupset_grade": "good",
  "groupset_notes": "Minor wear on chain",
  "wheels_grade": "excellent",
  "wheels_notes": "Perfect condition",
  "overall_grade": "A",
  "notes": "Overall excellent condition, well maintained"
}
```

**Response**: 200 OK
```json
{
  "message": "Inspection report submitted successfully",
  "inspection": {
    "id": 1,
    "status": "completed",
    "overall_grade": "A",
    "frame_condition": {
      "grade": "excellent",
      "display": "Excellent",
      "notes": "No damage, perfect condition"
    },
    ...
  }
}
```

### POST `/api/inspections/{id}/images`
Upload inspection images (requires authentication, workshop role).

**Request**: Multipart form data
- `images[]`: Array of image files (max 20)

**Response**: 200 OK

---

## Certification API

### POST `/api/certifications/generate`
Generate certification (requires authentication, workshop role).

**Request Body**:
```json
{
  "product_id": 1,
  "inspection_id": 1,
  "workshop_id": 3,
  "grade": "A"
}
```

**Response**: 201 Created
```json
{
  "message": "Certification generated successfully",
  "certification": {
    "id": 1,
    "product_id": 1,
    "inspection_id": 1,
    "workshop_id": 3,
    "grade": "A",
    "report_url": "http://example.com/storage/certifications/1/report.pdf",
    "status": "active",
    "issued_at": "2024-01-01 00:00:00",
    "expires_at": "2025-01-01 00:00:00",
    "is_expired": false
  }
}
```

### GET `/api/certifications/{id}`
Get certification details.

**Response**: 200 OK
```json
{
  "certification": {
    "id": 1,
    "product_id": 1,
    "grade": "A",
    "report_url": "http://example.com/storage/certifications/1/report.pdf",
    ...
  }
}
```

---

## Error Responses

### 400 Bad Request
```json
{
  "error": "Invalid request data"
}
```

### 401 Unauthorized
```json
{
  "error": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "error": "You do not have permission to perform this action"
}
```

### 404 Not Found
```json
{
  "error": "Resource not found"
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "price": ["The price must be a number."]
  }
}
```

---

## Authentication

All protected endpoints require authentication via Laravel Sanctum.

**Header**: `Authorization: Bearer {token}`

Or use session-based authentication for web routes.

---

## Rate Limiting

- Public endpoints: 60 requests per minute
- Authenticated endpoints: 120 requests per minute

---

**Last Updated**: 2024

