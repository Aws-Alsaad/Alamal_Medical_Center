# Testing

## Purpose

This file documents the adopted testing strategy for the immediate first working Backend version.

It defines:

* Testing tools.
* Test categories.
* Test organization.
* Test database rules.
* Factories and Seeders.
* Required authentication, authorization, API, validation, audit, and persistence tests.
* Postman usage.
* Quality gates.
* Deferred performance acceptance.

This file must not introduce functional behavior that is absent from the approved immediate scope.

## Testing Stack

The initial testing stack uses:

* PHPUnit through Laravel's test runner.
* Laravel Feature Tests.
* Laravel Unit Tests.
* Laravel database-testing utilities.
* Model Factories.
* Test Seeders when useful.
* Postman as supplementary manual API verification.

Postman does not replace automated tests.

## Testing Priorities

Priority order:

1. Feature Tests for complete implemented behavior.
2. Focused Unit Tests for isolated logic.
3. Integration verification for Repository and database behavior.
4. Postman verification for manual and client-facing review.
5. Performance measurements where the unresolved environment permits meaningful observation.

## Standard Tested Flow

Feature Tests should verify the complete implemented path:

```text
HTTP Request
  ↓
Authentication and Middleware
  ↓
Form Request Validation
  ↓
Controller
  ↓
Service / Services
  ↓
Repository / Repositories
  ↓
Database
  ↓
API Resource
  ↓
JSON Response
```

## Test Organization

Tests remain in Laravel's standard test root:

```text
tests/
├── Feature/
└── Unit/
```

Within those roots, tests should be grouped by role and feature where practical.

Example:

```text
tests/
├── Feature/
│   ├── Patient/
│   │   ├── Authentication/
│   │   └── Directory/
│   ├── Doctor/
│   │   └── Authentication/
│   ├── Secretary/
│   │   └── Authentication/
│   └── SuperAdministrator/
│       ├── Authentication/
│       ├── DoctorAccounts/
│       └── SecretaryAccounts/
│
└── Unit/
    ├── Services/
    ├── Repositories/
    └── Support/
```

Do not create empty test directories only to reproduce this example.

## Test Environment

Automated tests must use an isolated test environment.

Rules:

* Use `.env.testing` or equivalent test configuration.
* Keep the machine-specific `.env.testing` file Git-ignored.
* Copy `.env.testing.example` to `.env.testing` and supply only local test credentials when setting up another machine.
* Never use production credentials.
* Never run destructive tests against a production database.
* Use a separate MariaDB testing database rather than the development or production database.
* Use `alamal_medical_center_testing` as the dedicated local testing database.
* Never point the test environment at the development database `alamal_medical_center`.
* Use MariaDB `10.4.32` as the approved database-backed test platform.
* Laravel may use `DB_CONNECTION=mysql` for the testing database because Laravel's MySQL connection and driver are used to connect to MariaDB.
* Reset database state between tests through Laravel database-testing facilities.
* Keep tests deterministic.
* Do not depend on test execution order.
* Do not depend on external providers for the immediate scope.

## Factories

Factories should create valid minimum test representations for:

* Users by role.
* Departments.
* Medical services.
* Doctor working hours.
* Audit logs where direct factory setup is useful.

Factories must use non-sensitive fake values.

Role-specific factory states may include:

```text
patient
doctor
secretary
super_administrator
```

## Seeders

Seeders may support:

* The initial Super Administrator setup.
* Repeatable local sample data.
* Repeatable test preparation where a Seeder is clearer than direct factory setup.

Tests must not depend on real account credentials.

## Authentication Tests

Required tests include:

### Login Success

Verify:

* Valid credentials succeed.
* The response uses the standard success envelope.
* The response includes a Sanctum Bearer Token.
* The returned user representation excludes sensitive fields.
* A successful-login audit record is created.

### Invalid Credentials

Verify:

* Invalid credentials return `401`.
* The error code is `INVALID_CREDENTIALS`.
* No token is created.
* A failed-login audit record is created without storing the submitted password.

### Role Mismatch

Verify:

* Valid credentials used through another role's route are rejected.
* The error code is `ROLE_MISMATCH`.
* No token is created.
* A role-mismatch audit record is created.

### Protected Routes

Verify:

* Missing tokens are rejected.
* Invalid tokens are rejected.
* Valid tokens authenticate the user.
* Role middleware rejects unauthorized roles.

### Logout

Verify:

* The current token is revoked.
* The standard success response is returned.
* Other tokens are not revoked unless explicitly intended by the implemented operation.
* The required audit record is created.

### Authenticated Password Change

Verify:

* Authentication is required.
* The current password must be correct.
* The confirmation must match.
* The new password is hashed.
* Plain-text passwords are never stored.
* The required audit record is created.
* The forgotten-password flow is not introduced.

## Authorization Tests

Authorization tests must cover:

* Patient route access.
* Doctor route access.
* Secretary route access.
* Super Administrator route access.
* Rejection of each unauthorized role.
* Super Administrator-only staff-account administration.
* Rejection of a Doctor, Secretary, or Patient attempting staff-account administration.
* Verification that Doctor, Secretary, and Patient tokens are rejected when used with Super Administrator staff-account endpoints.
* Verification that role values cannot be changed through staff-account update payloads.

Only endpoints included in the immediate API specification are tested.

## Doctor-Account Administration Tests

Verify:

* Super Administrator can create a Doctor account.
* The role is assigned as `doctor`.
* The request cannot choose another role.
* Email uniqueness is enforced.
* Password is hashed.
* The standard `201` response is returned.
* The audit record is created.
* The account and audit operation preserve transaction integrity.
* Super Administrator can edit the minimum supported account fields.
* The edit endpoint rejects a target that is not a Doctor.
* Professional-profile fields are not accepted.
* Revocation and deletion behavior are not introduced.

## Secretary-Account Administration Tests

Verify:

* Super Administrator can create a Secretary account.
* The role is assigned as `secretary`.
* The request cannot choose another role.
* Email uniqueness is enforced.
* Password is hashed.
* The standard `201` response is returned.
* The audit record is created.
* The account and audit operation preserve transaction integrity.
* Super Administrator can edit the minimum supported account fields.
* The edit endpoint rejects a target that is not a Secretary.
* Role-specific profile fields are not accepted.
* Revocation and deletion behavior are not introduced.

## Patient Directory Tests

### Departments

Verify:

* Patient can list departments.
* Patient can view a department.
* Only `id` and `name` are returned.
* Missing departments return `404`.
* The list returns every expected Department record in one collection response.

### Medical Services

Verify:

* Patient can list medical services.
* Patient can view a medical service.
* Only `id`, `name`, and `cost` are returned.
* Negative cost data is rejected by the implemented integrity controls.
* No unsupported department relationship is returned.
* The list returns every expected Medical Service record in one collection response.

### Doctors

Verify:

* Patient can list users with the Doctor role.
* Non-Doctor users are excluded.
* Patient can view a Doctor.
* Only the approved minimum fields are returned.
* Email, password, password hash, and tokens are not returned.
* Missing Doctors return `404`.
* The list returns every expected Doctor record in one collection response.

### Doctor Working Hours

Verify:

* Patient can view Doctor working hours.
* A non-Doctor target is rejected.
* `day_of_week` accepts only `1` through `7`.
* End time must be later than start time.
* Returned fields are limited to:
  - `day_of_week`
  - `start_time`
  - `end_time`
* No appointment availability is calculated.

## Complete Collection Tests

Verify:

* Department, Medical Service, and Doctor list endpoints return all expected records.
* Collection responses contain the approved fields only.
* Collection responses contain no pagination links or metadata.

## Validation Tests

For every implemented Form Request, verify:

* Required fields.
* Field types.
* Email format.
* Email uniqueness.
* Maximum supported lengths.
* Password confirmation.
* Correct current password where required.
* Rejection of unsupported fields when required by the implementation boundary.
* Standard validation-error JSON.
* HTTP status `422`.
* Error code `VALIDATION_ERROR`.

Final password-strength values must not be invented by tests.

## JSON Contract Tests

Verify successful responses contain:

```text
success
status_code
message
data
```

Verify failed responses contain:

```text
success
status_code
message
error_code
```

Verify field-level validation failures include:

```text
errors
```

Verify:

* `status_code` matches the HTTP status.
* JSON fields use `snake_case`.
* Sensitive implementation details are absent.
* Stack traces are absent.
* API Resources expose only approved fields.

