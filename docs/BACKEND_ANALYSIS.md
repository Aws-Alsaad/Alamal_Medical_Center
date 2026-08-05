# Backend Analysis

## Purpose

This file is the authoritative analysis baseline for Backend requirements extracted from the SRS.

It will organize the requirements that the Laravel Backend must support before database design, API design, and implementation begin.

## Current Phase

Phase 1 — Pass A and Pass B have extracted the Backend-related requirements explicitly contained in the SRS.

Pass A documents functional capabilities, actor responsibilities, and functional Business Rules.

Pass B documents nonfunctional requirements, technology constraints, operating-environment requirements, external dependencies, data requirements, SRS TBD items, and final extraction-coverage findings.

The complete SRS-derived Backend baseline must be reviewed before the existing project documentation is audited.

## Authoritative Functional Source

Until delivery of the first working version, the SRS is the sole authoritative source for functional requirements.

Existing documentation may be used only to:

* Locate topics that require comparison.
* Detect duplicates.
* Detect information that conflicts with the SRS.
* Detect questions already answered by the SRS.
* Collect questions not answered by the SRS.

Existing documentation must not add a functional requirement that is not supported by the SRS.

## Analysis Scope

The SRS analysis will cover:

* User accounts and authentication.
* User roles and authorization.
* User profiles.
* Medical departments and services.
* Doctor profiles, schedules, and availability.
* Appointment management.
* Patient medical records.
* Medical visits and treatment plans.
* Laboratory requests and results.
* Radiology requests, images, and reports.
* Notifications and reminders.
* Payments.
* Complaints.
* Offers and announcements.
* Administration.
* Reports and analytics.
* File management.
* Security.
* Performance.
* Data integrity.
* External services and integrations.
* Deployment-related dependencies stated by the SRS.

## Requirement Classification

Each analyzed point must use one of the following classifications:

### Confirmed from SRS

The requirement is explicitly supported by the SRS and may be used for implementation planning.

### Open Question — Not Answered by SRS

The SRS does not provide the functional detail required to answer the question.

No answer may be invented before team clarification.

### Deferred Implementation — Missing Required Detail or External Dependency

The SRS contains the requirement, but implementation cannot be completed correctly because a required detail, provider, or integration decision is missing.

### Removed from Active Requirements — Not Supported by SRS

The statement appeared in previous documentation but is not supported by the SRS and must not control implementation.

### Not a Backend Requirement

The point belongs entirely to another project responsibility and does not require Backend implementation.

## Extraction Rules

* Review the complete SRS.
* Preserve the original requirement identifier or SRS section reference whenever available.
* Extract requirements from all relevant SRS sections, not only the numbered Functional Requirements.
* Do not infer missing functional behavior.
* Do not use previous undocumented answers as requirements.
* Do not duplicate the same requirement under multiple sections without a clear documentation purpose.
* Record dependencies between requirements without adding new requirements.
* Record unresolved details as Open Questions.
* Keep external-service requirements even when their providers are not yet selected.

## Planned Output Structure

The extracted baseline will be organized by Backend module or technical concern.

Every entry should include, when applicable:

* Requirement identifier.
* Requirement statement.
* SRS source section.
* Priority stated by the SRS.
* Related actor or actors.
* Related Backend module.
* Dependencies.
* Implementation status.
* Related Open Question identifiers.

# SRS Functional Requirements Baseline

## Baseline Notes

This baseline consolidates functional requirements explicitly stated in the SRS.

The same requirement may be supported by more than one SRS section. Repeated SRS statements are consolidated into one baseline entry while preserving the relevant source references.

The readiness values used in this baseline mean:

* **Clear:** The SRS states enough functional behavior for implementation planning.
* **Partially Defined:** The SRS confirms the capability but does not define all functional details required for complete implementation.
* **External Dependency Unresolved:** The requirement is confirmed, but an external provider or integration detail is not defined.
* **Internal SRS Clarification Required:** The SRS contains statements that require later reconciliation.

No missing functional behavior is inferred in this baseline.

---

## 1. User Accounts, Authentication, and Profiles

| Baseline ID             | Requirement                                                                                              | SRS Source                             | SRS Feature Priority    | Readiness         |
| ----------------------- | -------------------------------------------------------------------------------------------------------- | -------------------------------------- | ----------------------- | ----------------- |
| AUTH-SRS-001            | The system shall allow users to log in using valid credentials.                                          | FR-1; Sections 2.2 and 2.3             | High                    | Clear             |
| AUTH-SRS-002            | The system shall reject invalid login attempts and display an error message.                             | FR-2                                   | High                    | Clear             |
| AUTH-SRS-003            | The system shall allow users to log out securely.                                                        | FR-3                                   | High                    | Clear             |
| AUTH-SRS-004            | The system shall allow users to reset their passwords.                                                   | FR-4                                   | High                    | Partially Defined |
| AUTH-SRS-005            | The system shall allow authenticated users to change their passwords.                                    | FR-5                                   | High                    | Clear             |
| PROFILE-SRS-001         | The system shall allow users to edit their profile information.                                          | FR-6; Sections 2.2 and 2.3             | High                    | Partially Defined |
| VALIDATION-SRS-001      | The system shall validate input fields before submission.                                                | FR-7                                   | High                    | Partially Defined |
| PATIENT-ACCOUNT-SRS-001 | The system shall allow Patients to register using required personal information.                         | FR-8; Sections 2.2 and 2.3             | High                    | Partially Defined |
| PATIENT-ACCOUNT-SRS-002 | Patient registration information explicitly mentioned by the SRS includes email, mobile number, and age. | Section 2.2                            | Not individually stated | Partially Defined |
| ACCOUNT-ADMIN-SRS-001   | Super Administrators shall manage user accounts.                                                         | FR-38; Sections 2.2, 2.3, and 5.5      | Medium                  | Clear             |
| ACCOUNT-ADMIN-SRS-002   | Only Super Administrators shall create, edit, or revoke Doctor and Secretary accounts.                   | Section 5.5 — Account Management Rules | Not individually stated | Clear             |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The full required Patient-registration field set.
* The password-reset delivery mechanism.
* The exact editable profile fields for each role.
* The validation rules for individual account and profile fields.

These are definition gaps only and are not answered in this file.

---

## 2. Department, Service, and Doctor Exploration

