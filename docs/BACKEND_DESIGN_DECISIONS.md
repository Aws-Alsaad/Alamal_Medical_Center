# Backend Design Decisions

## Purpose

This file records approved technical and architectural decisions for the Backend of the Al Amal Medical Center Management System.

It is intended for decisions concerning:

* Laravel project structure.
* Authentication implementation.
* Role-based authorization implementation.
* Database design.
* REST API conventions.
* Validation and error-response conventions.
* Medical-file storage.
* Notifications and external-service boundaries.
* Testing strategy.
* Deployment and infrastructure configuration.

This file must not define or alter functional requirements, user permissions, Business Rules, workflows, or policy values.

## Authoritative Boundaries

Until delivery of the first working Backend version:

* The SRS remains the sole authoritative source for functional requirements.
* `BACKEND_ANALYSIS.md` remains the authoritative SRS-derived Backend baseline.
* `PROJECT_UNDERSTANDING_QA.md` remains the canonical registry for questions not answered by the SRS.
* Technical decisions recorded here must implement the approved functional scope without expanding or changing it.
* A technical decision must not answer an unresolved functional question through assumption.

## Decision Statuses

Each technical decision must use one of the following statuses:

* **Proposed:** Under review and not approved for implementation.
* **Adopted:** Approved for implementation.
* **Deferred:** Intentionally postponed because it is not currently required or depends on unresolved information.
* **Superseded:** Replaced by a later approved technical decision.

## Decision Record Format

Each future decision should include:

* Decision identifier.
* Title.
* Status.
* Date.
* Context.
* Decision.
* Rationale.
* Consequences.
* Related requirements and documentation.
* Superseded decision reference when applicable.

## Adopted Phase 5 Decisions

### TAD-001 — Initial Technology Baseline

**Status:** Amended and Adopted

**Original Date:** 2026-08-04

**Amended Date:** 2026-08-09

#### Context

The approved first-version Backend scope requires a stable Laravel, PHP, MariaDB, and Composer baseline before implementation begins.

#### Decision

The initial Backend implementation will use:

* Laravel `13.x`.
* PHP `8.4.x`.
* MariaDB `10.4.32`.
* Composer `2.x`.

Local development will initially use:

* A local Windows development environment.
* A locally running MariaDB `10.4.32` database provided through XAMPP.
* Laravel's local development server through `php artisan serve`.

Docker is not required for the first working version.

The codebase must remain compatible with later Apache-based deployment.

Production HTTPS and final server configuration remain deployment concerns and must not be finalized until the hosting environment is known.

#### Rationale

This baseline provides current supported technologies while avoiding additional local-infrastructure setup that would delay the first working version.

#### Consequences

* Implementation and tests must use the adopted versions.
* Docker-specific files are not required in the first implementation wave.
* Final production hosting, HTTPS termination, and server configuration remain deferred.

#### Related Requirements and Documentation

* `DEVELOPMENT_PLAN.md`
* `DEPLOYMENT.md`
* `LARAVEL_ARCHITECTURE.md`

---

### TAD-002 — Modular Monolith Architecture

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The Backend must remain modular, maintainable, testable, and ready for later expansion without introducing unnecessary distributed-system complexity.

#### Decision

The Backend will use a modular-monolith architecture inside one Laravel application.

The application will not use:

* Microservices.
* Domain-Driven Design as a complete architectural framework.
* CQRS.
* Event sourcing.
* An external Laravel module package for the first working version.

The architecture will use normal Laravel and PHP namespaces under `app/`.

#### Rationale

A modular monolith provides clear boundaries and organization while preserving fast local development, simple deployment, and one database transaction boundary.

#### Consequences

* All role modules and shared components remain in one Laravel application.
* Modules must not duplicate shared models or shared infrastructure.
* Future features can be added as new role topics without redesigning the whole application.

#### Related Requirements and Documentation

* `DEVELOPMENT_PLAN.md`
* `LARAVEL_ARCHITECTURE.md`

---

### TAD-003 — Role-First and Feature-First Organization

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The project requires a structure in which a developer can begin from a user role and then locate all files related to a specific topic or task.

#### Decision

Application functionality will be organized using:

`Module → User Role → Feature or Topic → Layer`

The role modules are:

* `Patient`
* `Doctor`
* `Secretary`
* `SuperAdministrator`

Examples of topics include:

* `Authentication`
* `Departments`
* `MedicalServices`
* `Doctors`
* `DoctorAccounts`
* `SecretaryAccounts`

Each topic may contain its own:

* Controllers.
* Form Requests.
* API Resources.
* Services.
* Repository contracts.
* Eloquent Repository implementations.
* Role-specific HTTP, Service, and Repository components when the topic requires them.

The approved first-version Eloquent Models are centralized under `app/Models` so persistence entities are explicit and easy to locate. Shared non-model infrastructure remains under `app/Shared`.

#### Rationale

This organization keeps all files for one role-specific topic close together and makes the project easier to navigate, understand, extend, and represent in class diagrams.

#### Consequences

* The previous general `Core + Modules` proposal is superseded.
* Role-specific controllers and services must not be placed in large global folders.
* Eloquent Models must not be duplicated in individual role modules.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`

---

### TAD-004 — Standard Request Execution Flow

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The project requires one consistent execution flow for implemented HTTP requests.

#### Decision

The standard execution flow is:

`Route → Form Request → Controller → Service or Services → Repository or Repositories → Eloquent Model → Database → API Resource → ApiResponse → JSON Response`

The flow must be applied consistently throughout the implemented scope.

`ApiResponse` is the centralized final HTTP/JSON response-envelope layer. It wraps the representation produced by the API Resource without changing the responsibility of any preceding layer.

#### Rationale

A consistent flow provides predictable responsibilities, improves testability, and prevents Business Logic and database access from becoming mixed inside Controllers.

#### Consequences

* Controllers remain thin.
* Business Logic belongs in Services.
* Database access belongs in Repositories.
* Input validation belongs in Form Requests.
* Output transformation belongs in API Resources.
* Final HTTP/JSON response-envelope formatting belongs in `ApiResponse` and must remain centralized.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`
* `API_SPECIFICATION.md`
* `TESTING.md`

---

### TAD-005 — Service as the Unified Task Layer

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The project requires one consistent naming and responsibility model for application tasks.

#### Decision

Services will be the unified task-execution layer.

There will be no separate Action layer.

Each Service must represent one clear task or use case, for example:

* `LoginService`
* `LogoutService`
* `ChangePasswordService`
* `CreateDoctorService`
* `UpdateDoctorService`
* `ListDepartmentsService`
* `ShowDoctorService`
* `ListDoctorWorkingHoursService`

A Controller may invoke one Service or multiple Services when one HTTP response requires several independently defined tasks.

A Service may use one Repository or multiple Repositories.

Services contain Business Logic and may coordinate database transactions.

#### Rationale

Using one task-layer name throughout the project avoids an inconsistent mixture of Actions and Services.

#### Consequences

* No `Actions` directories will be introduced.
* Controllers must not implement Business Logic.
* Repositories must not become use-case coordinators.
* Task Services must remain focused and avoid becoming large general-purpose classes.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`

---

### TAD-006 — Repository Contracts and Eloquent Implementations

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The project requires explicit object-oriented separation between application logic and database-query implementation.

#### Decision

Database access must pass through Repositories.

Repositories will use:

* An Interface inside a `Contracts` directory.
* An Eloquent implementation inside an `Eloquent` directory.

Example:

`UserRepositoryInterface → EloquentUserRepository`

Services depend on Repository Interfaces rather than concrete Eloquent Repository classes.

Repository bindings will be registered through Laravel's Service Container using a Service Provider.

An abstract base Repository will not be introduced initially.

Abstract classes may be introduced later only when a real shared implementation exists.

#### Rationale

Interfaces provide explicit contracts, improve dependency inversion, and allow implementations to be replaced or tested without coupling Services directly to Eloquent query code.

#### Consequences

* Eloquent queries must not be written directly inside Controllers.
* Services must request Repository contracts through dependency injection.
* General-purpose Repositories containing unrelated operations must not be created.
* Repositories must remain focused on persistence and data retrieval.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`
* `TESTING.md`

---

### TAD-007 — Shared Components Boundary

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

Some technical components are used by more than one role and must not be duplicated inside individual role modules. The first-version Eloquent Models are centralized separately under `app/Models`.

#### Decision

