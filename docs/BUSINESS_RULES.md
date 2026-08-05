# Business Rules

## Purpose

This file records the Backend-relevant Business Rules explicitly supported by the SRS-derived baseline.

Business Rules define restrictions, permissions, conditions, and policies that the Backend must enforce independently of database design, API design, Laravel implementation, or user-interface behavior.

This file does not define:

* Database tables or relationships.
* API endpoints.
* Laravel classes or packages.
* Technical architecture.
* Final workflow statuses.
* Missing policy values.
* Answers to questions not resolved by the SRS.

## Authoritative Source

Until delivery of the first working Backend version:

* The SRS is the sole authoritative source for functional Business Rules.
* `BACKEND_ANALYSIS.md` is the authoritative SRS-derived Backend baseline.
* This file organizes rules from that baseline and is not an independent requirements source.

## Rule Classification

Rules and rule gaps in this file use the following classifications:

* **Confirmed from SRS:** The rule is explicitly supported by the SRS-derived baseline.
* **Unresolved SRS Detail:** The SRS confirms the rule or policy area but does not define a required value or complete behavior.
* **External Dependency Unresolved:** Enforcement depends on an external provider or integration detail that has not been selected.
* **External Detail Unresolved:** Enforcement depends on an external policy, organizational decision, infrastructure detail, or strategy that has not been defined.
* **Internal SRS Clarification Required:** The SRS contains conditional or potentially conflicting statements that require later reconciliation.

No missing rule may be completed through assumption.

---

# 1. Authentication and Account Rules

## Confirmed from SRS

### BR-AUTH-001 — Protected Access

Protected system functions require authentication using valid credentials.

### BR-AUTH-002 — Invalid Credentials

Invalid login attempts must be rejected with an appropriate error response.

### BR-AUTH-003 — Role-Based Authorization

The Backend must enforce role-based access control for:

* Patient.
* Doctor.
* Secretary.
* Super Administrator.

Users may access only the data and functions permitted to their roles.

### BR-AUTH-004 — Doctor and Secretary Account Administration

Only the Super Administrator may create, edit, or revoke Doctor and Secretary accounts.

### BR-AUTH-005 — Password Protection

User passwords must be stored in hashed form.

### BR-AUTH-006 — Password Strength

The system must enforce password-strength requirements.

### BR-AUTH-007 — Session Expiration

Authenticated sessions or equivalent authentication states must expire after a defined period of inactivity.

### BR-AUTH-008 — Re-authentication

A user must re-authenticate after the authentication session expires.

## Unresolved SRS Details

The SRS does not define:

* Password-strength values.
* Session-inactivity duration.
* The final token or session mechanism.
* Token expiration and revocation behavior.
* Failed-login lockout or throttling rules.
* The exact meaning and effects of account revocation.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* ACCOUNT-ADMIN-SRS-001 and ACCOUNT-ADMIN-SRS-002.
* ROLE-SRS-001 through ROLE-SRS-005.
* SECURITY-SRS-001 through SECURITY-SRS-011.

---

# 2. General Role and Data-Access Rules

## Confirmed from SRS

### BR-ACCESS-001 — Permitted Data and Functions

Each user may access only the data and functions authorized for that user's role.

### BR-ACCESS-002 — Sensitive Data

Sensitive information must be accessible only to authorized users.

Sensitive information includes:

* Medical records.
* Personal information.
* Payment information.

### BR-ACCESS-003 — Patient Ownership Boundary

Patients may access and manage only their own:

* Personal data.
* Appointments.
* Medical records.

### BR-ACCESS-004 — Doctor Medical-Record Boundary

Doctors may access only medical records belonging to assigned Patients.

### BR-ACCESS-005 — Authorized Medical Modification

Only authorized personnel may modify medical data.

### BR-ACCESS-006 — Secretary Clinical Restriction

Secretaries must not modify:

* Medical diagnoses.
* Treatment plans.

### BR-ACCESS-007 — Unauthorized Modification and Deletion

The Backend must prevent unauthorized modification or deletion of critical information.

## Unresolved SRS Details

The SRS does not completely define:

* The complete field-level permission matrix.
* What makes a Patient assigned to a Doctor.
* When Doctor access begins or ends.
* Which medical-record sections each authorized role may view or modify.
* The exact scope of Super Administrator access to medical information.

## Internal SRS Clarification Required

The SRS states that the Super Administrator has full system access while other rules restrict medical-data modification to authorized medical personnel.

Full access must not be interpreted as unrestricted clinical permission until this point is clarified.

## Related Baseline IDs

* ROLE-SRS-001 through ROLE-SRS-005.
* MEDICAL-RECORD-SRS-003, MEDICAL-RECORD-SRS-004, and MEDICAL-RECORD-SRS-006.
* PRIVACY-SRS-001 through PRIVACY-SRS-003.
* SAFETY-SRS-001 and SAFETY-SRS-002.
* ADMIN-SRS-002.

---

# 3. Appointment and Schedule Rules

## Confirmed from SRS

### BR-APPOINTMENT-001 — Doctor Availability

Appointment booking must be based on Doctor availability.

### BR-APPOINTMENT-002 — Patient Modification Restriction

Patients may modify appointments only within the allowed time policy.

### BR-APPOINTMENT-003 — Patient Cancellation Restriction

Patients may cancel appointments only within the allowed time policy.

### BR-APPOINTMENT-004 — Secretary Appointment Authority

Secretaries may create, update, or cancel appointments when necessary.

### BR-APPOINTMENT-005 — Policy Enforcement

Appointment modification and cancellation restrictions must be enforced according to predefined policies.

### BR-APPOINTMENT-006 — Critical-Action Confirmation

Critical appointment actions, including appointment cancellation, must require user confirmation.

### BR-APPOINTMENT-007 — Schedule Responsibilities

The SRS assigns working-schedule creation and management responsibilities to Secretaries and assigns administrative Doctor and department schedule management and monitoring responsibilities to administrative functions and the Super Administrator.

## Unresolved SRS Details

The SRS does not completely define:

* The final appointment-modification period.
* The final appointment-cancellation period.
* Doctor-availability calculation.
* Appointment duration.
* Appointment-conflict rules.
* Appointment statuses.
* Status transitions.
* Rescheduling behavior.
* Missed-appointment handling.
* Schedule structure.
* Department-schedule behavior.
* The final schedule-management boundaries between Secretaries and the Super Administrator.
* The effects of schedule changes on existing appointments.

## Internal SRS Clarification Required

### Secretary Approval

The SRS states that appointment requests may require Secretary confirmation or approval.

It does not establish whether approval is mandatory for every Patient-booked appointment.

### Three-Day Example

The SRS mentions at least three days before the appointment only as an example of a possible modification or cancellation policy.

Three days must not be treated as a final confirmed value.

## Related Baseline IDs

* APPOINTMENT-SRS-001 through APPOINTMENT-SRS-011.
* SCHEDULE-SRS-001 through SCHEDULE-SRS-003.
* POLICY-SRS-001.
* SAFETY-SRS-003 and SAFETY-SRS-004.

---

# 4. Medical-Record Rules

## Confirmed from SRS

### BR-MEDICAL-RECORD-001 — Authorized Creation and Maintenance

Medical records may be created and maintained only by authorized personnel.

### BR-MEDICAL-RECORD-002 — No Permanent Deletion

A medical record must not be permanently deleted after it has been created.

A medical record may be:

* Updated.
* Archived.

### BR-MEDICAL-RECORD-003 — Duplicate Verification

The system must verify whether a matching medical record already exists before a new record is created when the medical-record creation workflow is used.

### BR-MEDICAL-RECORD-004 — Matching Record

When a matching medical record is found, the system must display the permitted record details.

### BR-MEDICAL-RECORD-005 — No Matching Record

When no matching medical record exists, the system must provide an appropriate response and allow creation of a new record when required.

### BR-MEDICAL-RECORD-006 — Creation Validation

Patient information entered during medical-record creation must be validated.

### BR-MEDICAL-RECORD-007 — Medical-Data Integrity

Patient medical data must be accurately stored and protected from:

* Corruption.
* Unauthorized modification.
* Unauthorized access.
* Misuse or misinterpretation.

## Unresolved SRS Details

The SRS does not completely define:

* Medical-record fields and structure.
* Medical-record search fields and matching rules.
* Duplicate-record behavior after duplicates are found.
* The exact record-creation trigger.
* Archive-selection rules.
* Archive retrieval behavior.
* Which medical-record sections each role may view or update.
* The administrative access boundary.

## Related Baseline IDs

* MEDICAL-RECORD-SRS-001 through MEDICAL-RECORD-SRS-017.
* SAFETY-SRS-001, SAFETY-SRS-002, SAFETY-SRS-005, and SAFETY-SRS-006.
* DATA-SRS-001 and DATA-SRS-002.
* ARCHIVE-SRS-001.

---

# 5. Treatment and Clinical-Information Rules

## Confirmed from SRS

### BR-TREATMENT-001 — Doctor Treatment Responsibility

Doctors are responsible for creating and updating treatment plans.

### BR-TREATMENT-002 — Treatment Information

Treatment management must support information involving:

* Medications.
* Diet instructions.
* Laboratory tests or requests.
* Radiology requests.
* Other medical instructions.

### BR-TREATMENT-003 — Patient Access

Patients may view treatment plans permitted for their own medical information.

### BR-TREATMENT-004 — Secretary Restriction

Secretaries must not modify diagnoses or treatment plans.

### BR-TREATMENT-005 — Secure Medical Handling

Medical records, treatment plans, test results, and radiology images must be handled securely to avoid misuse or misinterpretation.

## Unresolved SRS Details

The SRS does not completely define:

* Treatment-plan fields.
* Treatment-plan statuses.
* Treatment-plan workflow.
* Medication fields and workflow.
* Laboratory-request fields and statuses.
* Radiology-request fields and statuses.
* Referral workflow and statuses.
* Modification and historical-preservation rules.

## Related Baseline IDs

* TREATMENT-SRS-001 through TREATMENT-SRS-006.
* REFERRAL-SRS-001.
* MEDICAL-RECORD-SRS-006.
* SAFETY-SRS-005.

---

# 6. Laboratory and Radiology Rules

## Confirmed from SRS

### BR-RESULT-001 — Result Upload Responsibility

Secretaries upload:

* Laboratory or test results.
* Radiology images.

### BR-RESULT-002 — Patient Result Access

Patients may view their permitted:

* Laboratory or test results.
* Radiology images.

### BR-RESULT-003 — Authorized Radiology-Report Access

The system must support authorized access to radiology reports.

### BR-RESULT-004 — Result Protection

Laboratory or test results and radiology images must be protected from:

* Unauthorized access.
* Unauthorized modification.
* Corruption.
* Misuse.
* Misinterpretation.

## Unresolved SRS Details

The SRS does not completely define:

* Whether a result must be linked to a previous request.
* Supported file formats.
* File-size limits.
* Multiple-file behavior.
* Upload correction or replacement rules.
* Result-review workflow.
* Exact result-access permissions.
* Whether external medical-file storage will be used.

## Related Baseline IDs

* LAB-SRS-001 and LAB-SRS-002.
* RADIOLOGY-SRS-001 through RADIOLOGY-SRS-003.
* RESULT-UPLOAD-SRS-001.
* SAFETY-SRS-005 and SAFETY-SRS-006.
* EXTERNAL-SRS-003.

---

# 7. Payment Rules

## Confirmed from SRS

### BR-PAYMENT-001 — Online Payment

The system must support online payment for medical services.

### BR-PAYMENT-002 — Payment Timing Policy

Payment may be required before or after appointment confirmation according to system policy.

### BR-PAYMENT-003 — Transaction Verification

Payment transactions must be verified before service completion is confirmed.

### BR-PAYMENT-004 — Successful Payment

The system must confirm successful payment transactions.

### BR-PAYMENT-005 — Failed Payment

The system must notify the user when a payment transaction fails.

### BR-PAYMENT-006 — Secure Integration

Sensitive payment information must be protected during integration with the external payment service.

## Unresolved SRS Details

The SRS does not completely define:

* The final payment-timing policy.
* Supported payment methods.
* Payment statuses.
* Refund behavior.
* Failed-payment handling beyond notification.
* Invoice behavior.
* Manual or physical payment behavior.
* The exact relationship between payment, appointment confirmation, and service completion.