| Baseline ID              | Requirement                                                                             | SRS Source                  | SRS Feature Priority    | Readiness         |
| ------------------------ | --------------------------------------------------------------------------------------- | --------------------------- | ----------------------- | ----------------- |
| DIRECTORY-SRS-001        | The system shall allow Patients to view medical departments and medical services.       | FR-9; Sections 2.2 and 2.3  | High                    | Clear             |
| DIRECTORY-SRS-002        | The system shall display detailed or general information about each medical department. | FR-10; Section 2.2          | High                    | Partially Defined |
| SERVICE-SRS-001          | The system shall display medical-service details and costs.                             | Section 2.2                 | Not individually stated | Partially Defined |
| DOCTOR-DIRECTORY-SRS-001 | The system shall display Doctor lists and Doctor profiles.                              | FR-11; Sections 2.2 and 2.3 | High                    | Partially Defined |
| DOCTOR-DIRECTORY-SRS-002 | The system shall allow users to view Doctor schedules and working hours.                | Sections 2.2 and 2.3; FR-21 | High                    | Partially Defined |
| DOCTOR-ADMIN-SRS-001     | The system shall support administrative management of Doctor accounts.                  | Sections 2.2 and 2.3; FR-38 | Medium                  | Partially Defined |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The fields contained in department details.
* The fields contained in medical-service details.
* The fields contained in Doctor profiles.
* Which users may view each Doctor-profile field.
* Detailed administrative Doctor-management operations beyond account management.

---

## 3. Patient Consultation Forms

| Baseline ID          | Requirement                                                   | SRS Source                  | SRS Feature Priority | Readiness         |
| -------------------- | ------------------------------------------------------------- | --------------------------- | -------------------- | ----------------- |
| CONSULTATION-SRS-001 | The system shall allow Patients to submit consultation forms. | FR-12; Sections 1.4 and 2.3 | High                 | Partially Defined |

### Functional Definition Gaps Identified

The SRS confirms the consultation-form capability but does not define:

* The consultation form's purpose.
* Its required fields.
* Its recipient.
* Its workflow.
* Its statuses.
* Whether it is linked to a Doctor, department, service, or appointment.

---

## 4. Appointment and Schedule Management

| Baseline ID         | Requirement                                                                                                                                                     | SRS Source                             | SRS Feature Priority    | Readiness         |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------- | ----------------------- | ----------------- |
| APPOINTMENT-SRS-001 | The system shall allow Patients to book appointments.                                                                                                           | FR-17; Sections 2.2 and 2.3            | High                    | Clear             |
| APPOINTMENT-SRS-002 | Appointment booking shall be based on Doctor availability.                                                                                                      | Section 5.5 — Appointment Rules        | Not individually stated | Partially Defined |
| APPOINTMENT-SRS-003 | The system shall allow Patients to edit appointments within allowed time constraints.                                                                           | FR-18; Sections 2.2 and 2.3            | High                    | Partially Defined |
| APPOINTMENT-SRS-004 | The system shall allow Patients to cancel appointments within allowed time constraints.                                                                         | FR-19; Sections 2.2 and 2.3            | High                    | Partially Defined |
| APPOINTMENT-SRS-005 | Secretaries shall be able to manage appointments.                                                                                                               | FR-20; Sections 2.2, 2.3, and 5.5      | High                    | Partially Defined |
| APPOINTMENT-SRS-006 | Secretaries shall have authority to create, update, or cancel appointments when necessary.                                                                      | Section 5.5 — Appointment Rules        | Not individually stated | Clear             |
| APPOINTMENT-SRS-007 | The system shall display appointment schedules to users.                                                                                                        | FR-21                                  | High                    | Partially Defined |
| APPOINTMENT-SRS-008 | The system shall support daily scheduling and appointment tracking.                                                                                             | Section 2.2                            | Not individually stated | Partially Defined |
| APPOINTMENT-SRS-009 | Appointment requests may require Secretary confirmation or approval.                                                                                            | Section 5.5 — Appointment Rules        | Not individually stated | Partially Defined |
| APPOINTMENT-SRS-010 | Appointment modification and cancellation shall be controlled by a predefined time policy.                                                                      | Sections 2.5 and 5.5; FR-18 and FR-19  | High                    | Partially Defined |
| APPOINTMENT-SRS-011 | The SRS gives at least three days before the appointment as an example of a possible modification or cancellation policy, not as an explicitly finalized value. | Section 5.5 — Appointment Rules        | Not individually stated | Partially Defined |
| SCHEDULE-SRS-001    | Secretaries shall create and manage working schedules.                                                                                                          | Section 2.3 — Secretary                | Not individually stated | Partially Defined |
| SCHEDULE-SRS-002    | Administrative functions shall include management of Doctor and department schedules.                                                                           | Section 2.2 — Administrative Functions | Not individually stated | Partially Defined |
| SCHEDULE-SRS-003    | Super Administrators shall monitor working schedules and appointments.                                                                                          | Section 2.3 — Super Administrator      | Not individually stated | Partially Defined |

### Functional Definition Gaps Identified

The SRS does not completely define:

* Whether Patient-booked appointments require Secretary approval.
* Doctor-availability calculation rules.
* Appointment statuses.
* Appointment-status transitions.
* The exact modification period.
* The exact cancellation period.
* Appointment duration.
* Schedule structure.
* Schedule-management permissions for Secretaries and Super Administrators.
* Department-schedule meaning and behavior.
* Appointment-conflict rules.
* Missed-appointment handling.
* Rescheduling behavior.

---

## 5. Patient Medical Records