Shared components will be placed under:

`app/Shared`

The initial shared areas are:

* `Identity`
* `Audit`
* `Support`

Examples of shared components include:

* `UserRole`
* Repository contracts and implementations used across roles.
* Standard API-response support.
* Shared authentication and exception support.

#### Rationale

A shared boundary avoids duplicate infrastructure while keeping role-specific use cases inside role modules and persistence entities in one visible model directory.

#### Consequences

* Each Eloquent Model has one authoritative class under `app/Models`.
* Role modules may depend on shared components.
* Shared components must not contain role-specific use cases.
* General Business Logic must not be moved into `Shared` merely to avoid choosing a module.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`

---

### TAD-008 — Role-Based Route Files

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The API requires clear separation between Patient, Doctor, Secretary, and Super Administrator entry points.

#### Decision

Each role module will have one API route file:

* `app/Modules/Patient/routes/api.php`
* `app/Modules/Doctor/routes/api.php`
* `app/Modules/Secretary/routes/api.php`
* `app/Modules/SuperAdministrator/routes/api.php`

A dedicated application Service Provider will load the module route files.

Routes will use role prefixes such as:

* `/api/patient/...`
* `/api/doctor/...`
* `/api/secretary/...`
* `/api/super-administrator/...`

The initial API will not include a `/v1` path or a `v1` directory.

#### Rationale

Role-prefixed route groups make entry points and authorization boundaries explicit while keeping route files small and organized.

#### Consequences

* Routes must not all be placed in one large file.
* Route groups must apply the appropriate authentication and role middleware.
* Shared implementation may still be reused behind separate role-specific routes.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`
* `API_SPECIFICATION.md`

---

### TAD-009 — Authentication and Role Authorization

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The Backend must serve React and Flutter clients through protected JSON APIs and enforce the four confirmed roles.

#### Decision

Authentication will use Laravel Sanctum personal-access Bearer Tokens.

The application will use one shared authentication implementation while exposing role-specific login routes.

A login request must verify:

* The submitted credentials.
* The role expected by the selected login route.

A user with valid credentials but a role that does not match the route must be rejected.

Role authorization will be enforced through middleware and appropriate Laravel authorization mechanisms.

Logout will revoke the token used for the current request.

Authenticated password change is distinct from the deferred forgotten-password reset flow.

#### Rationale

Sanctum Bearer Tokens provide a direct Laravel-supported authentication mechanism suitable for both React and Flutter API clients.

#### Consequences

* Protected API routes require Sanctum authentication.
* Role mismatch must have a consistent error response.
* Authentication logic must be reused and not duplicated between role modules.
* Password-reset delivery and verification remain deferred.

#### Related Requirements and Documentation

* `DEVELOPMENT_PLAN.md`
* `LARAVEL_ARCHITECTURE.md`
* `API_SPECIFICATION.md`
* `TESTING.md`

---

### TAD-010 — Audit Integration Architecture

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The SRS requires logging of login attempts, data updates, administrative changes, and other confirmed critical actions.

#### Decision

Audit repository infrastructure will be a shared cross-cutting component under:

`app/Shared/Audit`

The initial Audit implementation contains:

* The `AuditLog` Eloquent Model under `app/Models/AuditLog.php`.
* `AuditLogRepositoryInterface`.
* `EloquentAuditLogRepository`.

An additional Audit Service layer will not be introduced initially.

Task Services will use `AuditLogRepositoryInterface` directly when an implemented task requires an audit record.

Examples include:

* Login Services.
* Password-change Services.
* Doctor-account Services.
* Secretary-account Services.

Sensitive values, passwords, and access tokens must never be stored in audit metadata.

#### Rationale

Direct use of the Audit Repository by task Services preserves the agreed execution flow and avoids introducing a Service-to-Service layer.

#### Consequences

* Audit creation remains coordinated by the task Service.
* Audit writes may participate in the same database transaction as the related data modification where appropriate.
* Final retention, access, and complete event definitions remain unresolved and deferred.

#### Related Requirements and Documentation

* `BUSINESS_RULES.md`
* `BACKEND_ANALYSIS.md`
* `DATABASE_DESIGN.md`
* `LARAVEL_ARCHITECTURE.md`

---

