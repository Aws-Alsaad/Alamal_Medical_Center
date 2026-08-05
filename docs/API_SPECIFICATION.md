# API Specification

## Purpose

This file documents the adopted REST and JSON conventions and the minimum endpoints for the immediate first working Backend version.

It defines:

* Role-based route prefixes.
* Authentication transport.
* Immediate endpoints.
* Minimum request fields.
* Minimum response fields.
* Standard success and error envelopes.
* Pagination.
* HTTP status conventions.
* Stable application error codes.
* Deferred API areas.

It must not define endpoints, fields, permissions, workflows, statuses, or policies outside the approved immediate scope.

## General Conventions

The API uses:

* HTTPS as the production transport boundary.
* JSON request bodies.
* JSON responses.
* `Content-Type: application/json`.
* `Accept: application/json`.
* `snake_case` JSON field names.
* ISO 8601 date and time representation.
* UTC for stored timestamps.
* English Backend messages during the immediate implementation.
* API Resources for output transformation.

The initial API does not use:

```text
/api/v1
```

and does not create a `v1` route directory.

## Role Prefixes

The API uses:

```text
/api/patient/...
/api/doctor/...
/api/secretary/...
/api/super-administrator/...
```

Each role has a separate route file as defined in `LARAVEL_ARCHITECTURE.md`.

## Authentication

Authentication uses Laravel Sanctum personal-access Bearer Tokens.

Protected requests send:

```http
Authorization: Bearer <TOKEN>
```

A token must never be written to logs or audit metadata.

## Standard Success Response

```json
{
  "success": true,
  "status_code": 200,
  "message": "Request completed successfully.",
  "data": {}
}
```

Rules:

* `success` is always `true`.
* `status_code` matches the HTTP response status.
* `message` is a clear English message.
* `data` contains the requested representation or `null`.

## Standard Error Response

```json
{
  "success": false,
  "status_code": 422,
  "message": "The provided data is invalid.",
  "error_code": "VALIDATION_ERROR",
  "errors": {}
}
```

Rules:

* `success` is always `false`.
* `status_code` matches the HTTP response status.
* `error_code` is stable and machine-readable.
* `errors` is included when field-level details exist.
* Stack traces and sensitive implementation details are never returned.

## Pagination

Collection query parameters:

```text
page
per_page
```

Rules:

* Default `per_page`: `15`.
* Minimum `per_page`: `1`.
* Maximum `per_page`: `100`.
* Invalid values return `422`.

Example request:

```http
GET /api/patient/doctors?page=2&per_page=15
```

Example response:

```json
{
  "success": true,
  "status_code": 200,
  "message": "Doctors retrieved successfully.",
  "data": [],
  "meta": {
    "current_page": 2,
    "per_page": 15,
    "last_page": 4,
    "total": 52
  }
}
```

Pagination applies initially to:

* Department lists.
* Medical-service lists.
* Doctor lists.

## Authentication Endpoints

### Patient Login

```http
POST /api/patient/auth/login
```

### Doctor Login

```http
POST /api/doctor/auth/login
```

### Secretary Login

```http
POST /api/secretary/auth/login
```

### Super Administrator Login

```http
POST /api/super-administrator/auth/login
```

### Login Request

```json
{
  "email": "user@example.com",
  "password": "plain-text-input"
}
```

The password exists only in request processing and must never be logged.

### Login Behavior

The login implementation verifies:

* The submitted credentials.
* The role expected by the selected route.

Valid credentials used through the wrong role route return a role-mismatch error.

### Login Success Data

```json
{
  "user": {
    "id": 1,
    "name": "Example User",
    "role": "doctor"
  },
  "token": "<TOKEN>",
  "token_type": "Bearer"
}
```

The implementation must not expose:

* Passwords.
* Password hashes.
* Stored token hashes.
* Unapproved profile fields.

### Login Error Codes