| Baseline ID            | Requirement                                                                                                    | SRS Source                                    | SRS Feature Priority    | Readiness         |
| ---------------------- | -------------------------------------------------------------------------------------------------------------- | --------------------------------------------- | ----------------------- | ----------------- |
| MEDICAL-RECORD-SRS-001 | The system shall allow Patients to view their medical records and medical history.                             | FR-13; Sections 2.2 and 2.3                   | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-002 | The system shall allow Doctors to view Patient medical records.                                                | FR-23; Sections 2.2 and 2.3                   | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-003 | Doctors shall have access only to medical records of assigned Patients.                                        | Section 5.5 — User Role Permissions           | Not individually stated | Partially Defined |
| MEDICAL-RECORD-SRS-004 | The system shall allow Doctors to update Patient medical records.                                              | FR-24; Sections 2.2 and 2.3                   | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-005 | The system shall allow Secretaries to create Patient medical records.                                          | FR-26; Sections 2.2 and 2.3                   | High                    | Clear             |
| MEDICAL-RECORD-SRS-006 | Secretaries shall be able to manage Patient records but shall not modify medical diagnoses or treatment plans. | Section 5.5 — User Role Permissions           | Not individually stated | Partially Defined |
| MEDICAL-RECORD-SRS-007 | Medical records shall be created and maintained only by authorized personnel.                                  | Section 5.5 — Medical Record Management Rules | Not individually stated | Partially Defined |
| MEDICAL-RECORD-SRS-008 | Medical records shall not be deleted once created, but may be updated or archived.                             | Section 5.5 — Medical Record Management Rules | Not individually stated | Clear             |
| MEDICAL-RECORD-SRS-009 | Patients shall access and manage only their own medical records and personal data.                             | Section 5.5 — User Role Permissions           | Not individually stated | Clear             |
| MEDICAL-RECORD-SRS-010 | The system shall allow Secretaries to search for Patient medical records using Patient information.            | FR-43                                         | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-011 | The system shall verify whether a medical record already exists.                                               | FR-44                                         | High                    | Clear             |
| MEDICAL-RECORD-SRS-012 | The system shall display medical-record details when a matching record is found.                               | FR-45                                         | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-013 | The system shall display an appropriate message when no matching medical record exists.                        | FR-46                                         | High                    | Clear             |
| MEDICAL-RECORD-SRS-014 | The system shall allow the Secretary to create a new medical record when necessary.                            | FR-47                                         | High                    | Clear             |
| MEDICAL-RECORD-SRS-015 | The system shall validate Patient information entered during medical-record creation.                          | FR-48                                         | High                    | Partially Defined |
| MEDICAL-RECORD-SRS-016 | The system shall save newly created medical records.                                                           | FR-49                                         | High                    | Clear             |
| MEDICAL-RECORD-SRS-017 | The system shall display confirmation after successful medical-record creation.                                | FR-50                                         | High                    | Clear             |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The medical-record structure and fields.
* What makes a Patient assigned to a Doctor.
* When Doctor access begins or ends.
* What sections a Doctor may update.
* What administrative sections a Secretary may view or modify.
* Medical-record search fields and matching rules.
* Duplicate-record behavior.
* Archive behavior.
* Record-creation timing beyond the Secretary creation capability.

---

## 6. Treatment Plans, Medical Instructions, and Referrals

| Baseline ID       | Requirement                                                                                                                              | SRS Source                                    | SRS Feature Priority    | Readiness         |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------- | ----------------------- | ----------------- |
| TREATMENT-SRS-001 | The system shall allow Patients to view treatment plans.                                                                                 | FR-14; Sections 2.2 and 2.3                   | High                    | Partially Defined |
| TREATMENT-SRS-002 | The system shall allow Doctors to create treatment plans.                                                                                | FR-25; Sections 2.2 and 2.3                   | High                    | Partially Defined |
| TREATMENT-SRS-003 | Doctors shall be able to update treatment plans.                                                                                         | Sections 2.2 and 2.3                          | High                    | Partially Defined |
| TREATMENT-SRS-004 | Doctors shall be responsible for creating and updating treatment plans.                                                                  | Section 5.5 — Medical Record Management Rules | Not individually stated | Clear             |
| TREATMENT-SRS-005 | Treatment management shall support medications, diet instructions, laboratory tests, radiology requests, and other medical instructions. | Sections 1.4, 2.2, and Appendix A             | Not individually stated | Partially Defined |
| TREATMENT-SRS-006 | The system shall support sharing medical updates with Patients.                                                                          | Section 2.2                                   | Not individually stated | Partially Defined |
| REFERRAL-SRS-001  | The system shall support referrals to other departments.                                                                                 | Section 2.2                                   | Not individually stated | Partially Defined |

### Functional Definition Gaps Identified

The SRS does not completely define:

* Treatment-plan fields.
* Treatment-plan statuses.
* Treatment-plan relationship with appointments or visits.
* Medication data.
* Diet and medical-instruction structure.
* Laboratory-request structure.
* Radiology-request structure.
* Referral workflow.
* Referral recipients.
* Referral statuses.
* How medical updates are shared with Patients.

---

## 7. Laboratory and Radiology Results

| Baseline ID           | Requirement                                                         | SRS Source                  | SRS Feature Priority    | Readiness         |
| --------------------- | ------------------------------------------------------------------- | --------------------------- | ----------------------- | ----------------- |
| LAB-SRS-001           | The system shall allow Patients to view laboratory or test results. | FR-15; Sections 2.2 and 2.3 | High                    | Partially Defined |
| LAB-SRS-002           | The system shall allow test results to be uploaded.                 | FR-27; Sections 2.2 and 2.3 | High                    | Partially Defined |
| RADIOLOGY-SRS-001     | The system shall allow Patients to view radiology images.           | FR-16; Sections 2.2 and 2.3 | High                    | Partially Defined |
| RADIOLOGY-SRS-002     | The system shall allow radiology images to be uploaded.             | FR-28; Sections 2.2 and 2.3 | High                    | Partially Defined |
| RADIOLOGY-SRS-003     | The system shall support access to radiology images and reports.    | Sections 1.4 and 2.2        | Not individually stated | Partially Defined |
| RESULT-UPLOAD-SRS-001 | Secretaries shall upload test results and radiology images.         | Section 2.3 — Secretary     | Not individually stated | Clear             |

### Functional Definition Gaps Identified

The SRS does not completely define:

* Whether an uploaded result must be linked to a prior request.
* Laboratory-result fields and supported file formats.
* Radiology-image and report fields and supported formats.
* Whether multiple files are supported.
* Upload correction or replacement behavior.
* Result-review workflow.
* Which users may view each result.
* File-size limits.

---

## 8. Payment and Financial Management

| Baseline ID     | Requirement                                                                                  | SRS Source                        | SRS Feature Priority    | Readiness                      |
| --------------- | -------------------------------------------------------------------------------------------- | --------------------------------- | ----------------------- | ------------------------------ |
| PAYMENT-SRS-001 | The system shall allow Patients to make online payments for medical services.                | FR-29; Sections 1.4, 2.2, and 2.3 | Medium                  | External Dependency Unresolved |
| PAYMENT-SRS-002 | The system shall confirm successful payment transactions.                                    | FR-30                             | Medium                  | Partially Defined              |
| PAYMENT-SRS-003 | The system shall notify users when a payment fails.                                          | FR-31                             | Medium                  | Partially Defined              |
| PAYMENT-SRS-004 | The system shall allow Patients to view payment history.                                     | Section 2.2                       | Not individually stated | Partially Defined              |
| PAYMENT-SRS-005 | Payment may be required before or after appointment confirmation according to system policy. | Section 5.5 — Payment Rules       | Not individually stated | Partially Defined              |
| PAYMENT-SRS-006 | Payment transactions shall be verified before confirming service completion.                 | Section 5.5 — Payment Rules       | Not individually stated | Partially Defined              |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The payment gateway provider.
* Supported payment methods.
* The final payment timing policy.
* Payment statuses.
* Failed-payment handling beyond notification.
* Refund behavior.
* Payment-history details.
* The relationship between payment confirmation and service completion.

