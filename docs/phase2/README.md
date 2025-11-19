# Phase 2: Foundation + Auth + Roles
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Complete

---

## Overview

Phase 2 implements the foundation of the Premium Bikes Managed Marketplace with Clean Architecture, authentication system, roles & permissions, and user profile management.

---

## Folder Structure

```
app/
├── Domain/                          # Domain Layer
│   ├── Shared/
│   │   ├── Events/
│   │   │   └── DomainEvent.php
│   │   └── Exceptions/
│   │       ├── DomainException.php
│   │       └── BusinessRuleViolationException.php
│   └── User/
│       ├── Models/
│       │   └── User.php            # Aggregate Root
│       ├── ValueObjects/
│       │   ├── Email.php
│       │   └── PhoneNumber.php
│       ├── Events/
│       │   ├── UserRegistered.php
│       │   ├── UserLoggedIn.php
│       │   └── RoleAssigned.php
│       └── Repositories/
│           └── UserRepositoryInterface.php
│
├── Application/                      # Application Layer
│   ├── Auth/
│   │   ├── Actions/
│   │   │   ├── RegisterUserAction.php
│   │   │   ├── LoginUserAction.php
│   │   │   ├── SendOtpAction.php
│   │   │   └── VerifyOtpAction.php
│   │   └── DTOs/
│   │       ├── RegisterUserDTO.php
│   │       ├── LoginUserDTO.php
│   │       ├── SendOtpDTO.php
│   │       └── VerifyOtpDTO.php
│   └── User/
│       ├── Actions/
│       │   ├── UpdateUserProfileAction.php
│       │   ├── UploadUserAvatarAction.php
│       │   └── ChangePasswordAction.php
│       └── DTOs/
│           ├── UpdateUserProfileDTO.php
│           └── ChangePasswordDTO.php
│
├── Infrastructure/                   # Infrastructure Layer
│   ├── Repositories/
│   │   └── User/
│   │       └── EloquentUserRepository.php
│   ├── Services/
│   │   └── Otp/
│   │       ├── OtpServiceInterface.php
│   │       ├── CacheOtpService.php
│   │       ├── OtpStrategyFactory.php
│   │       └── Strategies/
│   │           ├── OtpStrategyInterface.php
│   │           ├── EmailOtpStrategy.php
│   │           └── SmsOtpStrategy.php
│   └── Permissions/
│       └── RoleRepository.php
│
└── Http/                             # Interface Layer
    ├── Controllers/
    │   ├── Auth/
    │   │   ├── RegisterController.php
    │   │   ├── LoginController.php
    │   │   └── OtpController.php
    │   └── User/
    │       └── ProfileController.php
    ├── Requests/
    │   ├── Auth/
    │   │   ├── RegisterRequest.php
    │   │   ├── LoginRequest.php
    │   │   ├── SendOtpRequest.php
    │   │   └── VerifyOtpRequest.php
    │   └── User/
    │       ├── UpdateProfileRequest.php
    │       ├── UploadAvatarRequest.php
    │       └── ChangePasswordRequest.php
    └── Resources/
        └── UserResource.php
```

---

## API Endpoints

### Authentication

#### POST `/api/auth/register`
Register a new user.

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "buyer",
  "first_name": "John",
  "last_name": "Doe",
  "phone": "+1234567890"
}
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "email": "user@example.com",
    "role": "buyer",
    "first_name": "John",
    "last_name": "Doe"
  }
}
```

#### POST `/api/auth/login`
Login user.

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password123",
  "remember": false
}
```

#### POST `/api/auth/logout`
Logout user (requires authentication).

#### POST `/api/auth/otp/send`
Send OTP code.

**Request:**
```json
{
  "identifier": "user@example.com",
  "channel": "email"
}
```

#### POST `/api/auth/otp/verify`
Verify OTP code.

**Request:**
```json
{
  "identifier": "user@example.com",
  "otp": "123456"
}
```

### User Profile

#### GET `/api/profile`
Get current user profile (requires authentication).

#### PUT `/api/profile`
Update user profile (requires authentication).

**Request:**
```json
{
  "first_name": "Jane",
  "last_name": "Smith",
  "phone": "+9876543210"
}
```

#### POST `/api/profile/avatar`
Upload user avatar (requires authentication).

**Request:** Multipart form data with `avatar` file.

#### POST `/api/profile/password`
Change password (requires authentication).

**Request:**
```json
{
  "current_password": "oldpassword",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

---

## Use Cases & DTOs

### Auth Use Cases

1. **RegisterUserAction**
   - DTO: `RegisterUserDTO`
   - Validates email uniqueness
   - Creates user aggregate
   - Dispatches `UserRegistered` event

2. **LoginUserAction**
   - DTO: `LoginUserDTO`
   - Validates credentials
   - Dispatches `UserLoggedIn` event

3. **SendOtpAction**
   - DTO: `SendOtpDTO`
   - Uses Strategy pattern for OTP delivery
   - Supports email and SMS channels

4. **VerifyOtpAction**
   - DTO: `VerifyOtpDTO`
   - Validates OTP code

### User Use Cases

1. **UpdateUserProfileAction**
   - DTO: `UpdateUserProfileDTO`
   - Updates user profile information

2. **UploadUserAvatarAction**
   - Uploads and stores avatar image
   - Validates image type and size

3. **ChangePasswordAction**
   - DTO: `ChangePasswordDTO`
   - Validates current password
   - Updates password

---

## Design Patterns Used

### Repository Pattern
- `UserRepositoryInterface` (Domain)
- `EloquentUserRepository` (Infrastructure)

### Strategy Pattern
- `OtpStrategyInterface` (Domain)
- `EmailOtpStrategy`, `SmsOtpStrategy` (Infrastructure)
- `OtpStrategyFactory` for strategy selection

### Factory Pattern
- `OtpStrategyFactory` creates appropriate OTP strategy

### DTO Pattern
- All Use Cases use DTOs for data transfer
- DTOs are immutable and validated

---

## Domain Events

1. **UserRegistered**
   - Dispatched when user is created
   - Can trigger welcome email, etc.

2. **UserLoggedIn**
   - Dispatched on successful login
   - Can trigger analytics, logging, etc.

3. **RoleAssigned**
   - Dispatched when role is assigned
   - Can trigger notifications, etc.

---

## Roles & Permissions

### Roles
- **buyer**: Can view products, create orders, trade-ins
- **seller**: Can manage products, view orders, create inspections
- **workshop**: Can manage inspections, workshops
- **admin**: Full access

### Permissions
Managed via Spatie Permissions package, wrapped in `RoleRepository` for Clean Architecture compliance.

---

## Testing

### Unit Tests
- Domain models (User aggregate)
- Value Objects (Email, PhoneNumber)
- Domain events

### Feature Tests
- Authentication flows
- User registration
- Profile management
- OTP verification

### Coverage Target
- Minimum 80% code coverage

---

## Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Publish Spatie Permissions**
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

4. **Seed Roles & Permissions**
   ```bash
   php artisan db:seed --class=RolePermissionSeeder
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Run Tests**
   ```bash
   php artisan test
   ```

---

## Next Steps (Phase 3)

- Product Management module
- Product listing creation
- Product search and filtering
- Image management

---

**Phase 2 Status**: ✅ Complete

