# Backend Modules

## Purpose

This file defines the functional Backend module catalog for the Al Amal Medical Center Management System.

The modules are derived exclusively from the SRS requirements documented in `BACKEND_ANALYSIS.md`.

This file organizes requirements by functional responsibility. It does not define:

* Database design.
* API endpoints.
* Laravel classes.
* Technical architecture.
* Implementation order.
* Final first-version scope.
* Answers to questions not resolved by the SRS.

## Authoritative Source

Until delivery of the first working Backend version:

* The SRS is the sole authoritative source for functional requirements.
* `BACKEND_ANALYSIS.md` is the authoritative SRS-derived Backend baseline.
* This file is a module-level organization of that baseline and is not an independent requirements source.

## Module Status Rules

Module responsibilities are classified as:

* **Confirmed from SRS:** Explicitly supported by the SRS-derived baseline.
* **Unresolved SRS Detail:** The capability is supported, but one or more functional details are not defined by the SRS.
* **External Dependency Unresolved:** The capability depends on an external provider or service that has not been selected.
* **Internal SRS Clarification Required:** The SRS contains conditional, incomplete, or potentially conflicting statements.

Detailed unanswered questions will be consolidated later in `PROJECT_UNDERSTANDING_QA.md`.

Actor lists include only roles or external parties whose participation is explicitly supported by the SRS-derived baseline. A role is not listed merely because it may potentially participate after an unresolved detail is clarified.

---

# Module 1 — Authentication and Account Management

## Purpose

Manage user authentication, Patient registration, password operations, account administration, and role-based access.

## Actors

* Patient.
* Doctor.
* Secretary.
* Super Administrator.

## Confirmed from SRS

The Backend shall support:

* Login using valid credentials.
* Rejection of invalid login attempts.
* Secure logout.
* Password reset.
* Password change for authenticated users.
* Patient registration using required personal information.
* Input validation during registration and account operations.
* Super Administrator management of user accounts.
* Super Administrator creation, editing, and revocation of Doctor and Secretary accounts.
* Role-based access control for Patient, Doctor, Secretary, and Super Administrator roles.
* Protection of system functions so that users access only permitted data and actions.
* Secure storage of passwords in hashed form.
* Password-strength requirements.
* Secure authenticated sessions or an equivalent authentication state.
* Session expiration after a defined period of inactivity.
* Re-authentication after session expiration.

## Unresolved SRS Details

The SRS does not completely define:

* The complete Patient-registration field set.
* The password-reset delivery mechanism.
* The password-strength rules.
* The authentication-token or session mechanism.
* Session and token durations.
* Token revocation behavior.
* Failed-login lockout or throttling rules.
* The exact meaning of account revocation.
* Whether additional account states are required.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* VALIDATION-SRS-001.
* PATIENT-ACCOUNT-SRS-001 and PATIENT-ACCOUNT-SRS-002.
* ACCOUNT-ADMIN-SRS-001 and ACCOUNT-ADMIN-SRS-002.
* ROLE-SRS-001 through ROLE-SRS-005.
* SECURITY-SRS-001 through SECURITY-SRS-011.

---

# Module 2 — User Profile Management

## Purpose

Manage permitted viewing and modification of personal and professional user-profile information.

## Actors

* Patient.
* Doctor.
* Secretary.
* Super Administrator.

## Confirmed from SRS

The Backend shall support:

* Authenticated users editing permitted profile information.
* Patients accessing and managing only their own personal data.
* Display of Doctor lists and Doctor profiles.
* Administrative account and profile-management responsibilities.
* Role-based restrictions on access to personal and professional information.
* Protection of sensitive profile information from unauthorized access.

## Unresolved SRS Details

The SRS does not completely define:

* The profile fields for each role.
* Which fields each role may edit.
* Which Doctor-profile fields are publicly visible.
* Which Patient-profile fields Doctors or Secretaries may view.
* Whether profile pictures are supported.
* Field-level validation rules.
* Whether profile changes require verification or approval.
* The exact boundary between account management and professional-profile management.

## Related Baseline IDs

* PROFILE-SRS-001.
* DOCTOR-DIRECTORY-SRS-001.
* ACCOUNT-ADMIN-SRS-001.
* ROLE-SRS-001 through ROLE-SRS-005.
* PRIVACY-SRS-001 and PRIVACY-SRS-002.

---

# Module 3 — Department, Medical Service, and Doctor Directory Management

## Purpose

