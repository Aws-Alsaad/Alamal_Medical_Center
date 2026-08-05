# Laravel Architecture

## Purpose

This file documents the adopted Laravel application architecture for the first working Backend version of the Al Amal Medical Center Management System.

It defines:

* Application organization.
* Module and feature boundaries.
* Shared-component boundaries.
* Request-execution flow.
* Controller, Service, Repository, Model, Form Request, and API Resource responsibilities.
* Route-file organization.
* Dependency-injection conventions.
* Authentication and authorization placement.
* Audit integration.
* Artisan generation conventions.
* Architecture boundaries for deferred features.

This file defines technical organization only.

It must not introduce or alter functional requirements, role permissions, Business Rules, workflows, statuses, fields, or policy values.

## Architecture Style

The Backend uses a modular-monolith architecture inside one Laravel application.

The initial implementation does not use:

* Microservices.
* A complete Domain-Driven Design architecture.
* CQRS.
* Event sourcing.
* An external Laravel module package.

The architecture uses Laravel and PHP namespaces under the normal `app/` directory.

## Standard Request-Execution Flow

The adopted request-execution flow is:

```text
Route
  ↓
Form Request
  ↓
Controller
  ↓
Service / Services
  ↓
Repository / Repositories
  ↓
Eloquent Model
  ↓
Database
  ↓
API Resource
  ↓
JSON Response
```

This flow must be used consistently throughout the implemented scope.

## Application Organization Principle

The application uses a role-first and feature-first organization:

```text
Module
  ↓
User Role
  ↓
Feature or Topic
  ↓
Application Layers
```

The role modules are:

* Patient.
* Doctor.
* Secretary.
* Super Administrator.

Examples of features or topics include:

* Authentication.
* Departments.
* Medical Services.
* Doctors.
* Doctor Accounts.
* Secretary Accounts.

## Adopted Directory Structure

```text
app/
├── Modules/
│   ├── Patient/
│   │   ├── Authentication/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   │
│   │   ├── Departments/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   │
│   │   ├── MedicalServices/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   │
│   │   ├── Doctors/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   │
│   │   └── routes/
│   │       └── api.php
│   │
│   ├── Doctor/
│   │   ├── Authentication/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   └── routes/
│   │       └── api.php
│   │
│   ├── Secretary/
│   │   ├── Authentication/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Requests/
│   │   │   │   └── Resources/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   │   ├── Contracts/
│   │   │   │   └── Eloquent/
│   │   │   └── Models/
│   │   └── routes/
│   │       └── api.php
│   │
│   └── SuperAdministrator/
│       ├── Authentication/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   ├── Requests/
│       │   │   └── Resources/
│       │   ├── Services/
│       │   ├── Repositories/
│       │   │   ├── Contracts/
│       │   │   └── Eloquent/
│       │   └── Models/
│       │
│       ├── DoctorAccounts/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   ├── Requests/
│       │   │   └── Resources/
│       │   ├── Services/
│       │   ├── Repositories/
│       │   │   ├── Contracts/
│       │   │   └── Eloquent/
│       │   └── Models/
│       │
│       ├── SecretaryAccounts/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   ├── Requests/
│       │   │   └── Resources/
│       │   ├── Services/
│       │   ├── Repositories/
│       │   │   ├── Contracts/
│       │   │   └── Eloquent/
│       │   └── Models/
│       │
│       └── routes/
│           └── api.php
│
├── Shared/
│   ├── Identity/
│   │   ├── Models/
│   │   │   └── User.php
│   │   ├── Enums/
│   │   │   └── UserRole.php
│   │   └── Repositories/
│   │       ├── Contracts/
│   │       └── Eloquent/
│   │
│   ├── Directory/
│   │   └── Models/
│   │       ├── Department.php
│   │       ├── MedicalService.php
│   │       └── DoctorWorkingHour.php
│   │
│   ├── Audit/
│   │   ├── Models/
│   │   │   └── AuditLog.php
│   │   └── Repositories/
│   │       ├── Contracts/
│   │       │   └── AuditLogRepositoryInterface.php
│   │       └── Eloquent/
│   │           └── EloquentAuditLogRepository.php
│   │
│   └── Support/
│       ├── Http/
│       │   └── ApiResponse.php
│       ├── Exceptions/
│       └── Pagination/
│
└── Providers/
    ├── ModuleRouteServiceProvider.php
    └── RepositoryServiceProvider.php
```