---

## 9. Notifications and Communication

| Baseline ID          | Requirement                                                                     | SRS Source                                  | SRS Feature Priority             | Readiness                      |
| -------------------- | ------------------------------------------------------------------------------- | ------------------------------------------- | -------------------------------- | ------------------------------ |
| NOTIFICATION-SRS-001 | The system shall send appointment reminders to Patients.                        | FR-22 and FR-32; Sections 2.2, 2.3, and 5.5 | High and Medium feature sections | Partially Defined              |
| NOTIFICATION-SRS-002 | The system shall send system notifications and alerts.                          | FR-33; Sections 1.4, 2.2, and 5.5           | Medium                           | Partially Defined              |
| NOTIFICATION-SRS-003 | The system shall display notifications to users.                                | FR-34; Section 3.1                          | Medium                           | Clear                          |
| NOTIFICATION-SRS-004 | The notification capability shall include promotional offers and announcements. | Sections 2.2 and 2.3                        | Not individually stated          | Partially Defined              |
| NOTIFICATION-SRS-005 | The system shall integrate with email or SMS services for reminders and alerts. | Sections 2.1, 2.7, 3.3, and 3.4             | Not individually stated          | External Dependency Unresolved |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The final notification provider.
* Mandatory notification events.
* Notification recipients.
* Reminder timing.
* Whether each notification uses in-application delivery, email, SMS, or multiple channels.
* Notification preferences.
* Notification history.
* Promotional-notification targeting.

---

## 10. Complaint Management

| Baseline ID       | Requirement                                                            | SRS Source                             | SRS Feature Priority    | Readiness         |
| ----------------- | ---------------------------------------------------------------------- | -------------------------------------- | ----------------------- | ----------------- |
| COMPLAINT-SRS-001 | The system shall allow Patients to submit complaints.                  | FR-35; Sections 1.4, 2.2, 2.3, and 5.5 | Medium                  | Partially Defined |
| COMPLAINT-SRS-002 | The system shall allow administrators to view complaints.              | FR-36; Sections 2.2 and 2.3            | Medium                  | Clear             |
| COMPLAINT-SRS-003 | The system shall allow administrators to review and manage complaints. | FR-37; Sections 2.2, 2.3, and 5.5      | Medium                  | Partially Defined |
| COMPLAINT-SRS-004 | Appropriate actions shall be taken based on complaint evaluation.      | Section 5.5 — Complaint Handling Rules | Not individually stated | Partially Defined |

### Functional Definition Gaps Identified

The SRS does not completely define:

* Complaint fields.
* Complaint statuses.
* Administrative actions.
* Complaint replies.
* Complaint assignment.
* Complaint attachments.
* Complaint closure and deletion behavior.

---

## 11. Offers and Promotions

| Baseline ID   | Requirement                                                                 | SRS Source                  | SRS Feature Priority    | Readiness         |
| ------------- | --------------------------------------------------------------------------- | --------------------------- | ----------------------- | ----------------- |
| OFFER-SRS-001 | The system shall allow administrators to create and manage offers.          | FR-39; Sections 2.2 and 2.3 | Medium                  | Partially Defined |
| OFFER-SRS-002 | Patients shall be able to view offers and promotions.                       | Sections 1.4, 2.2, and 2.3  | Not individually stated | Clear             |
| OFFER-SRS-003 | Administrative functions shall include management of promotions and offers. | Sections 2.2 and 2.3        | Not individually stated | Partially Defined |

### Functional Definition Gaps Identified

The SRS does not completely define:

* Offer fields.
* Offer eligibility.
* Offer start and end dates.
* Discount behavior.
* Offer links to departments, services, Doctors, or Patients.
* Offer publication and notification behavior.

---

## 12. Administration, Policies, Reports, and Analytics

| Baseline ID       | Requirement                                                                                                                                     | SRS Source                          | SRS Feature Priority    | Readiness                           |
| ----------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------- | ----------------------- | ----------------------------------- |
| POLICY-SRS-001    | The system shall allow administrators to define appointment-cancellation policies.                                                              | FR-40; Sections 2.2 and 2.3         | Medium                  | Partially Defined                   |
| POLICY-SRS-002    | Administrative functions shall include management of system policies.                                                                           | Section 2.2                         | Not individually stated | Partially Defined                   |
| REPORT-SRS-001    | The system shall generate system reports.                                                                                                       | FR-41; Sections 1.4, 2.2, and 2.3   | Medium                  | Partially Defined                   |
| ANALYTICS-SRS-001 | The system shall display analytics and statistics.                                                                                              | FR-42; Sections 1.4, 2.2, and 2.3   | Medium                  | Partially Defined                   |
| ADMIN-SRS-001     | Super Administrators shall have system-configuration and high-level management responsibilities.                                                | Sections 2.2, 2.3, and 5.5          | Not individually stated | Partially Defined                   |
| ADMIN-SRS-002     | The SRS states that Super Administrators have full access to all system functionalities, including account management and system configuration. | Section 5.5 — User Role Permissions | Not individually stated | Internal SRS Clarification Required |

### Functional Definition Gaps Identified

The SRS does not completely define:

* The configurable appointment policies.
* Report types.
* Report filters.
* Report formats.
* Analytics and dashboard metrics.
* Access restrictions for sensitive report information.
* The exact scope of Super Administrator access.
* The relationship between full Super Administrator access and medical-data modification restrictions elsewhere in the SRS.

---

## 13. Functional Role-Access Rules

| Baseline ID  | Requirement                                                                                                              | SRS Source                                  | Readiness                           |
| ------------ | ------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------- | ----------------------------------- |
| ROLE-SRS-001 | Patients shall access and manage only their own personal data, appointments, and medical records.                        | Section 5.5 — User Role Permissions         | Clear                               |
| ROLE-SRS-002 | Doctors shall access medical records of their assigned Patients only.                                                    | Section 5.5 — User Role Permissions         | Partially Defined                   |
| ROLE-SRS-003 | Secretaries shall manage appointments, schedules, and Patient records but shall not modify diagnoses or treatment plans. | Section 5.5 — User Role Permissions         | Partially Defined                   |
| ROLE-SRS-004 | Super Administrators shall have full system access, including account management and system configuration.               | Section 5.5 — User Role Permissions         | Internal SRS Clarification Required |
| ROLE-SRS-005 | Sensitive data shall be accessible only to authorized users according to role.                                           | Section 5.5 — Data Access and Privacy Rules | Partially Defined                   |

## Functional Internal-SRS Clarifications to Preserve

