# Project Understanding Questions and Answers

## Purpose

This file is the canonical registry for Backend questions that are not answered by the SRS.

The historical file name is retained for continuity. Before the first working Backend version is delivered, this file records unanswered questions only and does not contain answers based on assumptions, previous discussions, or undocumented team decisions.

This file does not define:

* Confirmed requirements already documented in `BACKEND_ANALYSIS.md`.
* Database design.
* API design.
* Laravel classes or packages.
* Technical architecture.
* Implementation solutions.
* Preliminary functional decisions.
* Inferred answers.

## Authoritative Source

Until delivery of the first working Backend version:

* The SRS is the sole authoritative source for functional requirements.
* `BACKEND_ANALYSIS.md` is the authoritative SRS-derived Backend baseline.
* Existing documentation and previous discussions must not answer questions that the SRS leaves unresolved.

## Canonical Registry Rules

* Each unresolved topic must have one canonical question.
* Every canonical question must have a stable identifier.
* Duplicate and semantically equivalent questions are prohibited.
* A question must be removed when the SRS already provides its answer.
* Questions must be relevant to the Backend or affect a Backend requirement.
* Missing functional behavior must not be invented.
* Pure implementation choices belong in later technical-design documentation, not in this file.
* Temporary questions are first recorded in `notes/questions.md` and transferred here only after review.
* Questions are grouped by Backend module or cross-cutting concern rather than repeated under each role.
* A question may reference several roles or modules without being duplicated.

## Question Statuses

### Open Question — Not Answered by SRS

The SRS confirms a capability or requirement area but does not provide the functional detail required to complete its definition.

Before clarification, only the explicitly supported SRS behavior may be used.

### Deferred Implementation — Missing Required Detail or External Dependency

The SRS confirms the requirement, but the affected behavior or integration cannot be finalized until a provider, policy, organizational decision, infrastructure detail, or required functional value is selected.

The confirmed requirement remains active and must not be treated as removed.

## Legacy-Content Handling

The previous version of this file included:

* Team-confirmed answers not contained in the SRS.
* Logical interpretations.
* Preliminary examples.
* Proposed workflow statuses.
* Preliminary functional decisions.
* Duplicate questions.
* Questions already answered by the SRS.
* Questions based on unsupported features.

That content is not carried into the active canonical registry.

Important superseded decisions may be preserved separately in `DECISIONS.md` when historical traceability is necessary.

---

# 1. Authentication, Accounts, and Profiles

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-AUTH-001 | Open Question — Not Answered by SRS | What is the complete set of required Patient-registration fields, and which fields are mandatory? | PATIENT-ACCOUNT-SRS-001; PATIENT-ACCOUNT-SRS-002; VALIDATION-SRS-001 |
| Q-AUTH-002 | Open Question — Not Answered by SRS | What delivery and verification process must be used for password reset? | AUTH-SRS-004; SECURITY-SRS-007 |
| Q-AUTH-003 | Open Question — Not Answered by SRS | What password-strength rules, session-inactivity duration, and failed-login protection policy must the Backend enforce? | SECURITY-SRS-006; SECURITY-SRS-009 |
| Q-ACCOUNT-001 | Open Question — Not Answered by SRS | What does account revocation mean operationally, and what effects must revocation have on account access and existing data? | ACCOUNT-ADMIN-SRS-001; ACCOUNT-ADMIN-SRS-002 |
| Q-PROFILE-001 | Open Question — Not Answered by SRS | What profile fields exist for each role, and which fields may each role view or edit? | PROFILE-SRS-001; ROLE-SRS-001 through ROLE-SRS-005 |
| Q-PROFILE-002 | Open Question — Not Answered by SRS | Which Doctor-profile fields may Patients and other authorized users view? | DOCTOR-DIRECTORY-SRS-001; ROLE-SRS-005 |

---