Manage and display medical departments, medical services, service costs, Doctor information, and Doctor working-time information.

## Actors

* Patient.
* Super Administrator.

## Confirmed from SRS

The Backend shall support:

* Patient viewing of medical departments.
* Patient viewing of medical services.
* Display of general or detailed department information.
* Display of medical-service details and costs.
* Display of Doctor lists and Doctor profiles.
* Display of Doctor schedules and working hours.
* Administrative management of Doctor accounts.
* High-level administrative management of departments, services, and Doctor information.
* Future addition of departments and services without major system redesign.

## Unresolved SRS Details

The SRS does not completely define:

* Department fields.
* Medical-service fields.
* Doctor-profile fields.
* Which users may view each Doctor-profile field.
* Department-management operations.
* Medical-service-management operations.
* Department and service activation, deletion, or archival behavior.
* Relationships between departments, services, and Doctors.
* Search, filtering, and ordering behavior.
* Service-price history.
* Whether service information includes appointment duration.

## Related Baseline IDs

* DIRECTORY-SRS-001 and DIRECTORY-SRS-002.
* SERVICE-SRS-001.
* DOCTOR-DIRECTORY-SRS-001 and DOCTOR-DIRECTORY-SRS-002.
* DOCTOR-ADMIN-SRS-001.
* ADMIN-SRS-001.
* EXTENSIBILITY-SRS-001.

---

# Module 4 — Patient Consultation Form Management

## Purpose

Support submission of Patient consultation forms.

## Actors

* Patient.

## Confirmed from SRS

The Backend shall allow Patients to submit consultation forms.

## Unresolved SRS Details

The SRS does not define:

* The purpose of the consultation form.
* The required fields.
* The recipient.
* The workflow.
* The statuses.
* Whether the consultation is linked to a Doctor.
* Whether it is linked to a department or service.
* Whether it is linked to an appointment.
* Which actors may view or respond to it.

## Related Baseline IDs

* CONSULTATION-SRS-001.

---

# Module 5 — Appointment and Schedule Management

## Purpose

Manage appointment booking, modification, cancellation, working schedules, Doctor availability, daily appointment tracking, and appointment-policy enforcement.

## Actors

* Patient.
* Doctor.
* Secretary.
* Super Administrator.

## Confirmed from SRS

The Backend shall support:

* Patient appointment booking.
* Appointment booking based on Doctor availability.
* Patient appointment modification within allowed time constraints.
* Patient appointment cancellation within allowed time constraints.
* Secretary appointment management.
* Secretary creation, updating, and cancellation of appointments when necessary.
* Display of appointment schedules to users.
* Daily scheduling and appointment tracking.
* Appointment requests that may require Secretary confirmation or approval.
* Enforcement of predefined appointment-modification and cancellation policies.
* Secretary creation and management of working schedules.
* Administrative management of Doctor and department schedules.
* Super Administrator monitoring of schedules and appointments.
* Appointment reminders.

The SRS mentions at least three days before an appointment only as an example of a possible modification or cancellation policy. It is not a final confirmed value.

## Unresolved SRS Details

The SRS does not completely define:

* Whether Secretary approval is mandatory.
* Doctor-availability calculation.
* Appointment statuses.
* Appointment-status transitions.
* Appointment duration.
* The final modification period.
* The final cancellation period.
* Schedule structure.
* Schedule-management permission boundaries.
* Department-schedule meaning.
* Appointment-conflict rules.
* Rescheduling behavior.
* Missed-appointment handling.
* Waiting-list or waiting-queue behavior.
* The effects of schedule changes on existing appointments.

## Related Baseline IDs

* APPOINTMENT-SRS-001 through APPOINTMENT-SRS-011.
* SCHEDULE-SRS-001 through SCHEDULE-SRS-003.
* NOTIFICATION-SRS-001.
* POLICY-SRS-001.
* SAFETY-SRS-003 and SAFETY-SRS-004.

---

# Module 6 — Patient Medical Record Management

## Purpose

Manage creation, searching, access, viewing, permitted updating, archival, and protection of Patient medical records.

## Actors

* Patient.
* Doctor.
* Secretary.

## Confirmed from SRS

The Backend shall support:

* Patient access to their own medical records and medical history.
* Doctor access to medical records of assigned Patients.
* Doctor updating of permitted Patient medical-record information.
* Secretary creation of Patient medical records.
* Secretary management of permitted Patient-record information.
* Prevention of Secretaries modifying diagnoses or treatment plans.
* Creation and maintenance of medical records only by authorized personnel.
* Prevention of permanent medical-record deletion after creation.
* Medical-record updating or archiving.
* Secretary searching for medical records using Patient information.
* Verification of whether a matching medical record already exists.
* Display of medical-record details when a match is found.
* An appropriate response when no matching record exists.
* Creation of a new medical record when required.
* Validation of Patient information during medical-record creation.
* Saving of newly created medical records.
* Confirmation after successful medical-record creation.
* Protection of medical information against unauthorized access, modification, corruption, and misuse.

## Unresolved SRS Details

The SRS does not completely define:

* Medical-record fields and structure.
* What makes a Patient assigned to a Doctor.
* When Doctor access begins and ends.
* Which medical-record sections a Doctor may update.
* Which administrative sections a Secretary may view or modify.
* Search fields and matching rules.
* Duplicate-record behavior.
* Archive-selection rules.
* Archive retrieval behavior.
* The exact trigger for record creation.
* Super Administrator medical-record access.
* Detailed access-logging requirements.

## Related Baseline IDs

* MEDICAL-RECORD-SRS-001 through MEDICAL-RECORD-SRS-017.
* ROLE-SRS-001 through ROLE-SRS-005.
* PRIVACY-SRS-001 through PRIVACY-SRS-003.
* SAFETY-SRS-001, SAFETY-SRS-002, SAFETY-SRS-005, and SAFETY-SRS-006.
* ARCHIVE-SRS-001.

---

# Module 7 — Treatment Plan, Medical Instruction, and Referral Management

## Purpose

Manage treatment plans, medications, medical and diet instructions, laboratory and radiology requests, medical updates, and referrals.

## Actors

* Patient.
* Doctor.

## Confirmed from SRS

The Backend shall support:

* Patient viewing of treatment plans.
* Doctor creation of treatment plans.
* Doctor updating of treatment plans.
* Doctor responsibility for creating and updating treatment plans.
* Treatment information including medications.
* Diet instructions.
* Laboratory tests or requests.
* Radiology requests.
* Other medical instructions.
* Sharing medical updates with Patients.
* Referrals to other departments.

Secretaries must not modify treatment plans or diagnoses.

## Unresolved SRS Details

The SRS does not completely define:

* Treatment-plan fields.
* Treatment-plan statuses.
* Treatment-plan relationships with appointments or medical visits.
* Medication fields.
* Medication workflow.
* Diet-instruction structure.
* General medical-instruction structure.
* Laboratory-request structure and statuses.
* Radiology-request structure and statuses.
* Referral workflow.
* Referral recipients.
* Referral statuses.
* How medical updates are shared with Patients.
* Modification and historical-preservation rules.

## Related Baseline IDs

* TREATMENT-SRS-001 through TREATMENT-SRS-006.
* REFERRAL-SRS-001.
* MEDICAL-RECORD-SRS-004 and MEDICAL-RECORD-SRS-006.
* ROLE-SRS-002 and ROLE-SRS-003.

---

# Module 8 — Laboratory and Radiology Result Management

## Purpose

Manage uploading, storing, protecting, and viewing laboratory results, radiology images, and radiology reports.

## Actors

* Patient.
* Doctor.
* Secretary.

## Confirmed from SRS

The Backend shall support:

* Patient viewing of laboratory or test results.
* Uploading of test results.
* Patient viewing of radiology images.
* Uploading of radiology images.
* Access to radiology images and reports.
* Secretary uploading of test results and radiology images.
* Secure handling of results and medical images.
* Protection from unauthorized access, modification, corruption, misuse, and misinterpretation.

## Unresolved SRS Details

The SRS does not completely define:

* Whether a result must be linked to a previous request.
* Laboratory-result fields.
* Radiology-result fields.
* Supported file formats.
* File-size limits.
* Whether multiple files are supported.
* Report and image relationships.
* Upload correction or replacement behavior.
* Result-review workflow.
* Result-access permissions.
* External medical-file storage.
* Notification events after upload.

## Related Baseline IDs

* LAB-SRS-001 and LAB-SRS-002.
* RADIOLOGY-SRS-001 through RADIOLOGY-SRS-003.
* RESULT-UPLOAD-SRS-001.
* PRIVACY-SRS-001.
* SAFETY-SRS-005 and SAFETY-SRS-006.
* EXTERNAL-SRS-003.

---

# Module 9 — Payment Management

## Purpose