## External Dependency Unresolved

The payment-gateway provider and integration method remain unresolved under SRS TBD-1.

The external payment integration cannot be finalized until these details are selected.

## Related Baseline IDs

* PAYMENT-SRS-001 through PAYMENT-SRS-006.
* EXTERNAL-SRS-001.
* SECURITY-SRS-013.
* TBD-1.

---

# 8. Notification Rules

## Confirmed from SRS

### BR-NOTIFICATION-001 — Appointment Reminders

The system must send appointment reminders to Patients.

### BR-NOTIFICATION-002 — System Notifications

The system must support system notifications and alerts.

### BR-NOTIFICATION-003 — Notification Display

The system must display applicable notifications to users.

### BR-NOTIFICATION-004 — Offers and Announcements

The notification capability must support promotional offers and announcements.

### BR-NOTIFICATION-005 — External Notification Integration

The system must integrate with email or SMS services for reminders and alerts.

### BR-NOTIFICATION-006 — External Data Protection

Sensitive information must be protected when notification services are used.

## Unresolved SRS Details

The SRS does not completely define:

* Mandatory notification events.
* Notification recipients.
* Reminder timing.
* Delivery channels for each event.
* Notification preferences.
* Notification history.
* Promotional targeting.
* Administrative notification permissions.
* Notification templates.
* Whether email, SMS, or both are required.

## External Dependency Unresolved

The notification-service provider remains unresolved under SRS TBD-2.

External notification delivery cannot be finalized until the provider and required channels are selected.

## Related Baseline IDs

* NOTIFICATION-SRS-001 through NOTIFICATION-SRS-005.
* EXTERNAL-SRS-002.
* SECURITY-SRS-013.
* TBD-2.

---

# 9. Complaint Rules

## Confirmed from SRS

### BR-COMPLAINT-001 — Complaint Submission

Patients may submit complaints.

### BR-COMPLAINT-002 — Administrative Review

Authorized administrative users may view, review, and manage complaints.

### BR-COMPLAINT-003 — Evaluation-Based Action

Appropriate administrative action must be taken according to complaint evaluation.

## Unresolved SRS Details

The SRS does not completely define:

* Complaint fields.
* Complaint statuses.
* Complaint recipients.
* Complaint assignment.
* Replies.
* Patient follow-up.
* Attachments.
* Closure behavior.
* Deletion or archival behavior.
* The named administrative role responsible for each complaint action.

## Related Baseline IDs

* COMPLAINT-SRS-001 through COMPLAINT-SRS-004.

---

# 10. Offer and Promotion Rules

## Confirmed from SRS

### BR-OFFER-001 — Administrative Offer Management

Authorized administrative users may create and manage offers and promotions.

### BR-OFFER-002 — Patient Offer Access

Patients may view offers and promotions.

## Unresolved SRS Details

The SRS does not completely define:

* Offer fields.
* Eligibility rules.
* Start and end dates.
* Discount behavior.
* Relationships with departments, services, Doctors, or Patients.
* Publication behavior.
* Notification targeting.
* Activation, suspension, deletion, or archival behavior.
* Whether an offer affects payment automatically.
* The final named administrative role responsible for offer management.

## Related Baseline IDs

* OFFER-SRS-001 through OFFER-SRS-003.
* NOTIFICATION-SRS-004.

---

# 11. Policy, Reporting, and Administrative Rules

## Confirmed from SRS

### BR-ADMIN-001 — System Policies

Administrative functions must support management of system policies.

### BR-ADMIN-002 — Appointment-Cancellation Policy

The system must support definition of appointment-cancellation policies.

### BR-ADMIN-003 — Reports

The system must generate system reports.

### BR-ADMIN-004 — Analytics

The system must provide analytics and statistics.

### BR-ADMIN-005 — Super Administrator Monitoring

The Super Administrator monitors working schedules and appointments.

## Unresolved SRS Details

The SRS does not completely define:

* The complete configurable policy set.
* Report types.
* Report filters.
* Report formats.
* Analytics and dashboard metrics.
* Sensitive-data restrictions for reports.
* The mapping of general administrative capabilities to named system roles.

## External Detail Unresolved