# 2. Departments, Medical Services, and Doctor Information

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-DIRECTORY-001 | Open Question — Not Answered by SRS | What exact fields must be stored and displayed for departments, medical services, and Doctor profiles? | DIRECTORY-SRS-002; SERVICE-SRS-001; DOCTOR-DIRECTORY-SRS-001 |
| Q-DIRECTORY-003 | Open Question — Not Answered by SRS | What detailed administrative Doctor-management operations, if any, are required beyond Doctor-account creation, editing, and revocation? | DOCTOR-ADMIN-SRS-001; ACCOUNT-ADMIN-SRS-002 |

---

# 3. Patient Consultation Forms

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-CONSULTATION-001 | Open Question — Not Answered by SRS | What are the consultation form's purpose, required fields, recipient, workflow, statuses, and relationships to a Doctor, department, service, or appointment? | CONSULTATION-SRS-001 |

---

# 4. Appointments and Schedules

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-APPOINTMENT-001 | Open Question — Not Answered by SRS | Is Secretary confirmation or approval mandatory for every appointment booked by a Patient, or only in defined cases? | APPOINTMENT-SRS-009 |
| Q-APPOINTMENT-002 | Open Question — Not Answered by SRS | What are the final appointment statuses, permitted transitions, rescheduling behavior, and missed-appointment workflow? | APPOINTMENT-SRS-005; APPOINTMENT-SRS-008 |
| Q-APPOINTMENT-003 | Open Question — Not Answered by SRS | What are the final allowed periods for Patient appointment modification and cancellation? | APPOINTMENT-SRS-003; APPOINTMENT-SRS-004; APPOINTMENT-SRS-010; APPOINTMENT-SRS-011 |
| Q-APPOINTMENT-004 | Open Question — Not Answered by SRS | How is appointment duration determined, and what appointment-conflict rules must the Backend enforce? | APPOINTMENT-SRS-001; APPOINTMENT-SRS-002 |
| Q-APPOINTMENT-005 | Open Question — Not Answered by SRS | How must Doctor availability be calculated for appointment booking? | APPOINTMENT-SRS-002; DOCTOR-DIRECTORY-SRS-002 |
| Q-SCHEDULE-001 | Open Question — Not Answered by SRS | What schedule structure and department-schedule meaning and behavior are required? | SCHEDULE-SRS-001; SCHEDULE-SRS-002 |
| Q-SCHEDULE-002 | Open Question — Not Answered by SRS | What are the final schedule-management permission boundaries between Secretaries, the Super Administrator, and other administrative functions? | SCHEDULE-SRS-001 through SCHEDULE-SRS-003 |

The three-day period mentioned by the SRS is an example only and is not an answer to `Q-APPOINTMENT-003`.

---

# 5. Patient Medical Records

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-MEDICAL-RECORD-001 | Open Question — Not Answered by SRS | What is the complete medical-record structure, and what information is visible to the Patient? | MEDICAL-RECORD-SRS-001; MEDICAL-RECORD-SRS-012 |
| Q-MEDICAL-RECORD-002 | Open Question — Not Answered by SRS | What makes a Patient assigned to a Doctor, and when does Doctor access to that Patient's record begin and end? | MEDICAL-RECORD-SRS-002; MEDICAL-RECORD-SRS-003 |
| Q-MEDICAL-RECORD-003 | Open Question — Not Answered by SRS | Which medical-record sections may Doctors view or update, and which administrative sections may Secretaries view or modify? | MEDICAL-RECORD-SRS-004; MEDICAL-RECORD-SRS-006; ROLE-SRS-002; ROLE-SRS-003 |
| Q-MEDICAL-RECORD-004 | Open Question — Not Answered by SRS | Which Patient fields may be used to search for and match an existing medical record? | MEDICAL-RECORD-SRS-010 through MEDICAL-RECORD-SRS-013 |
| Q-MEDICAL-RECORD-005 | Open Question — Not Answered by SRS | What behavior is required when duplicate or potentially duplicate medical records are identified? | MEDICAL-RECORD-SRS-011 |
| Q-MEDICAL-RECORD-006 | Open Question — Not Answered by SRS | What exact event triggers creation of a new medical record? | MEDICAL-RECORD-SRS-005; MEDICAL-RECORD-SRS-014 through MEDICAL-RECORD-SRS-017 |
| Q-MEDICAL-RECORD-007 | Open Question — Not Answered by SRS | What are the archive-selection, archival-access, and archive-retrieval rules for medical records? | MEDICAL-RECORD-SRS-008; ARCHIVE-SRS-001 |