The tree defines the allowed organization.

A directory does not need to be created until the implemented feature requires at least one file inside it.

## Standard Feature Template

A role-specific feature may use the following template:

```text
Feature/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Services/
├── Repositories/
│   ├── Contracts/
│   └── Eloquent/
└── Models/
```

Not every feature must contain every directory.

Rules:

* Do not create empty directories only to reproduce the complete template.
* A feature uses a local Model only when the Model belongs exclusively to that feature.
* Cross-role Models belong under `app/Shared`.
* A feature may use shared Repositories when the persistence concept is shared.
* Role-specific Services remain inside the role feature.

## Layer Responsibilities

### Routes

Routes define:

* HTTP methods.
* URI paths.
* Route parameters.
* Middleware.
* Controller entry points.

Routes must not contain Business Logic or database-query logic.

### Form Requests

Form Requests define:

* Request input validation.
* Request-level authorization when appropriate.
* Validated input retrieval.
* Validation-error integration.

Form Requests must not perform persistence operations.

### Controllers

Controllers coordinate the HTTP request and response.

A Controller may:

* Receive a validated Form Request.
* Receive route-bound Models or identifiers.
* Invoke one Service.
* Invoke multiple Services.
* Pass results to an API Resource.
* Return the standardized JSON response.

Controllers must not contain Business Logic or direct Eloquent queries.

### Services

Services are the unified task layer.

Each Service represents one clear task or use case.

Examples:

* `LoginService`
* `LogoutService`
* `ChangePasswordService`
* `CreateDoctorService`
* `UpdateDoctorService`
* `ListDepartmentsService`
* `ShowDoctorService`
* `ListDoctorWorkingHoursService`

A Service may:

* Apply Business Logic.
* Enforce task-specific technical rules.
* Use one Repository.
* Use multiple Repositories.
* Coordinate a database transaction.
* Request creation of an audit record through the Audit Repository.
* Return the result required by the Controller.

The initial architecture does not use a separate Action layer.

Task Services should not call other task Services as the normal execution pattern.

When an endpoint needs several independently defined tasks, its Controller may coordinate several Services.

### Repositories

Repositories provide persistence and query operations.

Repository contracts are Interfaces stored under:

`Repositories/Contracts`

Eloquent implementations are stored under:

`Repositories/Eloquent`

Example:

```text
UserRepositoryInterface
        ↓ implemented by
EloquentUserRepository
```

Services depend on Repository Interfaces.

Eloquent query construction belongs in Eloquent Repository implementations.

Repositories must not:

* Format HTTP responses.
* Validate HTTP requests.
* Contain Controller responsibilities.
* Become large general-purpose application Services.
* Decide role-specific workflows.

### Eloquent Models

Eloquent Models define:

* Database-table mapping.
* Relationships.
* Attribute casts.
* Model-level Laravel behavior.
* Safe mass-assignment configuration where used.

Models must not become replacements for Services.

Cross-role Models belong under `app/Shared`.

### API Resources

API Resources transform application results into the approved JSON representation.

API Resources define:

* Exposed response fields.
* Nested response structures.
* Relationship representation.
* Pagination-resource representation when applicable.

API Resources must prevent accidental exposure of sensitive fields.

### Shared Components

`app/Shared` contains components used by more than one role.

Initial shared areas are:

* `Identity`
* `Directory`
* `Audit`
* `Support`

Shared components must not contain role-specific use cases.

## Repository Dependency Injection

Repository Interfaces will be bound to Eloquent implementations through:

`app/Providers/RepositoryServiceProvider.php`

Conceptual binding:

```text
UserRepositoryInterface
→ EloquentUserRepository
```

Services request the Interface through constructor dependency injection.

Services must not instantiate Eloquent Repository implementations directly.

## Module Route Loading

Each role module has one API route file:

```text
app/Modules/Patient/routes/api.php
app/Modules/Doctor/routes/api.php
app/Modules/Secretary/routes/api.php
app/Modules/SuperAdministrator/routes/api.php
```

`app/Providers/ModuleRouteServiceProvider.php` is responsible for loading these route files.

Role route prefixes are:

```text
/api/patient/...
/api/doctor/...
/api/secretary/...
/api/super-administrator/...
```

The initial architecture does not use:

```text
/api/v1/...
```

and does not create a `v1` directory.

## Authentication Placement

Each role module may contain its own Authentication HTTP entry points:

```text
Modules/Patient/Authentication
Modules/Doctor/Authentication
Modules/Secretary/Authentication
Modules/SuperAdministrator/Authentication
```

The underlying authentication behavior must be reused rather than duplicated.

Laravel Sanctum personal-access Bearer Tokens are used for API authentication.

Each role-specific login entry point must verify the role expected by that route.

Protected routes require Sanctum authentication and role authorization.

## Audit Placement

Audit persistence belongs under:

```text
app/Shared/Audit
```

The initial components are:

```text
AuditLog
AuditLogRepositoryInterface
EloquentAuditLogRepository
```

An additional Audit Service is not required initially.

Task Services that require audit logging use:

```text
AuditLogRepositoryInterface
```

directly.

Audit metadata must never contain:

* Passwords.
* Plain-text credentials.
* Access tokens.
* Sensitive secret values.

## Database Transactions

Database transactions are coordinated by the Service responsible for the complete task.

A Service may include several Repository operations in one transaction.

Repositories execute persistence operations but do not define the complete application transaction boundary.

Controllers must not manage database transactions.

## Route Model Binding

Route Model Binding may be used when it makes an endpoint clearer and when the bound Model is appropriate for the route.

It is not mandatory for every endpoint.

Repository-based queries remain the normal persistence boundary for application data access.

Role checks and resource restrictions must still be enforced even when Route Model Binding resolves a Model.

## Artisan Generation

Standard Artisan generators may be used with a fully qualified application class path beginning with `App/`.

Examples:

```bash
php artisan make:controller App/Modules/Patient/Doctors/Http/Controllers/ShowDoctorController --invokable
```

```bash
php artisan make:request App/Modules/Patient/Doctors/Http/Requests/ShowDoctorRequest
```

```bash
php artisan make:resource App/Modules/Patient/Doctors/Http/Resources/DoctorResource
```

```bash
php artisan make:class App/Modules/Patient/Doctors/Services/ShowDoctorService
```

```bash
php artisan make:interface App/Modules/Patient/Doctors/Repositories/Contracts/DoctorRepositoryInterface
```

After generation, the created path and namespace must be reviewed.

Route files and other unsupported custom files may be created manually or by Codex in the documented location.

Custom Artisan project generators are deferred and are not required for the first working version.

## Coding Conventions

The implementation will use:

* English technical naming.
* Laravel naming conventions.
* PSR-12 formatting.
* Laravel Pint.
* Type declarations and return types where applicable.
* Constructor dependency injection.
* Form Requests.
* Thin Controllers.
* Focused task Services.
* Repository Interfaces.
* Eloquent Repository implementations.
* API Resources.
* Composition in preference to unnecessary inheritance.

Traits, abstract classes, and third-party packages must be introduced only when a clear approved technical reason exists.

## Deferred Architecture Areas

The following areas must not be designed beyond confirmed boundaries during the first implementation:

* Appointment scheduling architecture.
* Medical-record architecture.
* Treatment-plan architecture.
* Laboratory and radiology workflows.
* Medical-file storage architecture.
* Payment integration.
* Notification-provider integration.
* Complaint workflows.
* Offer workflows.
* Reporting and analytics.
* Backup implementation.
* Data-retention implementation.
* Production infrastructure.
* Final compliance architecture.

These areas remain deferred until the related requirements, providers, policies, or external details are available.

## Current Status

The first Laravel-architecture decisions required for Phase 5 have been reviewed and adopted.

This file documents the approved organization and layer responsibilities.

No application directories or source-code files have been created by this documentation task.

Database design, API details, testing organization, deployment constraints, and final Phase 5 completion remain to be documented before implementation begins.
