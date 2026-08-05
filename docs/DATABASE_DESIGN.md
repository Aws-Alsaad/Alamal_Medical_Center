# Database Design

## Purpose

This file documents the adopted minimum database design for the immediate first working Backend version of the Al Amal Medical Center Management System.

It defines:

* The adopted database engine.
* Tables required by the immediate implementation scope.
* Minimum fields.
* Keys, indexes, and constraints.
* Confirmed relationships.
* Eloquent-model placement.
* Transaction responsibilities.
* Deferred future schema areas.

This file defines a technical persistence design only.

It must not introduce new functional requirements, profile fields, permissions, workflows, statuses, scheduling policies, deletion behavior, retention policies, or future-domain details.

## Authoritative Boundaries

The immediate schema must remain within:

* The SRS-derived baseline in `BACKEND_ANALYSIS.md`.
* The approved immediate scope in `DEVELOPMENT_PLAN.md`.
* The architecture recorded in `LARAVEL_ARCHITECTURE.md`.
* The adopted decisions in `BACKEND_DESIGN_DECISIONS.md`.

Fields or tables not required by the immediate scope must not be added by assumption.

## Database Baseline

The initial implementation uses:

* MySQL `8.4 LTS`.
* Laravel Migrations.
* Eloquent Models.
* Repository Interfaces.
* Eloquent Repository implementations.

Application timestamps are stored using UTC.

Database table and column names use `snake_case`.

Primary keys use unsigned big integers.

## Immediate Tables

The immediate implementation creates:

1. `users`
2. `departments`
3. `medical_services`
4. `doctor_working_hours`
5. `audit_logs`
6. `personal_access_tokens`

No additional domain table is part of the immediate migration scope.

## Table: `users`

### Purpose

Store the minimum shared account representation required for authentication, authorization, staff-account administration, and minimum Doctor-directory display.

### Fields

| Field | Type | Nullable | Default | Key or Constraint |
|---|---|---:|---|---|
| `id` | Unsigned big integer | No | Auto increment | Primary key |
| `name` | `VARCHAR(255)` | No | None | None |
| `email` | `VARCHAR(255)` | No | None | Unique |
| `password` | `VARCHAR(255)` | No | None | Hashed value only |
| `role` | `VARCHAR(32)` | No | None | Indexed |
| `created_at` | Timestamp | Yes | Laravel-managed | None |
| `updated_at` | Timestamp | Yes | Laravel-managed | None |

### Role Representation

The database column uses `VARCHAR(32)`.

Application code uses a PHP string-backed Enum.

Allowed application values are:

```text
patient
doctor
secretary
super_administrator
```

The application must reject unsupported role values.

### Immediate Restrictions

The table does not initially add:

```text
is_active
status
revoked_at
deleted_at
email_verified_at
```

The immediate implementation does not define:

* Account activation.
* Account deactivation.
* Account revocation effects.
* Account deletion.
* Soft deletion.
* Email verification.
* Role-specific professional-profile fields.

### Model Placement

```text
app/Shared/Identity/Models/User.php
```

## Table: `departments`

### Purpose

Store the minimum department representation required for Patient read-only listing and viewing.

### Fields

| Field | Type | Nullable | Default | Key or Constraint |
|---|---|---:|---|---|
| `id` | Unsigned big integer | No | Auto increment | Primary key |
| `name` | `VARCHAR(255)` | No | None | None |
| `created_at` | Timestamp | Yes | Laravel-managed | None |
| `updated_at` | Timestamp | Yes | Laravel-managed | None |

### Immediate Restrictions

The table does not initially add:

```text
description
image
is_active
display_order
deleted_at
```

The complete department-detail field set remains unresolved.

### Model Placement

```text
app/Shared/Directory/Models/Department.php
```

## Table: `medical_services`

### Purpose

Store the minimum medical-service representation required for Patient read-only listing, viewing, and cost display.

### Fields

| Field | Type | Nullable | Default | Key or Constraint |
|---|---|---:|---|---|
| `id` | Unsigned big integer | No | Auto increment | Primary key |
| `name` | `VARCHAR(255)` | No | None | None |
| `cost` | `DECIMAL(10,2)` | No | None | Must not be negative |
| `created_at` | Timestamp | Yes | Laravel-managed | None |
| `updated_at` | Timestamp | Yes | Laravel-managed | None |

### Immediate Restrictions

The table does not initially add:

```text
department_id
description
is_active
display_order
deleted_at
```

No department-to-service relationship is introduced until supported by the authoritative functional source or formally confirmed later.

The table does not define:

* Price history.
* Activation or deactivation.
* Deletion or archival.
* Search or display ordering.

### Model Placement

```text
app/Shared/Directory/Models/MedicalService.php
```

## Table: `doctor_working_hours`

### Purpose

Store recurring weekly working periods required for read-only viewing of Doctor working hours.

This table does not calculate appointment availability.

### Fields

| Field | Type | Nullable | Default | Key or Constraint |
|---|---|---:|---|---|
| `id` | Unsigned big integer | No | Auto increment | Primary key |
| `doctor_user_id` | Unsigned big integer | No | None | Foreign key to `users.id` |
| `day_of_week` | Unsigned tiny integer | No | None | Value from `1` through `7` |
| `start_time` | Time | No | None | None |
| `end_time` | Time | No | None | Must be later than `start_time` |
| `created_at` | Timestamp | Yes | Laravel-managed | None |
| `updated_at` | Timestamp | Yes | Laravel-managed | None |