The following points are not answered during this extraction pass:

1. The SRS grants Super Administrators full access to all system functionalities, while other SRS sections reserve modification of medical data for authorized medical personnel, especially Doctors.
2. The SRS states that Secretaries create and manage working schedules, that administrative functions manage Doctor and department schedules, and that Super Administrators monitor schedules, but it does not define the final schedule-management permission boundaries.
3. The SRS states that appointment requests may require Secretary approval, but does not determine whether approval is mandatory.
4. The SRS provides three days only as an example of an appointment modification or cancellation period, not as a final confirmed value.
5. The SRS confirms online payment but leaves the payment timing policy and payment gateway unresolved.

These points must remain unresolved until the later canonical Open-Questions phase.

## Functional Extraction Coverage

This functional baseline includes requirements extracted from:

* Section 1.4 — Product Scope.
* Section 2.2 — Product Functions.
* Section 2.3 — User Classes and Characteristics.
* Section 2.5 — Design and Implementation Constraints where functional policy is stated.
* Section 3 — External interfaces where a functional integration is stated.
* Sections 4.1 through 4.9.
* Functional Requirements FR-1 through FR-50.
* Section 5.5 — Business Rules.
* Relevant functional definitions in Appendix A.

The related nonfunctional requirements, constraints, dependencies, and final TBD items are documented in the subsequent SRS Nonfunctional Requirements and Constraints Baseline completed during Phase 1 — Pass B.

# SRS Nonfunctional Requirements and Constraints Baseline

## Baseline Notes

This section contains Backend-related nonfunctional requirements, implementation constraints, operating-environment requirements, data requirements, external dependencies, and unresolved SRS TBD items.

No technical solution is selected in this baseline unless the SRS explicitly requires it.

The Backend relevance values mean:

* **Direct:** Primarily implemented or enforced by the Backend.
* **Shared:** Requires coordination between the Backend and one or more client applications or infrastructure components.
* **Infrastructure:** Primarily depends on deployment, server, network, or infrastructure configuration.
* **External:** Depends on an external service or provider integrated through the Backend.
* **Organizational:** Depends on medical-center policy, organizational policy, or an external organizational decision.
* **Operational:** Relates to system operation, monitoring, maintenance, or administrative operation.
* **Not Directly Backend:** The SRS point belongs mainly to another project responsibility and is recorded only to clarify the Backend boundary.

The readiness values used in this baseline mean:

* **Clear:** The SRS states enough information for planning the requirement.
* **Partially Defined:** The SRS confirms the requirement but does not define all details needed for complete implementation or verification.
* **External Dependency Unresolved:** The requirement depends on an external provider or service that has not been selected.
* **External Detail Unresolved:** The requirement depends on an external policy, infrastructure detail, organizational decision, or strategy that has not been defined.
* **Internal SRS Clarification Required:** The SRS contains wording that is incomplete, conditional, or requires later reconciliation.

---

## 1. Required Technologies and Communication Constraints

| Baseline ID  | Requirement or Constraint                                                                                                                   | SRS Source                             | Backend Relevance | Readiness         |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------- | ----------------- | ----------------- |
| TECH-SRS-001 | The Backend shall be implemented using the Laravel PHP framework.                                                                           | Sections 2.4, 2.5, 3.3, and Appendix A | Direct            | Clear             |
| TECH-SRS-002 | The system shall use MySQL as its relational database management system.                                                                    | Sections 2.4, 2.5, 3.3, and 6          | Direct            | Clear             |
| TECH-SRS-003 | The Backend shall expose RESTful APIs for client communication.                                                                             | Sections 2.4, 3.3, 3.4, and Appendix A | Direct            | Clear             |
| TECH-SRS-004 | Data exchanged between clients and the Backend shall use JSON.                                                                              | Sections 2.4, 3.3, and 3.4             | Direct            | Clear             |
| TECH-SRS-005 | Communication between client applications and the Backend shall use HTTP/HTTPS, and all data exchanges shall be secured using HTTPS. | Sections 2.4, 2.5, 3.3, and 3.4 | Shared and Infrastructure | Clear |
| TECH-SRS-006 | The Backend is intended to be hosted on an online web server using Apache.                                                                  | Section 2.4                            | Infrastructure    | Partially Defined |
| TECH-SRS-007 | The system requires internet connectivity for online operations and real-time data access.                                                  | Sections 2.4, 2.5, 2.7, and 3.4        | Infrastructure    | Clear             |

### Definition Gaps

The SRS does not completely define:

* The Laravel version.
* The PHP version.
* The MySQL version.
* The REST API versioning convention.
* The exact hosting infrastructure.
* The server operating system.
* The HTTPS certificate and termination configuration.

---

## 2. Performance, Throughput, Availability, and Scalability

| Baseline ID | Requirement | SRS Source | Backend Relevance | Readiness |
|---|---|---|---|---|
| PERF-SRS-001 | Normal user actions and data-retrieval operations should receive a response within approximately two to three seconds under normal operating conditions. | Section 5.1 | Shared | Partially Defined |
| PERF-SRS-002 | Critical operations, including login, appointment booking, and data submission, shall complete within three seconds under normal conditions. | Section 5.1 | Direct and Shared | Partially Defined |
| PERF-SRS-003 | Retrieval of medical records, test results, and radiology images shall complete within approximately five seconds, depending on data size and network conditions. | Section 5.1 | Direct, Shared, and Infrastructure | Partially Defined |
| PERF-SRS-004 | The system shall support multiple concurrent users without significant performance degradation. | Sections 2.5, 2.7, 5.1, and 6 | Direct and Infrastructure | Partially Defined |
| PERF-SRS-005 | The SRS states a target of at least 100–200 simultaneous users, or a value determined by server capacity. | Section 5.1 | Direct and Infrastructure | Internal SRS Clarification Required |
| PERF-SRS-006 | The system shall handle multiple requests per second efficiently, including appointment bookings, record updates, and data-retrieval operations. | Section 5.1 | Direct | Partially Defined |
| PERF-SRS-007 | Backend APIs shall process requests with minimal delay to support smooth interaction with mobile and web applications. | Section 5.1 | Direct and Shared | Partially Defined |
| PERF-SRS-008 | The system shall handle database operations efficiently, including querying, inserting, and updating records. | Section 5.1 | Direct | Partially Defined |
| PERF-SRS-009 | Data-intensive reporting and analytics operations should complete within approximately five to ten seconds. | Section 5.1 | Direct and Infrastructure | Partially Defined |
| PERF-SRS-010 | Data exchange between client applications and the server shall be optimized to minimize bandwidth usage and latency. | Section 5.1 | Shared and Infrastructure | Partially Defined |
| AVAILABILITY-SRS-001 | The system shall be available continuously except during scheduled maintenance. | Sections 5.1 and 5.4 | Infrastructure | Partially Defined |
| AVAILABILITY-SRS-002 | Scheduled maintenance downtime shall be minimized and communicated to users in advance. | Section 5.1 | Shared and Infrastructure | Partially Defined |
| SCALABILITY-SRS-001 | The system shall support increasing users, data volume, and transactions without significant performance degradation. | Sections 5.1 and 5.4 | Direct and Infrastructure | Partially Defined |
| SCALABILITY-SRS-002 | The architecture shall permit horizontal and vertical scaling and future feature expansion. | Sections 5.1, 5.4, and 6 | Direct and Infrastructure | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* The final concurrent-user target.
* The expected request rate.
* The representative data volume.
* The testing environment used for measuring response times.
* The performance acceptance-test method.
* The permitted amount of scheduled downtime.
* The required recovery-time or recovery-point targets.
* The database-operation performance benchmark.
* The target bandwidth usage and network-latency limits.