## Error Tests

Verify:

* `401` for unauthenticated or invalid credential behavior where specified.
* `403` for forbidden role access.
* `404` for missing resources.
* `409` for implemented data conflicts.
* `422` for validation errors.
* `429` only when an adopted rate-limit condition is configured.
* `500` responses remain generic and do not expose stack traces.

Do not invent errors for deferred domains.

## Audit-Log Tests

Verify required immediate events:

* Successful login.
* Failed login.
* Role mismatch.
* Logout.
* Password change.
* Doctor-account creation.
* Doctor-account editing.
* Secretary-account creation.
* Secretary-account editing.
* Implemented administrative changes.

Verify audit records:

* Identify the actor when known.
* Allow a null actor for unknown failed-login identities.
* Include action and outcome.
* Do not store passwords.
* Do not store access tokens.
* Do not store secret values.
* Preserve the related data operation's transaction integrity where appropriate.

## Repository Tests

Repository-focused tests should verify:

* Documented query filters.
* Role-filtered Doctor queries.
* Complete collection queries.
* Persistence operations.
* Unique-email conflicts.
* Confirmed relationships.
* Documented indexes and constraints where observable.
* No role-specific Business Logic is moved into a Repository.

## Service Tests

Service-focused tests should verify:

* One clear task responsibility.
* Correct Repository interaction.
* Correct use of multiple Repositories where required.
* Transaction behavior.
* Audit Repository interaction.
* Role and task rules.
* Error propagation without exposing sensitive details.

Task Services should not normally call other task Services.

## Security Verification

Verify:

* Passwords are hashed.
* Plain-text passwords are not persisted or logged.
* Access tokens are not logged.
* Protected routes require authentication.
* Role middleware is enforced.
* Mass assignment does not permit role or sensitive-field manipulation.
* Unauthorized data fields are not exposed.
* Error responses do not expose stack traces.
* Test fixtures contain no real credentials.

A complete penetration test and final compliance audit remain outside the immediate testing decision.

## Postman

The committed Postman Collection is stored at:

    postman/Alamal_Medical_Center.postman_collection.json

This repository location is the adopted first-version location for the project's committed Postman Collection.

After endpoint implementation, create or update one Postman Collection containing:

* Role-specific login requests.
* Protected request examples.
* Logout.
* Password change.
* Doctor-account creation and editing.
* Secretary-account creation and editing.
* Department endpoints.
* Medical-service endpoints.
* Doctor endpoints.
* Working-hour endpoint.
* Expected error examples.

The top-level folders are organized by role:

* `Patient`
* `Doctor`
* `Secretary`
* `Super Administrator`

Each role keeps `Login`, `Logout`, and `Change Password` inside its own `Authentication` folder. Other requests remain inside their owning role and feature folders.

The collection represents all `23` implemented API routes and keeps focused error examples beside the relevant role or feature request.

Use Postman collection variables for:

```text
base_url
patient_token
doctor_token
secretary_token
super_administrator_token
```

Do not place real credentials or tokens in the committed Collection.

Start the local API before using the collection:

```bash
php artisan serve
```

The default collection value is `base_url=http://127.0.0.1:8000`. If Postman remains at `Sending request`, first confirm that the Laravel server is running and that `base_url` matches its host and port.

## Commands

Standard commands include:

```bash
php artisan test
```

```bash
php artisan test --testsuite=Feature
```

```bash
php artisan test --testsuite=Unit
```

```bash
vendor/bin/pint --test
```

Additional commands may be documented during implementation when they become relevant.

## Quality Gates

Before merging an implemented task:

* Required automated tests pass.
* Existing relevant tests continue to pass.
* Laravel Pint reports no formatting failure.
* No unresolved functional behavior has been introduced.
* No secret or real credential is committed.
* Documentation affected by the implementation is current.
* The implementation remains within the approved immediate scope.

## Performance

The system must be designed for efficient queries and growing data.

Measurements may be recorded in the available test environment.

Final performance acceptance must not be claimed until the unresolved load, environment, dataset, and acceptance method are confirmed.

## Current Status

The immediate testing strategy is adopted.

No test or application file has been created by this documentation task.

The next testing work occurs during bounded Phase 6 implementation tasks.