---

# 6. Treatment Plans, Instructions, Requests, and Referrals

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-TREATMENT-001 | Open Question — Not Answered by SRS | What are the treatment-plan fields, statuses, workflow, and relationship to appointments or medical visits? | TREATMENT-SRS-001 through TREATMENT-SRS-004 |
| Q-TREATMENT-002 | Open Question — Not Answered by SRS | What information and structure are required for medications, diet instructions, and other medical instructions? | TREATMENT-SRS-005 |
| Q-LAB-REQUEST-001 | Open Question — Not Answered by SRS | What fields, statuses, modification rules, and workflow are required for laboratory requests? | TREATMENT-SRS-005 |
| Q-RADIOLOGY-REQUEST-001 | Open Question — Not Answered by SRS | What fields, statuses, modification rules, and workflow are required for radiology requests? | TREATMENT-SRS-005 |
| Q-REFERRAL-001 | Open Question — Not Answered by SRS | What is the referral workflow, who receives a referral, what statuses apply, and how is a referral related to appointments and medical-record access? | REFERRAL-SRS-001 |
| Q-MEDICAL-UPDATE-001 | Open Question — Not Answered by SRS | How are medical updates shared with Patients, and which updates are included? | TREATMENT-SRS-006 |

---

# 7. Laboratory Results, Radiology Information, and Medical Files

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-RESULT-001 | Open Question — Not Answered by SRS | Must an uploaded laboratory or radiology result be linked to a previous request? | LAB-SRS-002; RADIOLOGY-SRS-002; RESULT-UPLOAD-SRS-001 |
| Q-RESULT-002 | Open Question — Not Answered by SRS | What fields, supported formats, storage representation, file-size limits, and multiple-file rules apply to laboratory results, radiology images, and radiology reports? | LAB-SRS-001; LAB-SRS-002; RADIOLOGY-SRS-001 through RADIOLOGY-SRS-003 |
| Q-RESULT-003 | Open Question — Not Answered by SRS | How are incorrectly uploaded results or files corrected, replaced, removed, or versioned? | LAB-SRS-002; RADIOLOGY-SRS-002; DATA-SRS-001 |
| Q-RESULT-004 | Open Question — Not Answered by SRS | What is the result-review workflow, which roles beyond the Patient may view laboratory results and radiology images, and which roles may access radiology reports? | LAB-SRS-001; RADIOLOGY-SRS-001 through RADIOLOGY-SRS-003; ROLE-SRS-005 |
| Q-FILE-STORAGE-001 | Deferred Implementation — Missing Required Detail or External Dependency | Will optional external storage be used for medical images and reports, and if so, what provider and storage boundary are required? | EXTERNAL-SRS-003 |

---

# 8. Payments

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-PAYMENT-001 | Deferred Implementation — Missing Required Detail or External Dependency | Which payment gateway and integration method will be used? | PAYMENT-SRS-001; EXTERNAL-SRS-001; TBD-1 |
| Q-PAYMENT-002 | Open Question — Not Answered by SRS | What payment methods and payment statuses must the system support? | PAYMENT-SRS-001 through PAYMENT-SRS-003 |
| Q-PAYMENT-003 | Open Question — Not Answered by SRS | What is the final payment-timing policy, and how is payment related to appointment confirmation and service completion? | PAYMENT-SRS-005; PAYMENT-SRS-006 |
| Q-PAYMENT-004 | Open Question — Not Answered by SRS | What handling beyond notification is required for failed payments, and what refund behavior is required? | PAYMENT-SRS-003 |
| Q-PAYMENT-005 | Open Question — Not Answered by SRS | What information must appear in Patient payment history? | PAYMENT-SRS-004 |