### Indexes

Use a composite index on:

```text
doctor_user_id
day_of_week
```

### Weekday Mapping

```text
1 = Saturday
2 = Sunday
3 = Monday
4 = Tuesday
5 = Wednesday
6 = Thursday
7 = Friday
```

### Integrity Rules

* `doctor_user_id` must reference an existing user.
* Application logic must verify that the referenced user has the `doctor` role.
* `day_of_week` must be between `1` and `7`.
* `end_time` must be later than `start_time`.

### Deferred Scheduling Behavior

This table does not define:

* Appointment durations.
* Appointment slots.
* Appointment conflicts.
* Leave.
* Holidays.
* Temporary availability.
* Replacement Doctors.
* Schedule editing.
* Schedule approval.
* Overlapping-period policies.

### Model Placement

```text
app/Shared/Directory/Models/DoctorWorkingHour.php
```

## Table: `audit_logs`

### Purpose

Store confirmed security, accountability, and administrative action records.

### Fields

| Field | Type | Nullable | Default | Key or Constraint |
|---|---|---:|---|---|
| `id` | Unsigned big integer | No | Auto increment | Primary key |
| `actor_user_id` | Unsigned big integer | Yes | `NULL` | Foreign key to `users.id` |
| `action` | `VARCHAR(100)` | No | None | Indexed |
| `subject_type` | `VARCHAR(100)` | Yes | `NULL` | None |
| `subject_id` | Unsigned big integer | Yes | `NULL` | None |
| `outcome` | `VARCHAR(32)` | No | None | Indexed |
| `metadata` | JSON | Yes | `NULL` | Must not contain secrets |
| `ip_address` | `VARCHAR(45)` | Yes | `NULL` | None |
| `created_at` | Timestamp | No | Laravel-managed | Indexed where useful |

The table does not require `updated_at`.

### Initial Action Categories

The immediate implementation records, where applicable:

* Successful login.
* Failed login.
* Role-route mismatch.
* Logout.
* Authenticated password change.
* Doctor-account creation.
* Doctor-account editing.
* Secretary-account creation.
* Secretary-account editing.
* Implemented administrative data changes.

The complete future action list remains unresolved.

### Security Rules

Audit metadata must never include:

* Passwords.
* Password hashes.
* Plain-text credentials.
* Access tokens.
* API keys.
* Secret environment values.
* Complete sensitive payloads.

### Audit Architecture

Task Services use:

```text
AuditLogRepositoryInterface
```

directly.

No additional Audit Service is introduced initially.

### Model Placement

```text
app/Shared/Audit/Models/AuditLog.php
```

## Table: `personal_access_tokens`

### Purpose

Store Laravel Sanctum personal-access tokens.

### Design

Use the standard Laravel Sanctum migration and model behavior.

The application must never return stored token hashes.

Token creation occurs through the approved authentication implementation.

Logout revokes the token used for the current authenticated request.

## Confirmed Relationships

```text
User
  └── hasMany DoctorWorkingHours

DoctorWorkingHour
  └── belongsTo User through doctor_user_id

User
  └── hasMany AuditLogs as actor

AuditLog
  └── belongsTo User as actor
```

No other domain relationship is approved for the immediate schema.

## Transactions

The Service responsible for a complete task defines the database-transaction boundary.

Examples include:

* Creating an account and its required audit record.
* Updating an account and its required audit record.
* Changing a password and recording the required audit event.

Repositories perform persistence operations inside the transaction coordinated by the Service.

Controllers must not manage transactions.

## Migrations

Migration rules:

* Create only the immediate tables listed in this document.
* Use foreign keys only for confirmed relationships.
* Add the documented unique constraints and indexes.
* Add safe database constraints where supported.
* Preserve the same rules in application validation.
* Do not create empty future tables.
* Do not create speculative columns.

## Seeders and Factories

The immediate setup includes:

* An environment-driven initial Super Administrator Seeder.
* Factories for immediate Models where tests require them.
* Test Seeders only when they improve repeatable test setup.

Initial Super Administrator environment variables are:

```text
SUPER_ADMIN_NAME
SUPER_ADMIN_EMAIL
SUPER_ADMIN_PASSWORD
```

Real credentials must never be committed.

## Future Schema Registry

The following names represent future functional areas only.

They are not approved immediate migrations, and this list does not define their fields or final table boundaries:

```text
patient_profiles
doctor_profiles
secretary_profiles
appointments
medical_records
treatment_plans
medications
laboratory_requests
laboratory_results
radiology_requests
radiology_files
referrals
notifications
payments
complaints
offers
```

Future implementation may rename, divide, combine, or omit these candidate tables after the related requirements are clarified.

## Deferred Database Decisions

Deferred decisions include:

* Full account and profile fields.
* Account revocation and deletion behavior.
* Email verification.
* Patient registration fields.
* Department details.
* Medical-service details.
* Department-to-service relationships.
* Doctor professional-profile fields.
* Complete schedule and availability modeling.
* Appointment modeling.
* Medical-record modeling.
* Clinical workflow modeling.
* Medical-file storage.
* Payment persistence.
* Notification persistence.
* Complaint persistence.
* Offer persistence.
* Retention and archival.
* Backup and recovery.
* Reporting and analytics.

## Current Status

This minimum database design is adopted for the immediate first working Backend version.

No Migration or application code has been created by this documentation task.

Implementation must not expand the schema without a newly reviewed and documented decision.