### TAD-011 — Laravel Class Generation and Custom Paths

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The application uses explicit namespaces under `app/Models`, `app/Modules`, and `app/Shared`, while standard Artisan generators normally use Laravel's default locations when only a simple class name is supplied.

#### Decision

Artisan generators may be used with a fully qualified application class path beginning with `App/`.

Examples include:

* Controllers generated under `App/Modules/...`.
* Form Requests generated under `App/Modules/...`.
* API Resources generated under `App/Modules/...`.
* Services generated as classes under `App/Modules/...`.
* Repository contracts generated as interfaces under the required feature path.

The resulting path and namespace must always be reviewed after generation.

Route files and other unsupported custom files may be created manually or by Codex in their documented locations.

Custom Artisan generator commands will not be built for the first working version.

#### Rationale

Using the existing Laravel generators where practical is faster than building project-specific generators while still supporting the adopted namespace organization.

#### Consequences

* Simple generator names must not be assumed to target the custom module folders.
* Generated namespaces and paths must be checked.
* Building custom scaffolding commands remains optional future work.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`

---

### TAD-012 — Coding and Implementation Conventions

**Status:** Amended and Adopted

**Original Date:** 2026-08-04

**Amended Date:** 2026-08-14

#### Context

The Backend requires consistent and maintainable code across all modules.

#### Decision

The initial implementation will follow:

* English class, method, variable, database, route, and technical names.
* Laravel naming conventions.
* PSR-12 remains the general formatting reference except where explicitly superseded by the approved project-specific Laravel Pint rules recorded in this decision.
* Laravel Pint for automated formatting.
* Type declarations and return types where applicable.
* Form Requests for request validation.
* Thin Controllers.
* API Resources for response transformation.
* Constructor dependency injection.
* Small focused classes.
* Composition in preference to inheritance unless a genuine inheritance relationship exists.

The consolidated Phase 6 implementation adds these code-writing conventions:

* Controllers and Services use explicit operation names such as `login()`, `getDepartments()`, and `createDoctor()`; current endpoints do not use `__invoke()` or generic `execute()` methods.
* Constructor dependencies use explicitly declared private properties and assignments rather than property promotion or decorative `readonly` declarations.
* Repositories prefer direct readable Eloquent expressions and existing Eloquent relationships; `query()` is used only when it adds value.
* Function and method opening braces stay on the declaration line. Control-structure continuations such as `else` begin on the next line.
* Names are descriptive, comments explain only non-obvious reasons, and redundant DocBlocks are avoided when native types and names are sufficient.
* Form Requests retain validation, API Resources retain output control, and centralized `ApiResponse` and error handling retain the API contract.
* New abstraction layers are not introduced without a demonstrated requirement.

Traits and abstract classes may be used only when they provide clear reusable behavior and do not hide application flow.

Additional third-party packages must not be added unless they solve a confirmed requirement and are approved first.

#### Rationale

These conventions support readability, consistency, testing, and later maintenance without adding unnecessary architectural complexity.

#### Consequences

* Formatting must be checked through Laravel Pint.
* The repository `pint.json` preserves the approved brace and continuation style.
* Controllers, Services, and Repositories must preserve their assigned responsibilities.
* Unnecessary packages and abstractions must be avoided.
* General Laravel scaffold is removed only after repository and framework references prove it unused; framework-required files are retained.

#### Related Requirements and Documentation

* `LARAVEL_ARCHITECTURE.md`
* `TESTING.md`

---

### TAD-013 — Minimum First-Version Database Schema

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The approved immediate scope requires authentication, role authorization, Doctor and Secretary account administration, a minimum read-only medical-center directory, Doctor working-hour viewing, Sanctum token persistence, and audit logging.

The SRS does not define complete account-profile, department, service, or Doctor-profile field sets.

#### Decision

The first implementation will create only these application and framework tables:

* `users`
* `departments`
* `medical_services`
* `doctor_working_hours`
* `audit_logs`
* `personal_access_tokens`

The minimum `users` representation contains:

* `id`
* `name`
* `email`
* `password`
* `role`
* `created_at`
* `updated_at`

The `role` database column will use `VARCHAR(32)`.

Application code will represent role values through a PHP string-backed Enum with these values:

* `patient`
* `doctor`
* `secretary`
* `super_administrator`

The initial database will not add:

* `is_active`
* `status`
* `revoked_at`
* `deleted_at`
* `email_verified_at`
* A role-specific profile table

The minimum directory representation contains:

* Department identifier and name.
* Medical-service identifier, name, and cost.
* Doctor identifier and name through the shared `users` representation.
* Doctor weekly working periods through `doctor_working_hours`.

A `doctor_profiles` table will not be created in the immediate implementation.

No database relationship between departments and medical services will be introduced until that relationship is supported by the authoritative functional source or formally confirmed later.

Laravel Sanctum will use its standard `personal_access_tokens` table.

#### Rationale

This schema implements only the approved immediate scope and avoids converting unresolved profile and directory definitions into permanent functional requirements.

#### Consequences

* The first implementation exposes only minimum approved directory fields.
* Professional Doctor-profile fields remain deferred.
* Patient and Secretary profile tables remain deferred.
* Account activation, deactivation, revocation, deletion, and soft-deletion behavior remain deferred.
* Additional domain tables must not be created during the immediate implementation.

#### Related Requirements and Documentation

* `BACKEND_ANALYSIS.md`
* `DEVELOPMENT_PLAN.md`
* `DATABASE_DESIGN.md`
* `PROJECT_UNDERSTANDING_QA.md`

---

### TAD-014 — Database Integrity and Persistence Conventions

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The immediate database schema requires consistent keys, indexes, constraints, timestamps, and transaction boundaries.

#### Decision

The database will use:

* MariaDB `10.4.32`.
* Unsigned big-integer primary keys.
* Laravel timestamps where both creation and modification are required.
* Foreign-key constraints for confirmed relationships.
* Unique indexing for user email.
* An index for user role.
* A composite index for Doctor working hours by Doctor and weekday.
* `DECIMAL(10,2)` for medical-service cost.
* Database and application validation preventing negative service costs.
* Database and application validation restricting `day_of_week` to `1` through `7`.
* A rule requiring working-period end time to be later than start time.
* Service-coordinated database transactions when one task performs multiple related persistence operations.

The adopted weekday mapping is:

* `1` — Saturday
* `2` — Sunday
* `3` — Monday
* `4` — Tuesday
* `5` — Wednesday
* `6` — Thursday
* `7` — Friday

Repositories execute persistence operations.

The Service responsible for the complete use case defines the transaction boundary.

Controllers do not manage database transactions.

#### Rationale

These conventions provide predictable persistence behavior and protect basic data integrity without introducing unresolved scheduling policies.

#### Consequences

* Working hours represent recurring weekly display data only.
* The schema does not define appointment availability, leave, holidays, temporary changes, overlaps, or schedule-administration workflows.
* Future schema changes require a new reviewed decision and migration.

#### Related Requirements and Documentation

* `DATABASE_DESIGN.md`
* `LARAVEL_ARCHITECTURE.md`
* `TESTING.md`

---

### TAD-015 — REST API and JSON Representation

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

React and Flutter clients require one predictable REST and JSON interface.

#### Decision

The API will use:

* JSON requests and responses.
* Role-prefixed API paths.
* `snake_case` JSON field names.
* ISO 8601 date and time representation.
* UTC for stored application timestamps.
* API Resources for output transformation.
* One centralized response format.

The initial route prefixes are:

* `/api/patient/...`
* `/api/doctor/...`
* `/api/secretary/...`
* `/api/super-administrator/...`

The initial API does not use `/api/v1` or a `v1` directory.

A successful response uses:

```json
{
  "success": true,
  "status_code": 200,
  "message": "Request completed successfully.",
  "data": {}
}
```

An error response uses:

```json
{
  "success": false,
  "status_code": 422,
  "message": "The provided data is invalid.",
  "error_code": "VALIDATION_ERROR",
  "errors": {}
}
```

Messages are written in English in the immediate Backend implementation.

Stack traces and sensitive technical details must never be returned to clients.

#### Rationale

One response contract simplifies client integration, validation handling, testing, and later maintenance.

#### Consequences

* Controllers and API Resources must use the centralized response format.
* Sensitive model fields must not be exposed accidentally.
* Future localization of response messages remains deferred.

#### Related Requirements and Documentation

* `API_SPECIFICATION.md`
* `LARAVEL_ARCHITECTURE.md`
* `TESTING.md`

---

### TAD-016 — Complete Collection Convention

**Status:** Amended and Adopted

**Original Date:** 2026-08-04

**Amended Date:** 2026-08-14

#### Context

The approved first-version Patient directory contains limited Department, Medical Service, and Doctor collection endpoints. Pagination was removed as an explicitly approved Phase 6 API simplification.

#### Decision

The current list endpoints return their complete approved result sets in one response:

* Department lists.
* Medical-service lists.
* Doctor lists.

These endpoints do not accept `page` or `per_page` and do not return pagination links or metadata. No replacement pagination mechanism is introduced.

#### Rationale

This keeps the first-version API and client integration simple while preserving the exact approved route and field scope.

#### Consequences

* Repositories return Eloquent collections for the current list operations.
* Tests verify that all expected records are returned.
* Postman and current API documentation contain no collection page parameters or metadata.

#### Related Requirements and Documentation

* `API_SPECIFICATION.md`
* `TESTING.md`

---

### TAD-017 — Validation and Error Conventions

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The immediate scope requires consistent validation and clear handling of invalid input, authentication failures, authorization failures, missing resources, conflicts, and unexpected errors.

#### Decision

HTTP input validation will use Form Requests.

Reusable custom validation Rules may be introduced only when the same confirmed validation behavior is needed in more than one request.

The initial HTTP status conventions are:

* `200` — Successful request.
* `201` — Resource created.
* `400` — Invalid general request.
* `401` — Unauthenticated.
* `403` — Authenticated but forbidden.
* `404` — Resource not found.
* `409` — Data conflict.
* `422` — Validation failure.
* `429` — Too many requests.
* `500` — Unexpected server error.

The initial stable application error codes are:

* `VALIDATION_ERROR`
* `INVALID_CREDENTIALS`
* `ROLE_MISMATCH`
* `UNAUTHENTICATED`
* `FORBIDDEN`
* `RESOURCE_NOT_FOUND`
* `DATA_CONFLICT`
* `TOO_MANY_REQUESTS`
* `INTERNAL_SERVER_ERROR`

Validation will be defined only for fields included in the immediate implementation.

Final password-strength values, failed-login thresholds, session-expiration values, role-specific profile validations, and future domain validations remain unresolved.

#### Rationale

Stable error structures make client behavior predictable without defining future domain errors prematurely.

#### Consequences

* Appointment, payment, notification, record, treatment, and other deferred-domain errors must not be invented.
* Validation errors must use the standard JSON error envelope.
* Unexpected exceptions are written to Laravel's technical log and return a safe generic response.

#### Related Requirements and Documentation

* `API_SPECIFICATION.md`
* `TESTING.md`
* `PROJECT_UNDERSTANDING_QA.md`

---

### TAD-018 — Initial Super Administrator Provisioning

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The first working version requires an initial Super Administrator account before other staff accounts can be created.

#### Decision

The initial Super Administrator will be provisioned through a database Seeder.

The Seeder will read these values from environment configuration:

* `SUPER_ADMIN_NAME`
* `SUPER_ADMIN_EMAIL`
* `SUPER_ADMIN_PASSWORD`

The password must be hashed before persistence.

Real credentials must not be stored in:

* Source code.
* Seeders.
* Documentation.
* `.env.example`.
* Git history.

`.env.example` may include the variable names only with safe placeholder values.

Factories and test Seeders will use non-sensitive test data.

#### Rationale

Environment-driven provisioning allows a repeatable initial setup without committing credentials.

#### Consequences

* The initial account is created through explicit setup, not through a public registration endpoint.
* The Seeder must be safe to run according to the implementation task's documented behavior.
* Production credential handling remains an environment and deployment responsibility.

#### Related Requirements and Documentation

* `DATABASE_DESIGN.md`
* `DEPLOYMENT.md`
* `TESTING.md`

---

### TAD-019 — Testing Strategy

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The immediate Backend scope requires unit, integration, system, security, authorization, validation, data-integrity, and API behavior verification.

#### Decision

The initial automated testing stack will use:

* PHPUnit through Laravel's test runner.
* Laravel Feature Tests.
* Laravel Unit Tests.
* Laravel database-testing utilities.
* Model Factories.
* Test Seeders where necessary.

A Postman Collection will provide supplementary manual and client-facing API verification after endpoints are implemented.

Feature Tests are the first testing priority because they verify the complete HTTP, authentication, validation, Service, Repository, persistence, and response path.

The implementation must test:

* Successful login.
* Invalid credential rejection.
* Role-route mismatch rejection.
* Protected-route authentication.
* Role authorization for all four roles.
* Logout.
* Authenticated password change.
* Super Administrator Doctor-account creation and editing.
* Super Administrator Secretary-account creation and editing.
* Patient read-only directory access.
* Complete collection responses.
* Validation behavior.
* Standard JSON success and error formats.
* Required audit-log generation.
* Transaction and data-integrity behavior.
* Protection against exposing sensitive fields.

No percentage-based code-coverage threshold is adopted during Phase 5.

Final performance acceptance remains pending until the unresolved performance-test conditions are defined.

#### Rationale

This approach prioritizes observable application behavior and supports later unit isolation where focused logic requires it.

#### Consequences

* A feature is not complete until its required tests pass.
* Tests must use isolated test data.
* Postman does not replace automated tests.
* Test organization must follow the role and feature boundaries where practical.

#### Related Requirements and Documentation

* `TESTING.md`
* `DEVELOPMENT_PLAN.md`
* `LARAVEL_ARCHITECTURE.md`

---

### TAD-020 — Local Development and Deployment Boundary

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

Local implementation must begin immediately, while the production hosting environment and external infrastructure remain unresolved.

#### Decision

The initial development environment will use:

* Windows.
* Local PHP and Composer.
* Local MariaDB `10.4.32` provided through XAMPP.
* `php artisan serve`.

Docker is not required for the first working version.

The codebase must remain compatible with later Apache-based hosting.

Production HTTPS is required as a deployment boundary, but its certificate, termination, proxy, and server configuration are deferred until the hosting environment is known.

The following remain unresolved and must not be selected during the immediate implementation:

* Hosting provider.
* Server specifications.
* Domain and DNS configuration.
* Production operating system.
* Production database topology.
* Backup and recovery implementation.
* Retention periods.
* Compliance implementation.
* Monitoring provider.
* External medical-file storage.
* Payment provider.
* Notification provider.
* Reporting infrastructure.

#### Rationale

This decision enables immediate local implementation while preserving unresolved production and organizational boundaries.

#### Consequences

* Production deployment instructions remain intentionally incomplete.
* Secrets are provided through environment configuration and never committed.
* Deployment documentation must distinguish adopted local setup from deferred production setup.

#### Related Requirements and Documentation

* `DEPLOYMENT.md`
* `DEVELOPMENT_PLAN.md`
* `PROJECT_UNDERSTANDING_QA.md`

---

### TAD-021 — Git and GitHub Repository Policy

**Status:** Adopted  
**Date:** 2026-08-04

#### Context

The project requires version control and read access for teammates.

#### Decision

The GitHub repository will be Public.

The branch policy is:

* `main` — primary stable branch.
* `backend-development` — Backend integration and normal Backend development branch.
* `feat/<feature-name>` — optional bounded feature branch.

Normal Backend work must not be committed directly to `main`.

Teammates currently require clone and read access only.

Collaborator access is not currently required.

Collaborator access will be added only if direct push permission is later needed.

Secrets and real credentials must never be committed.

#### Rationale

A Public repository allows teammates to clone and inspect the project immediately while the branch policy protects the stable branch.

#### Consequences

* Every committed file is publicly visible.
* `.env`, credentials, access tokens, private keys, and runtime logs must remain excluded.
* Complete command guidance is maintained in `GIT_GITHUB_GUIDE.md`.

#### Related Requirements and Documentation

* `GIT_GITHUB_GUIDE.md`
* `DEPLOYMENT.md`

## Current Status

Phases 0 through 5 are complete.

Phase 6 implementation of the approved first working Backend version is complete, including the consolidated Phase 6 coding-style and architecture refactor.

The current implementation contains the approved `23` API routes. Pagination has been superseded by complete collection responses, and MariaDB is the currently approved implementation database platform.

Deferred functionality remains deferred. The Backend is awaiting final repository commit and push closeout before moving to the next implementation phase.