```text
INVALID_CREDENTIALS
ROLE_MISMATCH
VALIDATION_ERROR
TOO_MANY_REQUESTS
INTERNAL_SERVER_ERROR
```

Final failed-login thresholds and lockout behavior remain unresolved.

## Logout Endpoints

```http
POST /api/patient/auth/logout
POST /api/doctor/auth/logout
POST /api/secretary/auth/logout
POST /api/super-administrator/auth/logout
```

Requirements:

* Sanctum authentication is required.
* The token used for the current request is revoked.
* The response uses `200`.
* The response data may be `null`.

## Authenticated Password-Change Endpoints

```http
PATCH /api/patient/auth/password
PATCH /api/doctor/auth/password
PATCH /api/secretary/auth/password
PATCH /api/super-administrator/auth/password
```

Minimum request:

```json
{
  "current_password": "current-input",
  "password": "new-input",
  "password_confirmation": "new-input"
}
```

Requirements:

* Sanctum authentication is required.
* The current password must be verified.
* The new password must be hashed before persistence.
* The new password must not be logged.
* The operation must create the required audit record.
* This endpoint is not a forgotten-password reset endpoint.
* Final password-strength values remain unresolved.

## Super Administrator Doctor-Account Endpoints

### Create Doctor Account

```http
POST /api/super-administrator/doctors
```

Minimum request:

```json
{
  "name": "Doctor Name",
  "email": "doctor@example.com",
  "password": "plain-text-input",
  "password_confirmation": "plain-text-input"
}
```

Behavior:

* Only a Super Administrator may access the endpoint.
* The role is fixed by the endpoint as `doctor`.
* The request must not accept a client-selected role.
* The password is hashed.
* Email must be unique.
* The operation and audit record may use one transaction.
* Success returns `201`.

### Edit Doctor Account

```http
PATCH /api/super-administrator/doctors/{doctor}
```

Minimum immediate editable account fields:

```json
{
  "name": "Updated Doctor Name",
  "email": "updated-doctor@example.com"
}
```

Behavior:

* Only a Super Administrator may access the endpoint.
* The target must have the `doctor` role.
* The role cannot be changed through this endpoint.
* Professional-profile fields are not part of this endpoint.
* Account revocation and deletion are not part of this endpoint.
* Success returns `200`.

## Super Administrator Secretary-Account Endpoints

### Create Secretary Account

```http
POST /api/super-administrator/secretaries
```

Minimum request:

```json
{
  "name": "Secretary Name",
  "email": "secretary@example.com",
  "password": "plain-text-input",
  "password_confirmation": "plain-text-input"
}
```

Behavior:

* Only a Super Administrator may access the endpoint.
* The role is fixed by the endpoint as `secretary`.
* The request must not accept a client-selected role.
* The password is hashed.
* Email must be unique.
* The operation and audit record may use one transaction.
* Success returns `201`.

### Edit Secretary Account

```http
PATCH /api/super-administrator/secretaries/{secretary}
```

Minimum immediate editable account fields:

```json
{
  "name": "Updated Secretary Name",
  "email": "updated-secretary@example.com"
}
```

Behavior:

* Only a Super Administrator may access the endpoint.
* The target must have the `secretary` role.
* The role cannot be changed through this endpoint.
* Role-specific profile fields are not part of this endpoint.
* Account revocation and deletion are not part of this endpoint.
* Success returns `200`.

## Patient Directory Access Boundary

All endpoints documented under:

* Patient Department Directory.
* Patient Medical-Service Directory.
* Patient Doctor Directory.

require:

* Laravel Sanctum authentication.
* A valid Bearer Token.
* The authenticated user to have the `patient` role.
* Patient-role authorization middleware.

Requests without valid authentication return:

* HTTP status `401`.
* Error code `UNAUTHENTICATED`.

Authenticated users without the required Patient role return:

* HTTP status `403`.
* Error code `FORBIDDEN`.

This access boundary does not create equivalent directory endpoints for the other roles.

## Patient Department Directory

### List Departments