---

## 3. Authentication, Authorization, Session, and Password Security

| Baseline ID      | Requirement                                                                                                         | SRS Source                           | Backend Relevance            | Readiness         |
| ---------------- | ------------------------------------------------------------------------------------------------------------------- | ------------------------------------ | ---------------------------- | ----------------- |
| SECURITY-SRS-001 | All users shall authenticate with valid credentials before accessing protected system functions.                    | Sections 2.5, 3.1, 3.4, and 5.3      | Direct                       | Clear             |
| SECURITY-SRS-002 | The system shall implement role-based access control for Patient, Doctor, Secretary, and Super Administrator roles. | Sections 2.5 and 5.3                 | Direct                       | Clear             |
| SECURITY-SRS-003 | Users shall access only the data and functions permitted for their roles.                                           | Sections 5.2, 5.3, and 5.5           | Direct                       | Partially Defined |
| SECURITY-SRS-004 | Sensitive data transmitted between clients, the Backend, and external services shall be protected through HTTPS.    | Sections 2.5, 3.3, 3.4, 5.3, and 5.4 | Shared and Infrastructure    | Clear             |
| SECURITY-SRS-005 | User passwords shall be stored in hashed form.                                                                      | Section 5.3                          | Direct                       | Clear             |
| SECURITY-SRS-006 | The system shall enforce password-strength requirements.                                                            | Section 5.3                          | Direct                       | Partially Defined |
| SECURITY-SRS-007 | The system shall provide secure password-reset functionality.                                                       | Section 5.3                          | Direct                       | Partially Defined |
| SECURITY-SRS-008 | The system shall maintain authenticated user sessions or equivalent authentication state.                           | Sections 3.1, 3.4, and 5.3           | Direct                       | Partially Defined |
| SECURITY-SRS-009 | Authentication sessions shall expire after a defined period of inactivity.                                          | Section 5.3                          | Direct                       | Partially Defined |
| SECURITY-SRS-010 | Users shall re-authenticate after session expiration.                                                               | Section 5.3                          | Direct                       | Clear             |
| SECURITY-SRS-011 | Protected API endpoints shall use secure authentication mechanisms such as tokens or sessions.                      | Sections 3.4 and 5.3                 | Direct                       | Partially Defined |
| SECURITY-SRS-012 | The system shall protect against SQL Injection, Cross-Site Scripting, and Cross-Site Request Forgery.               | Section 5.3                          | Direct and Shared            | Partially Defined |
| SECURITY-SRS-013 | Integration with payment and notification services shall protect sensitive information from exposure.               | Section 5.3                          | Direct, Shared, and External | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* Password minimum length.
* Required password character categories.
* Session-inactivity duration.
* Authentication-token or session mechanism.
* Token expiration and revocation rules.
* Re-authentication rules for sensitive operations.
* Failed-login lockout or throttling rules.
* Specific security compliance standards.

---

## 4. Privacy, Access Safety, and Medical-Data Protection

| Baseline ID     | Requirement                                                                                                                               | SRS Source                      | Backend Relevance                  | Readiness         |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | ---------------------------------- | ----------------- |
| PRIVACY-SRS-001 | Medical records, personal information, and payment information shall be protected from unauthorized access.                               | Sections 2.5, 5.2, 5.3, and 5.4 | Direct                             | Clear             |
| PRIVACY-SRS-002 | Sensitive data shall be accessed and processed only for authorized purposes.                                                              | Sections 5.3 and 5.5            | Direct                             | Partially Defined |
| PRIVACY-SRS-003 | Patient privacy shall be maintained according to general data-protection principles and applicable organizational or healthcare policies. | Sections 5.2, 5.3, and 6        | Direct, Shared, and Organizational | Partially Defined |
| SAFETY-SRS-001  | Only authorized personnel shall modify medical data.                                                                                      | Sections 5.2 and 5.5            | Direct                             | Partially Defined |
| SAFETY-SRS-002  | The system shall prevent unauthorized modification or deletion of critical data, including medical records and appointments.              | Sections 5.2 and 5.3            | Direct                             | Partially Defined |
| SAFETY-SRS-003  | Critical actions, including deletion and appointment cancellation, shall require user confirmation.                                       | Section 5.2                     | Shared                             | Partially Defined |
| SAFETY-SRS-004  | Appointment modification and cancellation restrictions shall be enforced according to predefined policies.                                | Sections 2.5, 5.2, and 5.5      | Direct                             | Partially Defined |
| SAFETY-SRS-005 | Medical records, treatment plans, test results, and radiology images shall be handled securely to avoid misinterpretation or misuse. | Section 5.2 | Direct and Shared | Partially Defined |
| SAFETY-SRS-006 | Patient medical data shall be accurately stored and protected from corruption or unauthorized modification. | Section 5.2 | Direct | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* The applicable legal or healthcare compliance framework.
* The detailed role-permission matrix.
* Which actions are considered critical.
* Which data can be permanently deleted.
* Confirmation mechanisms for critical actions.
* Privacy-consent requirements.
* Sensitive-data masking rules.

---

## 5. Data Integrity, Validation, Error Handling, and Robustness

