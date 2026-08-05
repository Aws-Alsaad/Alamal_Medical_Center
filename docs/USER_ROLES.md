# User Roles

## Purpose

This file defines the Backend-relevant user roles and the role capabilities, restrictions, and unresolved permission boundaries explicitly supported by the SRS-derived baseline.

It does not define:

* Database design.
* API endpoints.
* Laravel authorization implementation.
* Technical architecture.
* A complete field-level permission matrix.
* Answers to role questions not resolved by the SRS.

## Authoritative Source

Until delivery of the first working Backend version:

* The SRS is the sole authoritative source for functional role requirements.
* `BACKEND_ANALYSIS.md` is the authoritative SRS-derived Backend baseline.
* This file organizes role information from that baseline and is not an independent requirements source.

## Role-Documentation Rules

Role information in this file is classified as:

* **Confirmed from SRS:** Explicitly supported by the SRS-derived baseline.
* **Confirmed Restriction from SRS:** An explicitly stated limitation on a role.
* **Unresolved SRS Detail:** The SRS confirms the general capability but does not define its complete boundaries.
* **Internal SRS Clarification Required:** The SRS contains statements that require later reconciliation.

A capability must not be assigned to a role merely because that role could logically perform it.

Detailed unanswered questions will be consolidated later in `PROJECT_UNDERSTANDING_QA.md`.

---

# 1. Patient

## Role Purpose

The Patient uses the system to access medical-center information and services related to their own account, appointments, medical information, payments, notifications, offers, and complaints.

## Confirmed from SRS

The Patient can:

* Register using required personal information.
* Log in using valid credentials.
* Log out securely.
* Reset their password.
* Change their password while authenticated.
* Edit permitted profile information.
* View medical departments and medical services.
* View department information.
* View medical-service details and costs.
* View Doctor lists and Doctor profiles.
* View Doctor schedules and working hours.
* Submit a consultation form.
* Book appointments.
* Modify appointments within the allowed time policy.
* Cancel appointments within the allowed time policy.
* View appointment schedules.
* View their own medical records and medical history.
* View treatment plans.
* View laboratory or test results.
* View radiology images and available radiology reports.
* Receive appointment reminders.
* Receive and view system notifications and alerts.
* View offers and promotions.
* Make online payments for medical services.
* Receive confirmation of successful payment transactions.
* Receive notification when a payment fails.
* View payment history.
* Submit complaints.

## Confirmed Restrictions from SRS

The Patient:

* Shall access and manage only their own personal data.
* Shall access and manage only their own appointments.
* Shall access and manage only their own medical records.
* Shall not access sensitive information belonging to other users unless another explicit SRS requirement permits it.

## Unresolved SRS Details

The SRS does not completely define:

* The complete Patient-registration field set.
* The exact Patient-profile fields.
* Which profile fields the Patient may modify.
* The consultation-form fields, recipient, workflow, and statuses.
* Whether Patient-booked appointments require Secretary approval.
* Appointment statuses and transitions.
* Appointment duration.
* The final appointment modification and cancellation periods.
* Appointment-conflict and rescheduling rules.
* The medical-record fields and structure.
* The exact treatment-plan information visible to the Patient.
* Laboratory and radiology file formats and download behavior.
* Mandatory notification events and delivery channels.
* Reminder timing.
* Payment methods, statuses, timing, refunds, invoices, and gateway details.
* Offer eligibility and application behavior.
* Complaint fields, statuses, replies, attachments, and follow-up behavior.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* PROFILE-SRS-001.
* PATIENT-ACCOUNT-SRS-001 and PATIENT-ACCOUNT-SRS-002.
* DIRECTORY-SRS-001 and DIRECTORY-SRS-002.
* SERVICE-SRS-001.
* DOCTOR-DIRECTORY-SRS-001 and DOCTOR-DIRECTORY-SRS-002.
* CONSULTATION-SRS-001.
* APPOINTMENT-SRS-001 through APPOINTMENT-SRS-004 and APPOINTMENT-SRS-007.
* MEDICAL-RECORD-SRS-001 and MEDICAL-RECORD-SRS-009.
* TREATMENT-SRS-001.
* LAB-SRS-001.
* RADIOLOGY-SRS-001 and RADIOLOGY-SRS-003.
* PAYMENT-SRS-001 through PAYMENT-SRS-004.
* NOTIFICATION-SRS-001 through NOTIFICATION-SRS-004.
* COMPLAINT-SRS-001.
* OFFER-SRS-002.
* ROLE-SRS-001.

---

# 2. Doctor

## Role Purpose