Reporting and analytics details remain unresolved under SRS TBD-7.

## Related Baseline IDs

* POLICY-SRS-001 and POLICY-SRS-002.
* REPORT-SRS-001.
* ANALYTICS-SRS-001.
* SCHEDULE-SRS-003.
* TBD-7.

---

# 12. Data Integrity, Logging, Retention, and Recovery Rules

## Confirmed from SRS

### BR-DATA-001 — Data Accuracy and Consistency

Stored Patient, appointment, medical, and administrative information must remain accurate and consistent.

### BR-DATA-002 — Input Validation

The system must validate data to prevent invalid, incorrect, or incomplete entry.

### BR-DATA-003 — Database Integrity

The database must preserve data integrity and consistency.

### BR-DATA-004 — Concurrent Access

The database must support concurrent access without data conflicts.

### BR-AUDIT-001 — Critical-Action Logging

Critical actions must be logged for traceability and accountability.

### BR-AUDIT-002 — Required Logged Categories

The system must log:

* Login attempts.
* Data updates.
* Administrative changes.

### BR-RETENTION-001 — Data Retention

Medical records and related system information must be retained for a defined period according to organizational policy.

### BR-ARCHIVE-001 — Archive Access

Archived information must remain accessible to authorized users when needed.

### BR-RECOVERY-001 — Backup and Recovery

The system must support backup and recovery mechanisms intended to prevent data loss and restore operation after failure.

## Unresolved SRS Details

The SRS does not completely define:

* Field-level validation rules.
* Concurrency-control rules.
* The complete list of critical actions.
* Log fields.
* Log-access permissions.
* Log-retention duration.
* Whether logs are immutable.
* Data-retention duration.
* Archive-selection rules.
* Backup frequency and storage.
* Recovery procedures.
* Recovery-time and recovery-point targets.

## External Detail Unresolved

The following remain unresolved:

* TBD-4 — Data Retention Policy.
* TBD-6 — Backup and Recovery Strategy.

## Related Baseline IDs

* DATA-SRS-001 and DATA-SRS-002.
* DATABASE-SRS-001 through DATABASE-SRS-003.
* AUDIT-SRS-001 through AUDIT-SRS-003.
* BACKUP-SRS-001.
* RETENTION-SRS-001.
* ARCHIVE-SRS-001.
* RECOVERY-SRS-001.
* TBD-4 and TBD-6.

---

# 13. General Security and Safety Rules

## Confirmed from SRS

### BR-SECURITY-001 — Secure Communication

Sensitive data exchanges must be protected using HTTPS.

### BR-SECURITY-002 — Common Web Threats

The system must protect against:

* SQL Injection.
* Cross-Site Scripting.
* Cross-Site Request Forgery.

### BR-SECURITY-003 — Critical-Data Protection

The system must prevent unauthorized access, modification, or deletion of critical information.

### BR-SECURITY-004 — Clear Errors

The system must provide clear error information for invalid input and system failures.

### BR-SECURITY-005 — Secure External Integration

Payment and notification integrations must protect sensitive information from exposure.

## Unresolved SRS Details

The SRS does not completely define:

* The applicable security or healthcare compliance framework.
* Sensitive-data masking rules.
* Privacy-consent requirements.
* The complete set of critical actions.
* Re-authentication rules for individual sensitive operations.
* The final security-compliance controls.

## External Detail Unresolved

Security-standards compliance remains unresolved under SRS TBD-5.

## Related Baseline IDs

* SECURITY-SRS-001 through SECURITY-SRS-013.
* PRIVACY-SRS-001 through PRIVACY-SRS-003.
* SAFETY-SRS-001 through SAFETY-SRS-006.
* ERROR-SRS-001.
* TBD-5.

---

# Current Status

This file has been populated using only Business Rules explicitly supported by the SRS-derived baseline in `BACKEND_ANALYSIS.md`.

No missing value, provider, workflow, permission, or policy has been invented.

Detailed unanswered questions will be consolidated later in `PROJECT_UNDERSTANDING_QA.md`.

The next documentation-audit step is to rebuild `PROJECT_UNDERSTANDING_QA.md` as the canonical, non-duplicated list of Backend questions not answered by the SRS.