---

# 9. Notifications and Communication

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-NOTIFICATION-001 | Deferred Implementation — Missing Required Detail or External Dependency | Which notification provider will be used, and are email, SMS, or both required? | NOTIFICATION-SRS-005; EXTERNAL-SRS-002; TBD-2 |
| Q-NOTIFICATION-002 | Open Question — Not Answered by SRS | Which system events must generate notifications, and who receives each notification? | NOTIFICATION-SRS-001 through NOTIFICATION-SRS-004 |
| Q-NOTIFICATION-003 | Open Question — Not Answered by SRS | When must appointment reminders and other time-based notifications be sent? | NOTIFICATION-SRS-001 |
| Q-NOTIFICATION-004 | Open Question — Not Answered by SRS | Which delivery channel applies to each event, and are notification preferences and notification history required? | NOTIFICATION-SRS-003; NOTIFICATION-SRS-005 |
| Q-NOTIFICATION-005 | Open Question — Not Answered by SRS | What promotional-notification targeting behavior is required? | NOTIFICATION-SRS-004 |

---

# 10. Complaints

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-COMPLAINT-001 | Open Question — Not Answered by SRS | What fields, statuses, assignment rules, and administrative actions are required for complaints? | COMPLAINT-SRS-001 through COMPLAINT-SRS-004 |
| Q-COMPLAINT-002 | Open Question — Not Answered by SRS | Are complaint replies, attachments, closure, and deletion required, and what behavior applies to each? | COMPLAINT-SRS-003; COMPLAINT-SRS-004 |

---

# 11. Offers and Promotions

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-OFFER-001 | Open Question — Not Answered by SRS | What fields, eligibility rules, dates, discount behavior, and relationships with departments, services, Doctors, or Patients are required for offers? | OFFER-SRS-001 through OFFER-SRS-003 |
| Q-OFFER-002 | Open Question — Not Answered by SRS | What publication and notification behavior is required for offers and promotions? | OFFER-SRS-001 through OFFER-SRS-003; NOTIFICATION-SRS-004 |

---

# 12. Administration, Policies, Reports, and Analytics

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-ADMIN-001 | Open Question — Not Answered by SRS | What is the exact scope of Super Administrator full access when compared with restrictions on clinical medical-data modification? | ADMIN-SRS-002; ROLE-SRS-004; SAFETY-SRS-001 |
| Q-ADMIN-002 | Open Question — Not Answered by SRS | How must general SRS terms such as administrator, administrators, and administrative functions be mapped to the named system roles? | COMPLAINT-SRS-002 through COMPLAINT-SRS-004; OFFER-SRS-001; POLICY-SRS-001; ADMIN-SRS-001 |
| Q-POLICY-001 | Open Question — Not Answered by SRS | Which appointment-cancellation and other system policies are configurable? | POLICY-SRS-001; POLICY-SRS-002 |
| Q-REPORT-001 | Deferred Implementation — Missing Required Detail or External Dependency | What report types, filters, formats, and access restrictions are required? | REPORT-SRS-001; TBD-7 |
| Q-ANALYTICS-001 | Deferred Implementation — Missing Required Detail or External Dependency | What analytics, statistics, and dashboard metrics are required? | ANALYTICS-SRS-001; TBD-7 |

---