The Doctor uses the system to access assigned Patient medical information and manage permitted clinical treatment information.

## Confirmed from SRS

The Doctor can:

* Log in using valid credentials.
* Log out securely.
* Reset their password.
* Change their password while authenticated.
* Edit permitted profile information.
* Access medical records of assigned Patients.
* View permitted Patient medical information.
* Update permitted Patient medical-record information.
* Create treatment plans.
* Update treatment plans.
* Add and manage treatment information involving medications.
* Add diet instructions.
* Add laboratory-test or laboratory-request information.
* Add radiology-request information.
* Add other medical instructions.
* Share medical updates with Patients through supported system functionality.
* Refer Patients to other departments.

## Confirmed Restrictions from SRS

The Doctor:

* Shall access only medical records of assigned Patients.
* Shall access only data and functions permitted to the Doctor role.
* Shall not receive unrestricted access to all Patient medical records merely because the user is a Doctor.

## Unresolved SRS Details

The SRS does not completely define:

* Which Doctor-profile fields may be viewed or edited.
* The definition of an assigned Patient.
* When Doctor access to a medical record begins.
* When Doctor access to a medical record ends.
* Which medical-record sections the Doctor may update.
* The exact schedule and appointment information visible to the Doctor.
* Whether the Doctor has any schedule-management capability.
* Treatment-plan fields, statuses, and workflow.
* Medication fields and workflow.
* Laboratory-request fields and statuses.
* Radiology-request fields and statuses.
* The result-review workflow.
* Referral recipients, statuses, and workflow.
* How medical updates are shared with Patients.
* Historical modification and preservation rules.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* PROFILE-SRS-001.
* DOCTOR-DIRECTORY-SRS-001 and DOCTOR-DIRECTORY-SRS-002.
* MEDICAL-RECORD-SRS-002 through MEDICAL-RECORD-SRS-004.
* TREATMENT-SRS-002 through TREATMENT-SRS-006.
* REFERRAL-SRS-001.
* RADIOLOGY-SRS-003.
* ROLE-SRS-002.
* SAFETY-SRS-001.

---

# 3. Secretary

## Role Purpose

The Secretary performs permitted appointment, scheduling, Patient-record, and medical-result upload operations.

## Confirmed from SRS

The Secretary can:

* Log in using valid credentials.
* Log out securely.
* Reset their password.
* Change their password while authenticated.
* Edit permitted profile information.
* Manage appointments.
* Create appointments when necessary.
* Update appointments when necessary.
* Cancel appointments when necessary.
* Create and manage working schedules.
* Manage permitted Patient-record information.
* Search for Patient medical records using Patient information.
* Verify whether a matching medical record already exists.
* View medical-record details when a matching record is found.
* Receive an appropriate system response when no matching record exists.
* Create a new Patient medical record when required.
* Validate Patient information entered during medical-record creation.
* Save newly created medical records.
* Receive confirmation after successful medical-record creation.
* Upload laboratory or test results.
* Upload radiology images.

## Confirmed Restrictions from SRS

The Secretary:

* Shall not modify medical diagnoses.
* Shall not modify treatment plans.
* Shall access only data and functions permitted to the Secretary role.
* Shall not receive unrestricted clinical permissions through appointment or record-management responsibilities.

## Unresolved SRS Details

The SRS does not completely define:

* The Secretary-profile fields.
* Whether appointment requests require Secretary approval.
* Appointment statuses and status transitions.
* Rescheduling and missed-appointment behavior.
* The meaning and structure of daily scheduling.
* The final schedule-management boundary between Secretaries and Super Administrators.
* Department-schedule meaning.
* Which administrative Patient-record sections the Secretary may view or modify.
* Medical-record search fields and matching rules.
* Duplicate-record behavior.
* The exact trigger for medical-record creation.
* Whether uploaded results must be linked to previous requests.
* File formats, file sizes, and multiple-file behavior.
* Upload correction or replacement behavior.
* Result-access permissions.
* Notification responsibilities.
* Administrative access to payments, offers, complaints, or reports.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* PROFILE-SRS-001.
* APPOINTMENT-SRS-005, APPOINTMENT-SRS-006, APPOINTMENT-SRS-008, and APPOINTMENT-SRS-009.
* SCHEDULE-SRS-001.
* MEDICAL-RECORD-SRS-005 through MEDICAL-RECORD-SRS-017.
* RESULT-UPLOAD-SRS-001.
* ROLE-SRS-003.

---

# 4. Super Administrator

## Role Purpose