| Baseline ID         | Requirement                                                                                                  | SRS Source                                 | Backend Relevance         | Readiness         |
| ------------------- | ------------------------------------------------------------------------------------------------------------ | ------------------------------------------ | ------------------------- | ----------------- |
| DATA-SRS-001        | Stored Patient, appointment, medical, and administrative information shall remain accurate and consistent.   | Sections 2.7, 3.3, 5.2, 5.3, 5.4, and 6    | Direct                    | Partially Defined |
| DATA-SRS-002        | The system shall validate data to prevent invalid, incorrect, or incomplete entry.                           | Sections 3.1, 5.2, and 5.4; FR-7 and FR-48 | Direct and Shared         | Partially Defined |
| DATABASE-SRS-001    | The database shall preserve data integrity and consistency.                                                  | Sections 3.3 and 6                         | Direct                    | Partially Defined |
| DATABASE-SRS-002    | The database shall be normalized to reduce unnecessary redundancy.                                           | Section 6                                  | Direct                    | Partially Defined |
| DATABASE-SRS-003    | The database shall support concurrent access without data conflicts.                                         | Section 6                                  | Direct and Infrastructure | Partially Defined |
| ERROR-SRS-001       | The system shall return or display clear error information for invalid input and system failures.            | Sections 3.1, 5.2, and 5.4                 | Direct and Shared         | Partially Defined |
| ROBUSTNESS-SRS-001  | The system shall handle invalid input and unexpected actions without crashing under normal error conditions. | Section 5.4                                | Direct and Shared         | Partially Defined |
| RELIABILITY-SRS-001 | The system shall operate consistently and process medical and appointment data accurately.                   | Section 5.4                                | Direct and Infrastructure | Partially Defined |
| RELIABILITY-SRS-002 | In case of failure, the system shall recover with minimal data loss.                                         | Sections 5.2 and 5.4                       | Direct and Infrastructure | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* Field-level validation rules.
* Database normalization targets.
* Concurrency-control rules.
* Standard error-response structure.
* Error codes.
* Transaction boundaries.
* Recovery procedures.
* Permitted data-loss limits.

---

## 6. Logging, Monitoring, Traceability, and Auditability

| Baseline ID        | Requirement                                                                                              | SRS Source         | Backend Relevance         | Readiness         |
| ------------------ | -------------------------------------------------------------------------------------------------------- | ------------------ | ------------------------- | ----------------- |
| AUDIT-SRS-001      | Critical actions shall be logged for traceability and accountability.                                    | Section 5.2        | Direct                    | Partially Defined |
| AUDIT-SRS-002      | The system shall log login attempts, data updates, and administrative changes.                           | Sections 5.3 and 6 | Direct                    | Partially Defined |
| AUDIT-SRS-003      | Logs shall support monitoring, auditing, issue detection, and misuse detection.                          | Sections 5.3 and 6 | Direct and Operational    | Partially Defined |
| MONITORING-SRS-001 | The system shall maintain monitoring information needed to identify performance or operational problems. | Sections 5.3 and 6 | Direct and Infrastructure | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* The complete list of logged actions.
* Log fields.
* Log retention duration.
* Log-access permissions.
* Whether logs are immutable.
* Monitoring metrics.
* Alert conditions.
* Log-storage and rotation strategy.

---

## 7. Backup, Recovery, Retention, and Archiving

| Baseline ID       | Requirement                                                                                                          | SRS Source           | Backend Relevance         | Readiness                  |
| ----------------- | -------------------------------------------------------------------------------------------------------------------- | -------------------- | ------------------------- | -------------------------- |
| BACKUP-SRS-001    | The system shall implement backup and recovery mechanisms to prevent data loss.                                      | Sections 5.2 and 6   | Direct and Infrastructure | External Detail Unresolved |
| RETENTION-SRS-001 | Medical records and related system data shall be retained for a defined period according to organizational policies. | Section 6            | Direct and Organizational | External Detail Unresolved |
| ARCHIVE-SRS-001   | Archived data shall remain accessible to authorized users when needed.                                               | Section 6            | Direct                    | Partially Defined          |
| RECOVERY-SRS-001  | Appropriate recovery measures shall restore functionality after system failure.                                      | Sections 5.2 and 5.4 | Direct and Infrastructure | Partially Defined          |

### Definition Gaps

The SRS does not completely define:

* Backup frequency.
* Backup storage location.
* Backup encryption.
* Recovery procedures.
* Recovery-time objective.
* Recovery-point objective.
* Data-retention duration.
* Archive-selection rules.
* Archive retrieval behavior.

---

## 8. Maintainability, Modularity, Testability, and Future Expansion

| Baseline ID              | Requirement                                                                                                                           | SRS Source                 | Backend Relevance | Readiness         |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------- | -------------------------- | ----------------- | ----------------- |
| MAINTAINABILITY-SRS-001  | The system shall use a modular architecture that supports maintenance and extension with limited impact on existing functionality.    | Sections 2.1, 5.4, and 6   | Direct            | Partially Defined |
| REUSABILITY-SRS-001      | Components should support reuse in future development.                                                                                | Section 6                  | Direct            | Partially Defined |
| EXTENSIBILITY-SRS-001    | The system shall allow future departments, services, and features to be added without major redesign.                                 | Sections 2.1, 5.4, and 6   | Direct            | Partially Defined |
| TESTABILITY-SRS-001      | The system shall support unit, integration, and system testing.                                                                       | Section 5.4                | Direct and Shared | Clear             |
| TESTABILITY-SRS-002      | Components shall be sufficiently modular to permit independent testing.                                                               | Section 5.4                | Direct            | Partially Defined |
| INTEROPERABILITY-SRS-001 | The system shall interoperate with client applications and external services through REST APIs, JSON, and standard network protocols. | Sections 3.3, 3.4, and 5.4 | Direct and Shared | Clear             |

### Definition Gaps

The SRS does not completely define:

* The required architecture style beyond modularity.
* Module boundaries.
* Minimum automated-test coverage.
* Required test environments.
* External-service contract standards.
* Compatibility-version policies.

---

## 9. Localization and Internationalization

| Baseline ID          | Requirement                                                                                 | SRS Source | Backend Relevance | Readiness         |
| -------------------- | ------------------------------------------------------------------------------------------- | ---------- | ----------------- | ----------------- |
| LOCALIZATION-SRS-001 | The system shall support multiple languages, including Arabic and English where applicable. | Section 6  | Shared            | Partially Defined |
| LOCALIZATION-SRS-002 | Date, time, and number formats shall follow the selected locale.                            | Section 6  | Shared            | Partially Defined |

### Definition Gaps

The SRS does not completely define:

* The first-version supported languages.
* How users select a language.
* Whether translated content is stored in the Backend.
* Locale identifiers.
* Time-zone behavior.
* The authoritative storage format for dates and times.

---

## 10. External Services and Infrastructure Dependencies