```http
GET /api/patient/departments
```

Response fields:

```text
id
name
```

The result is paginated.

### View Department

```http
GET /api/patient/departments/{department}
```

Response fields:

```text
id
name
```

No unsupported department fields are returned.

## Patient Medical-Service Directory

### List Medical Services

```http
GET /api/patient/medical-services
```

Response fields:

```text
id
name
cost
```

The result is paginated.

### View Medical Service

```http
GET /api/patient/medical-services/{medical_service}
```

Response fields:

```text
id
name
cost
```

No department relationship or unsupported service field is returned.

## Patient Doctor Directory

### List Doctors

```http
GET /api/patient/doctors
```

Response fields:

```text
id
name
```

The result contains users whose role is `doctor`.

The result is paginated.

### View Doctor

```http
GET /api/patient/doctors/{doctor}
```

Minimum response fields:

```text
id
name
```

No email, password, token, or unapproved professional-profile field is returned.

### View Doctor Working Hours

```http
GET /api/patient/doctors/{doctor}/working-hours
```

Response item fields:

```text
day_of_week
start_time
end_time
```

Weekday values use:

```text
1 = Saturday
2 = Sunday
3 = Monday
4 = Tuesday
5 = Wednesday
6 = Thursday
7 = Friday
```

This endpoint displays recurring working periods only.

It does not calculate appointment availability.

## Validation Conventions

Validation uses Form Requests.

### Login

```text
email:
- required
- valid email format

password:
- required
- string
```

### Account Creation

```text
name:
- required
- string
- maximum length 255

email:
- required
- valid email format
- maximum length 255
- unique in users

password:
- required
- string
- confirmed
```

Final password-strength values are not defined by this specification.

### Account Editing

```text
name:
- optional in PATCH
- string when present
- maximum length 255

email:
- optional in PATCH
- valid email format when present
- maximum length 255
- unique while ignoring the current account
```

At least one supported field must be supplied for an account-edit request.

### Pagination

```text
page:
- optional
- integer
- minimum 1

per_page:
- optional
- integer
- minimum 1
- maximum 100
```

## HTTP Status Codes

```text
200 = Successful request
201 = Resource created
400 = Invalid general request
401 = Unauthenticated
403 = Forbidden
404 = Resource not found
409 = Data conflict
422 = Validation failure
429 = Too many requests
500 = Unexpected server error
```

## Stable Error Codes

```text
VALIDATION_ERROR
INVALID_CREDENTIALS
ROLE_MISMATCH
UNAUTHENTICATED
FORBIDDEN
RESOURCE_NOT_FOUND
DATA_CONFLICT
TOO_MANY_REQUESTS
INTERNAL_SERVER_ERROR
```

Do not introduce future domain error codes before the related capability is approved for implementation.

## Route Model Binding

Route Model Binding may be used when it improves clarity.

It is not mandatory for every endpoint.

A resolved Model does not replace:

* Role verification.
* Authorization.
* Repository-based application queries.
* Resource-field restrictions.

## Rate Limiting

Laravel rate limiting may protect authentication and API routes.

The exact thresholds and final lockout behavior remain unresolved and must not be invented in this specification.

## Deferred API Areas

Do not add immediate endpoints for:

* Patient registration.
* Forgotten-password reset.
* Account activation or deactivation.
* Account revocation.
* Account deletion.
* General profile editing.
* Appointment management.
* Availability calculation.
* Consultation forms.
* Medical records.
* Treatment plans.
* Medications.
* Laboratory workflows.
* Radiology workflows.
* Medical files.
* Referrals.
* Payments.
* Notifications.
* Complaints.
* Offers.
* Reports.
* Analytics.
* Backup administration.
* Audit-log browsing.
* Production administration.

## Current Status

The minimum immediate REST and JSON specification is adopted.

No route, Controller, Request, Resource, Service, Repository, or application code has been created by this documentation task.

Future API expansion requires confirmed functional definitions and reviewed documentation.