The Super Administrator performs high-level account management, system configuration, policy administration, monitoring, and other administrative responsibilities defined by the SRS.

## Confirmed from SRS

The Super Administrator can:

* Log in using valid credentials.
* Log out securely.
* Reset their password.
* Change their password while authenticated.
* Edit permitted profile information.
* Manage user accounts.
* Create Doctor accounts.
* Edit Doctor accounts.
* Revoke Doctor accounts.
* Create Secretary accounts.
* Edit Secretary accounts.
* Revoke Secretary accounts.
* Perform system-configuration responsibilities.
* Perform high-level administrative management.
* Monitor working schedules and appointments.
* Access system reports.
* Access analytics and statistics.

The SRS states that Super Administrators have full access to system functionality, including account management and system configuration.

## Internal SRS Clarification Required

The phrase full access must be reconciled with other SRS requirements stating that:

* Only authorized personnel may modify medical data.
* Doctors update permitted Patient medical information.
* Secretaries must not modify diagnoses or treatment plans.
* Sensitive data must remain restricted according to role.

Until this clarification is resolved, the phrase full access must not be used to invent unrestricted clinical permissions for the Super Administrator.

## Unresolved SRS Details

The SRS does not completely define:

* The exact scope of Super Administrator access.
* Super Administrator access to Patient medical records.
* Whether the Super Administrator may modify clinical information.
* The exact department-management operations.
* The exact medical-service-management operations.
* The exact Doctor-information management operations.
* Schedule-management boundaries shared with Secretaries.
* Whether the Super Administrator directly manages appointments.
* The complete configurable system policies.
* The mapping of general SRS administrator capabilities to the Super Administrator.
* Complaint-management permissions.
* Offer-management permissions.
* Report types, filters, formats, and sensitive-data restrictions.
* Analytics and dashboard metrics.
* Payment-administration permissions.
* Notification-administration permissions.
* Backup, recovery, retention, hosting, and other technical-administration boundaries.

## Related Baseline IDs

* AUTH-SRS-001 through AUTH-SRS-005.
* PROFILE-SRS-001.
* ACCOUNT-ADMIN-SRS-001 and ACCOUNT-ADMIN-SRS-002.
* DOCTOR-ADMIN-SRS-001.
* SCHEDULE-SRS-002 and SCHEDULE-SRS-003.
* POLICY-SRS-001 and POLICY-SRS-002.
* REPORT-SRS-001.
* ANALYTICS-SRS-001.
* ADMIN-SRS-001 and ADMIN-SRS-002.
* ROLE-SRS-004 and ROLE-SRS-005.

---

# 5. General Administrative Actor References

Some SRS requirements use general terms such as:

* Administrator.
* Administrators.
* Administrative functions.
* Authorized administrative users.

The SRS uses these general terms for capabilities including:

* Viewing, reviewing, and managing complaints.
* Creating and managing offers and promotions.
* Managing system policies.
* Performing administrative functions.

These general references must not automatically be mapped to the Super Administrator, Secretary, or another role unless the SRS-derived baseline explicitly provides that mapping.

The final mapping of general administrative capabilities to named system roles remains unresolved.

## Related Baseline IDs

* COMPLAINT-SRS-002 through COMPLAINT-SRS-004.
* OFFER-SRS-001 through OFFER-SRS-003.
* POLICY-SRS-001 and POLICY-SRS-002.
* ADMIN-SRS-001.

---

# 6. Cross-Role Authorization Rules

The Backend must enforce the following rules across all roles:

* Protected functions require authentication.
* Role-based access control applies to Patient, Doctor, Secretary, and Super Administrator roles.
* Users may access only the data and functions permitted to their roles.
* Sensitive data is accessible only to authorized users.
* Medical records, personal information, and payment information must be protected from unauthorized access.
* Only authorized personnel may modify medical data.
* Unauthorized modification or deletion of critical information must be prevented.
* Passwords must be stored in hashed form.
* Authenticated sessions or equivalent authentication state must be protected.
* Authentication sessions must expire after a defined period of inactivity.
* Users must re-authenticate after session expiration.
* Critical actions must be logged where required by the SRS.
* Data updates and administrative changes must be logged.

The detailed field-level permission matrix remains unresolved and must not be invented during implementation.

# Current Status

This file has been rebuilt using only role information supported by the SRS-derived baseline in `BACKEND_ANALYSIS.md`.

Detailed unanswered role questions will be consolidated later in `PROJECT_UNDERSTANDING_QA.md`.

The next documentation-audit step is to populate `BUSINESS_RULES.md` using only rules explicitly supported by the SRS.