| Baseline ID      | Dependency                                                                            | SRS Source                                               | Backend Relevance                    | Readiness                      |
| ---------------- | ------------------------------------------------------------------------------------- | -------------------------------------------------------- | ------------------------------------ | ------------------------------ |
| EXTERNAL-SRS-001 | The system depends on a payment gateway for online-payment processing.                | Sections 2.5, 2.7, 3.3, 3.4, and Appendix C — TBD-1      | Direct and External                  | External Dependency Unresolved |
| EXTERNAL-SRS-002 | The system depends on email or SMS services for notifications, reminders, and alerts. | Sections 2.1, 2.5, 2.7, 3.3, 3.4, and Appendix C — TBD-2 | Direct and External                  | External Dependency Unresolved |
| EXTERNAL-SRS-003 | The system may use external storage for medical images and reports when applicable.   | Section 2.1                                              | Direct, External, and Infrastructure | Partially Defined              |
| HOSTING-SRS-001  | The system depends on a stable and continuously available online hosting environment. | Sections 2.4, 2.7, 5.1, and Appendix C — TBD-3           | Infrastructure                       | External Detail Unresolved     |
| NETWORK-SRS-001  | Real-time system operation depends on network connectivity and server availability.   | Sections 2.4, 2.5, 2.7, 3.4, and 5.1                     | Infrastructure                       | Clear                          |

### Definition Gaps

The SRS does not completely define:

* The payment-gateway provider.
* The payment integration method.
* The email or SMS provider.
* Whether both email and SMS are required.
* The external-storage provider.
* Whether external medical-file storage will be used.
* Hosting-provider and server specifications.
* Infrastructure scaling configuration.

---

## 11. SRS TBD Registry Affecting the Backend

| TBD ID | SRS TBD Item                       | Backend Impact                                                                 | Current State |
| ------ | ---------------------------------- | ------------------------------------------------------------------------------ | ------------- |
| TBD-1  | Payment Gateway Details            | Online-payment implementation and transaction integration cannot be finalized. | Unresolved    |
| TBD-2  | Notification Service Provider      | Email and SMS integration cannot be finalized.                                 | Unresolved    |
| TBD-3  | Hosting Environment Specifications | Deployment architecture and server sizing cannot be finalized.                 | Unresolved    |
| TBD-4  | Data Retention Policy              | Retention periods and archival rules cannot be finalized.                      | Unresolved    |
| TBD-5  | Security Standards Compliance      | Final compliance controls and certifications cannot be finalized.              | Unresolved    |
| TBD-6  | Backup and Recovery Strategy       | Backup frequency, storage, and recovery procedures cannot be finalized.        | Unresolved    |
| TBD-7  | Reporting and Analytics Details    | Report structures, formats, metrics, and filters cannot be finalized.          | Unresolved    |

No value or provider has been selected for any of these TBD items during this extraction phase.

---

## 12. Backend Responsibility Boundary

The following SRS requirements are not primarily Backend implementation responsibilities:

* Flutter mobile-interface implementation.
* Android and iOS application compatibility.
* React web-interface implementation.
* Web-browser and desktop-interface compatibility.
* Visual layout, menus, tabs, charts, forms, and other interface-design details.
* PDF user manuals and interface tutorials.
* Physical end-user hardware support.

The Backend still has shared responsibility for:

* Providing the APIs required by mobile and web clients.
* Returning data and validation errors required by the user interfaces.
* Supporting role-based access for all client platforms.
* Supporting localization-related data where required.
* Providing secure and consistent communication to all clients.

---

## 13. Final Internal-SRS Consistency Findings

The following findings must be preserved for later analysis and must not be resolved by assumption:

1. The SRS gives a simultaneous-user target of `100–200` while also qualifying it with `or as defined by server capacity`. A final measurable target is not defined.
2. The SRS requires continuous availability while permitting scheduled maintenance, but it does not define an availability percentage or maximum maintenance duration.
3. The SRS requires password-strength rules but does not define the actual rules.
4. The SRS requires session expiration after inactivity but does not define the expiration duration.
5. The SRS requires backup and recovery while leaving the complete strategy as TBD-6.
6. The SRS requires data retention while leaving the retention period as TBD-4.
7. The SRS requires secure healthcare-data handling but leaves specific compliance standards as TBD-5.
8. The SRS requires reporting and analytics while leaving their exact structure and formats as TBD-7.
9. The SRS states that Apache will host the Laravel Backend, while detailed hosting specifications remain unresolved under TBD-3. These statements are compatible but incomplete.
10. The SRS describes external medical-file storage as optional through the wording `if applicable`; therefore, use of an external storage provider is not yet mandatory.
11. The SRS requires email or SMS integration but does not determine the provider or whether one or both channels must be implemented.
12. The SRS requires secure authentication through tokens or sessions but does not select the final mechanism.

---

## 14. Phase 1 Extraction Coverage Verification

### Functional Coverage Completed in Pass A

Pass A extracted:

* Product-scope Backend capabilities.
* Product functions.
* Actor responsibilities.
* System features.
* Functional Requirements FR-1 through FR-50.
* Functional Business Rules.
* Functional external-service requirements.
* Functional role-access rules.

### Nonfunctional Coverage Completed in Pass B

Pass B extracted:

* Section 2.4 — Operating Environment.
* Section 2.5 — Design and Implementation Constraints.
* Section 2.7 — Assumptions and Dependencies.
* Relevant Backend points from Section 3 — External Interface Requirements.
* Section 5.1 — Performance Requirements.
* Section 5.2 — Safety Requirements.
* Section 5.3 — Security Requirements.
* Section 5.4 — Software Quality Attributes.
* Section 6 — Other Requirements.
* Appendix C — To Be Determined List.

### SRS Sections Reviewed but Not Treated as Backend Requirements

The following sections were reviewed but do not directly add Backend implementation requirements:

* Document purpose, conventions, audience, and references.
* User-documentation deliverables.
* Hardware-interface descriptions that require no specialized Backend hardware.
* Frontend-only interface and platform details.
* Glossary definitions that repeat already extracted requirements.
* UML and analysis-model descriptions that are documentation artifacts rather than implementation requirements.

### Phase 1 Result

The Backend-related functional requirements, nonfunctional requirements, constraints, dependencies, and SRS TBD items have now been extracted into this file.

This baseline is ready for review before the existing Backend documentation is audited.

## Current Next Step

Review and approve the complete Phase 1 SRS-derived Backend baseline.

After approval, begin Phase 2 by auditing the existing Backend documentation against this baseline.

The audit must:

* Keep requirements supported by the SRS.
* Remove or correct active requirements that conflict with the SRS.
* Remove unsupported information from active requirements.
* Remove questions already answered by the SRS.
* Merge duplicate questions.
* Preserve only canonical questions not answered by the SRS.