# 13. Security, Privacy, Auditability, and Monitoring

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-SECURITY-001 | Deferred Implementation — Missing Required Detail or External Dependency | Which healthcare, privacy, and security compliance framework must the project follow? | PRIVACY-SRS-003; TBD-5 |
| Q-SECURITY-002 | Open Question — Not Answered by SRS | What complete role and field-level permission matrix must the Backend enforce? | SECURITY-SRS-002; SECURITY-SRS-003; ROLE-SRS-001 through ROLE-SRS-005 |
| Q-SECURITY-003 | Open Question — Not Answered by SRS | Which operations are critical actions, and what confirmation or re-authentication behavior is required for each? | SAFETY-SRS-003; SECURITY-SRS-010 |
| Q-PRIVACY-001 | Open Question — Not Answered by SRS | What privacy-consent and sensitive-data-masking rules are required? | PRIVACY-SRS-001 through PRIVACY-SRS-003 |
| Q-AUDIT-001 | Open Question — Not Answered by SRS | What actions must be logged, what information must each log contain, who may access logs, are logs immutable, and how long must they be retained? | AUDIT-SRS-001 through AUDIT-SRS-003 |
| Q-MONITORING-001 | Open Question — Not Answered by SRS | What operational and performance information must be monitored, and what conditions require alerts? | MONITORING-SRS-001 |

---

# 14. Infrastructure, Retention, Recovery, Performance, and Localization

| Question ID | Status | Canonical Question | Related Baseline IDs |
| --- | --- | --- | --- |
| Q-HOSTING-001 | Deferred Implementation — Missing Required Detail or External Dependency | What hosting provider, server specifications, server operating system, and deployment constraints will be used for the Apache-hosted Backend? | TECH-SRS-006; HOSTING-SRS-001; TBD-3 |
| Q-RETENTION-001 | Deferred Implementation — Missing Required Detail or External Dependency | What data-retention periods and organizational archival rules must be enforced? | RETENTION-SRS-001; ARCHIVE-SRS-001; TBD-4 |
| Q-BACKUP-001 | Deferred Implementation — Missing Required Detail or External Dependency | What backup frequency, storage, protection, recovery process, recovery-time objective, and recovery-point objective are required? | BACKUP-SRS-001; RECOVERY-SRS-001; TBD-6 |
| Q-PERFORMANCE-001 | Open Question — Not Answered by SRS | What final concurrent-user target, request-rate target, representative data volume, performance-test environment, acceptance-test method, permitted scheduled downtime, database-operation benchmark, bandwidth target, and network-latency limit must be used? | PERF-SRS-004 through PERF-SRS-010; AVAILABILITY-SRS-001; AVAILABILITY-SRS-002; SCALABILITY-SRS-001; SCALABILITY-SRS-002 |
| Q-LOCALIZATION-001 | Open Question — Not Answered by SRS | What exact first-version language scope is required, how is locale selected, and what time-zone, date, time, and number-format rules must the Backend follow? | LOCALIZATION-SRS-001; LOCALIZATION-SRS-002 |

The response-time targets already documented under `PERF-SRS-001`, `PERF-SRS-002`, `PERF-SRS-003`, and `PERF-SRS-009` remain confirmed and are not reopened by `Q-PERFORMANCE-001`.

---

# Canonical Registry Summary

This registry contains only questions not answered by the SRS and required for later Backend clarification.

Until a question is answered through an approved project source:

* The question remains unresolved.
* No answer may be invented.
* Only the explicit SRS-supported portion of the related requirement may be implemented.
* An externally dependent or policy-dependent detail remains deferred when correct implementation cannot be completed without it.
* The same question must not be recorded again in another file.

## Temporary Intake Queue

`notes/questions.md` remains the temporary intake queue.

At the time of this rebuild, no temporary questions are waiting for review.

## Current Status

Phase 2 documentation audit has rebuilt:

* `PROJECT_2_CONTEXT.md`.
* `BACKEND_MODULES.md`.
* `USER_ROLES.md`.
* `BUSINESS_RULES.md`.
* `PROJECT_UNDERSTANDING_QA.md`.

The next step is to review the remaining active documentation files against `BACKEND_ANALYSIS.md` and determine whether Phase 2 can be closed.