Manage online medical-service payments, transaction results, failed-payment notifications, and payment-history access.

## Actors

* Patient.
* External payment service.

## Confirmed from SRS

The Backend shall support:

* Online payment for medical services.
* Confirmation of successful payment transactions.
* Notification when a payment fails.
* Patient access to payment history.
* A payment-timing policy that may require payment before or after appointment confirmation.
* Verification of payment transactions before service completion is confirmed.
* Secure integration with an external payment service.

## Unresolved SRS Details

The SRS does not completely define:

* The payment-gateway provider.
* The payment-integration method.
* Supported payment methods.
* The final payment-timing policy.
* Payment statuses.
* Failed-payment handling beyond notification.
* Refund behavior.
* Payment-history fields.
* Invoice behavior.
* Manual or physical payment behavior.
* The relationship between payment, appointment confirmation, and service completion.

## External Dependency Status

Payment-gateway details remain unresolved under SRS TBD-1.

Implementation of the external transaction integration cannot be finalized until the provider and integration details are selected.

## Related Baseline IDs

* PAYMENT-SRS-001 through PAYMENT-SRS-006.
* EXTERNAL-SRS-001.
* SECURITY-SRS-013.
* TBD-1.

---

# Module 10 — Notification and Communication Management

## Purpose

Manage appointment reminders, system notifications, alerts, promotional communication, and external notification-service integration.

## Actors

* Patient.
* System users receiving applicable notifications or alerts.
* External email or SMS service.

## Confirmed from SRS

The Backend shall support:

* Appointment reminders for Patients.
* System notifications and alerts.
* Display of notifications to users.
* Notifications related to promotional offers and announcements.
* Integration with email or SMS services for reminders and alerts.
* Protection of sensitive information during external-service integration.

## Unresolved SRS Details

The SRS does not completely define:

* The notification-service provider.
* Whether email, SMS, or both are required.
* Mandatory notification events.
* Notification recipients.
* Reminder timing.
* Delivery channels for each event.
* Notification preferences.
* Notification history.
* Promotional-notification targeting.
* Administrative notification-management permissions.
* Notification templates.

## External Dependency Status

The notification-service provider remains unresolved under SRS TBD-2.

External email or SMS delivery cannot be finalized until the required provider and channels are selected.

## Related Baseline IDs

* NOTIFICATION-SRS-001 through NOTIFICATION-SRS-005.
* EXTERNAL-SRS-002.
* SECURITY-SRS-013.
* TBD-2.

---

# Module 11 — Complaint Management

## Purpose

Manage Patient complaint submission and administrative complaint review and handling.

## Actors

* Patient.
* Authorized administrative users.

## Confirmed from SRS

The Backend shall support:

* Patient complaint submission.
* Administrative viewing of complaints.
* Administrative review and management of complaints.
* Appropriate administrative action based on complaint evaluation.

## Unresolved SRS Details

The SRS does not completely define:

* Complaint fields.
* Complaint statuses.
* Complaint recipients.
* Complaint assignment.
* Administrative actions.
* Replies and Patient follow-up.
* Complaint attachments.
* Complaint closure.
* Complaint deletion or archival behavior.
* Notifications related to complaints.

## Related Baseline IDs

* COMPLAINT-SRS-001 through COMPLAINT-SRS-004.

---

# Module 12 — Offer and Promotion Management

## Purpose

Manage offers and promotions and make them available for Patient viewing.

## Actors

* Patient.
* Authorized administrative users.

## Confirmed from SRS

The Backend shall support:

* Administrative creation and management of offers.
* Administrative management of promotions.
* Patient viewing of offers and promotions.
* Notifications or announcements related to promotional information.

## Unresolved SRS Details

The SRS does not completely define:

* Offer fields.
* Eligibility rules.
* Start and end dates.
* Discount behavior.
* Offer relationships with departments, services, Doctors, or Patients.
* Publication behavior.
* Notification targeting.
* Offer activation, suspension, deletion, or archival behavior.
* Whether offers affect payments automatically.

## Related Baseline IDs

* OFFER-SRS-001 through OFFER-SRS-003.
* NOTIFICATION-SRS-004.

---

# Module 13 — Administration, Policies, Reports, and Analytics

## Purpose

Provide high-level administrative management, system-policy configuration, reporting, statistics, analytics, and system-configuration capabilities.

## Actors

* Super Administrator.

## Confirmed from SRS

The Backend shall support:

* High-level administrative management.
* System configuration.
* Administrative management of system policies.
* Definition of appointment-cancellation policies.
* System reports.
* Analytics and statistics.
* Account management.
* Monitoring of schedules and appointments.
* Administrative management of offers and complaints.

The SRS states that Super Administrators have full access to system functionality, including account management and system configuration.

## Internal SRS Clarification Required

The meaning of full Super Administrator access requires later reconciliation with other SRS requirements that restrict modification of clinical medical information to authorized medical personnel.

No clinical permission may be invented from the phrase full access before this clarification is resolved.

## Unresolved SRS Details

The SRS does not completely define:

* The configurable appointment policies.
* Report types.
* Report filters.
* Report formats.
* Analytics and dashboard metrics.
* Access restrictions for sensitive report information.
* The exact scope of Super Administrator access.
* Detailed system-configuration options.
* Administrative operation boundaries shared with Secretaries.
* Reporting and analytics requirements under SRS TBD-7.

## Related Baseline IDs

* POLICY-SRS-001 and POLICY-SRS-002.
* REPORT-SRS-001.
* ANALYTICS-SRS-001.
* ADMIN-SRS-001 and ADMIN-SRS-002.
* ROLE-SRS-004 and ROLE-SRS-005.
* TBD-7.

---

# Cross-Cutting Backend Concerns

The following requirements affect multiple modules and are not treated as isolated functional modules.

## Technology and Communication

The Backend must use:

* Laravel and PHP.
* MySQL.
* RESTful APIs.
* JSON.
* HTTP/HTTPS, with data exchanges secured through HTTPS.
* An online server environment using Apache as stated by the SRS.

Framework versions, server specifications, and detailed deployment configuration remain unresolved.

## Security and Privacy

All modules must apply:

* Authentication for protected functionality.
* Role-based authorization.
* Hashed password storage.
* Secure password reset.
* Session or equivalent authentication-state protection.
* HTTPS protection.
* Protection against SQL Injection, Cross-Site Scripting, and Cross-Site Request Forgery.
* Protection of medical, personal, and payment information.
* Restrictions on unauthorized modification or deletion of critical data.

## Validation, Integrity, and Reliability

All relevant modules must support:

* Input validation.
* Data accuracy and consistency.
* Database integrity.
* Concurrent access without data conflicts.
* Clear error information.
* Robust handling of invalid input and unexpected actions.
* Recovery with minimal data loss.

Detailed validation rules, transaction boundaries, error structures, and recovery procedures are not defined by the SRS.

## Logging and Monitoring

The SRS requires:

* Logging of critical actions.
* Logging of login attempts.
* Logging of data updates.
* Logging of administrative changes.
* Monitoring information for operational and performance problems.

Detailed logged actions, fields, retention, permissions, and monitoring metrics remain unresolved.

## Performance and Availability

The Backend must consider:

* Response-time requirements.
* Efficient processing of multiple requests.
* Efficient database operations.
* Support for multiple concurrent users.
* Reporting and analytics performance.
* Bandwidth and latency optimization.
* Continuous availability except during scheduled maintenance.
* Scalability for increasing users, data, and transactions.

The final measurable performance and availability targets are not completely defined.

## Backup, Recovery, Retention, and Archiving

The SRS requires:

* Backup and recovery mechanisms.
* Minimal data loss after failure.
* Defined data-retention periods.
* Access to archived information by authorized users.

The detailed strategy remains unresolved under TBD-4 and TBD-6.

## Localization

The SRS requires support for multiple languages, including Arabic and English where applicable.

Date, time, and number formats must follow the selected locale.

The first-version language scope, locale behavior, and time-zone rules are not completely defined.

---

# SRS External and Organizational Dependencies

The following items affect Backend implementation but are not yet fully defined:

* TBD-1 — Payment Gateway Details.
* TBD-2 — Notification Service Provider.
* TBD-3 — Hosting Environment Specifications.
* TBD-4 — Data Retention Policy.
* TBD-5 — Security Standards Compliance.
* TBD-6 — Backup and Recovery Strategy.
* TBD-7 — Reporting and Analytics Details.
* Optional external storage for medical images and reports.

No provider, policy, or missing value is selected in this file.

# Current Status

This module catalog has been rebuilt using only the SRS-derived baseline in `BACKEND_ANALYSIS.md`.

Detailed unanswered questions will be consolidated later in `PROJECT_UNDERSTANDING_QA.md`.

The next documentation-audit step is to populate `USER_ROLES.md` using only role information supported by the SRS.
