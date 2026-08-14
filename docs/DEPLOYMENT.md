# Deployment

## Purpose

This file records the adopted local-development setup and the confirmed boundaries for later deployment.

The production hosting environment remains unresolved.

This file must not invent a hosting provider, server specification, backup strategy, retention policy, compliance implementation, monitoring provider, domain, certificate configuration, or external-service provider.

## Adopted Technology Baseline

```text
Laravel 13.x
PHP 8.4.x
MariaDB 10.4.32
Composer 2.x
```

## Local Development Environment

The immediate local environment uses:

* Windows.
* Local PHP.
* Composer.
* MariaDB `10.4.32` provided through XAMPP.
* Laravel's local server through `php artisan serve`.

Docker is not required for the first working version.

No Dockerfile, Docker Compose file, container orchestration, or container-specific deployment configuration is required by Phase 5.

## Local Application Start

The adopted local server command is:

```bash
php artisan serve
```

The exact local port may use Laravel's default or an explicitly selected local value during implementation.

The local server is a development tool and is not the production server decision.

## Database

Local development uses MariaDB `10.4.32` provided through XAMPP.

Laravel continues to use `DB_CONNECTION=mysql` because Laravel's MySQL connection and driver are used to connect to MariaDB. The configuration value identifies the Laravel driver and does not mean that the database server is MySQL.

Database credentials are provided through local environment configuration.

Real database credentials must not be committed.

The production database host, topology, backup configuration, replication, availability configuration, and scaling strategy remain unresolved.

## Environment Configuration

Sensitive and environment-specific values belong in `.env`.

`.env` must never be committed.

`.env.example` may contain safe placeholder keys.

Initial Super Administrator keys are:

```text
SUPER_ADMIN_NAME
SUPER_ADMIN_EMAIL
SUPER_ADMIN_PASSWORD
```

The example file must not include a real password.

Other standard Laravel keys may be documented during implementation without including secrets.

## Public GitHub Repository

The repository is Public.

Therefore:

* All committed content is visible to everyone.
* `.env` must remain ignored.
* Real credentials must not appear in source code.
* Access tokens must not appear in source code.
* Private keys must not appear in source code.
* Runtime logs must not be committed.
* Secret production configuration must remain outside Git.

Complete Git instructions are stored in:

```text
docs/GIT_GITHUB_GUIDE.md
```

## Future Web-Server Compatibility

The application must remain compatible with later Apache-based deployment.

This does not adopt:

* A final Apache virtual-host file.
* A final document-root path.
* A final operating system.
* A final PHP process model.
* A final reverse-proxy configuration.
* A final server-control-panel configuration.

These details depend on the hosting environment.

## HTTPS Boundary

Production communication must use HTTPS.

The following remain unresolved:

* Certificate provider.
* Certificate installation.
* TLS termination point.
* Reverse proxy.
* Load balancer.
* Domain.
* DNS.
* Renewal process.

Local development may use HTTP through `php artisan serve`.

Local HTTP does not remove the production HTTPS requirement.

## File Storage

The immediate implementation does not include medical-file upload or storage.

Do not select:

* Local production medical-file storage.
* Cloud object storage.
* An external medical-image provider.
* A CDN.
* A retention location.
* A medical-file backup process.

These decisions remain deferred until the related requirements and infrastructure are clarified.

## External Providers

Do not select an immediate provider for:

* Payments.
* Notifications.
* Email delivery beyond an approved implemented need.
* SMS.
* Medical-file storage.
* Monitoring.
* Reporting.
* Analytics.
* Backup.

Provider-specific environment variables and integration instructions must not be added prematurely.

## Backup and Recovery

The SRS requires backup and recovery capability, but the detailed strategy remains unresolved.

Do not define:

* Backup schedule.
* Retention duration.
* Backup destination.
* Encryption procedure.
* Recovery-point objective.
* Recovery-time objective.
* Restore workflow.

These decisions require later organizational and infrastructure confirmation.

## Retention and Archiving

Data-retention periods and archival behavior remain unresolved.

Do not implement automatic deletion, archival, or retention jobs based on invented values.

## Monitoring and Logs

Laravel's technical log may be used during development for framework and application diagnostics.

The default local technical-log location is:

```text
storage/logs/laravel.log
```

Runtime log files must not be committed.

Technical logging is distinct from the database `audit_logs` table.

The final monitoring provider, alert thresholds, dashboards, log shipping, and production retention remain unresolved.

## Production Deployment Status

Not yet adopted:

* Hosting provider.
* Production server.
* Production operating system.
* Production database.
* Domain.
* DNS.
* HTTPS implementation.
* Apache configuration.
* Queue infrastructure.
* Cache infrastructure.
* Scheduler configuration.
* Process supervision.
* Monitoring.
* Backup.
* Recovery.
* Retention.
* Compliance implementation.
* Payment provider.
* Notification provider.
* External medical-file storage.

## Deployment Security Rules

* Never commit `.env`.
* Never commit real credentials.
* Never commit access tokens.
* Never commit private keys.
* Never commit runtime logs.
* Never return stack traces to clients.
* Use environment configuration for secrets.
* Hash passwords before persistence.
* Use HTTPS in production.
* Review production permissions after the hosting environment is known.

## Deferred Deployment Work

Production deployment documentation must be completed after resolving:

* Hosting specifications.
* Security and compliance requirements.
* Backup and recovery strategy.
* Retention policy.
* Monitoring approach.
* Domain and HTTPS configuration.
* External-service providers.
* Optional external medical-file storage.

## Current Status

The local development baseline and production-deployment boundaries are adopted.

No production deployment has been performed.

No hosting provider or production infrastructure has been selected.

No configuration or source-code file has been created by this documentation task.
