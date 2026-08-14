# Development Plan

## Current Objective

Begin Phase 6 and implement the approved immediate first-version Backend scope as quickly as possible.

Implementation must use:

* The authoritative SRS-derived baseline.
* The approved Phase 4 immediate scope.
* The adopted Phase 5 technical and architectural decisions.
* Bounded Codex implementation tasks.
* Required automated tests.
* Chat review before an implementation task is treated as complete.

No unresolved functional question may be answered through implementation assumption.

## Core Working Principles

* The SRS is the sole authoritative source for functional requirements before delivery of the first working version.
* All clear and implementable Backend requirements contained in the SRS must be included in the implementation plan.
* Missing functional details must not be invented.
* Questions answered by the SRS must not remain Open Questions.
* Questions must not be duplicated, even when different wording is used.
* Existing documentation that conflicts with the SRS must be corrected.
* Existing information not supported by the SRS must not remain an active implementation requirement.
* Questions not answered by the SRS will be preserved for later discussion with the project team.
* Documentation must be updated before related implementation tasks are sent to Codex.

## Phase Status Summary

* **Phase 0 — Document the Working Policy:** Completed.
* **Phase 1 — Extract the Backend Requirements Baseline from the SRS:** Completed.
* **Phase 2 — Audit the Existing Documentation:** Completed.
* **Phase 3 — Build the Canonical Open-Questions List:** Completed as part of the documentation audit.
* **Phase 4 — Determine the First-Version Implementation Plan:** Completed.
* **Phase 5 — Define Technical and Architecture Decisions:** Completed.
* **Phase 6 — Implement the Backend:** Next.
* **Phase 7 — Post-First-Version Team Clarification:** Not started.

## Phase 0 — Document the Working Policy

### Goal

Document the agreed source policy, documentation rules, question-management rules, and responsibilities of Chat, Work, and Codex.

### Outputs

* Updated project context.
* Updated development plan.
* Documented project decisions.
* Defined Backend-analysis structure.
* Updated development log after the policy is approved.

## Phase 1 — Extract the Backend Requirements Baseline from the SRS

### Goal

Extract every Backend-related functional and nonfunctional requirement from the SRS.

### Activities

* Review all SRS sections, not only the Functional Requirements section.
* Extract Backend requirements from:
  * Product functions.
  * User-role descriptions.
  * System features.
  * Functional requirements.
  * Business Rules.
  * Security requirements.
  * Performance requirements.
  * Data and integration requirements.
  * Assumptions, dependencies, and TBD items.
* Preserve the original SRS requirement identifier or section reference whenever available.
* Classify each requirement under the appropriate Backend module or concern.

### Output

A complete SRS-derived Backend requirements baseline in BACKEND_ANALYSIS.md.

## Phase 2 — Audit the Existing Documentation

### Goal

Compare all active Backend documentation with the SRS-derived baseline.

### Activities

For every documented statement or question, determine whether it is:

* Supported by the SRS.
* A duplicate.
* In conflict with the SRS.
* Not supported by the SRS.
* A question already answered by the SRS.
* A question not answered by the SRS.
* Not a Backend requirement.

### Rules

* Keep information supported by the SRS.
* Remove duplicate information where duplication has no documentation purpose.
* Replace conflicting active requirements with the corresponding SRS requirement.
* Remove unsupported information from active implementation requirements.
* Remove questions answered by the SRS.
* Preserve unanswered questions without inventing answers.

## Phase 3 — Build the Canonical Open-Questions List

### Goal

Create one non-duplicated list of questions not answered by the SRS.

### Rules

* Every question must have one canonical record.
* Questions with the same meaning must be merged.
* Every question should have a stable identifier.
* Questions must be grouped by Backend module or concern.
* Questions must identify the SRS sections and documentation sources already checked.
* An unverified user note may accompany a question only when it preserves useful context for later team discussion.
* Unverified notes must be clearly marked as not approved for implementation.
* Questions will be reviewed with the project team after delivery of the first working version.

### Canonical Location

PROJECT_UNDERSTANDING_QA.md is the authoritative location for project-understanding questions.

notes/questions.md may be used only as a temporary intake queue during analysis.

## Phase 4 — Determine the First-Version Implementation Plan

### Goal

Transform the clear SRS-derived Backend requirements into an ordered implementation plan.

### Rules

* Include every clear and implementable Backend requirement from the SRS.
* Do not limit the final implementation scope to one end-to-end flow.
* Use end-to-end flows only to determine implementation and testing order.
* Identify requirements that cannot yet be implemented because of:
  * Missing required SRS details.
  * Unknown external providers.
  * Unknown integration details.
  * A requirement that is outside Backend responsibility.
* Record deferred implementation without deleting the original SRS requirement.

### Outputs

* Ordered Backend modules.
* Implementation dependencies.
* First working flow.
* Complete first-version scope.
* Deferred implementation list.
* Success and testing criteria.

### Planning Basis

The first-version implementation plan is based on:

* The confirmed SRS requirements in `BACKEND_ANALYSIS.md`.
* The functional module catalog in `BACKEND_MODULES.md`.
* The confirmed Business Rules in `BUSINESS_RULES.md`.
* The role capabilities and restrictions in `USER_ROLES.md`.
* The unresolved questions and deferred items in `PROJECT_UNDERSTANDING_QA.md`.

A requirement is included in the immediate implementation scope only when enough functional behavior is defined to implement it without inventing fields, workflow rules, permissions, policy values, or external-service behavior.

A partially defined or deferred requirement remains active in the SRS-derived scope and must not be treated as removed.

### Scope Categories

Phase 4 uses the following planning categories:

* **Immediate Implementation:** The SRS defines enough behavior to begin implementation after the required Phase 5 technical decisions are approved.
* **Partial Implementation:** A confirmed portion can be implemented without assuming the unresolved portion.
* **Deferred Functional Implementation:** Correct implementation requires a missing functional definition recorded in `PROJECT_UNDERSTANDING_QA.md`.
* **Deferred External or Organizational Implementation:** Correct implementation depends on an unresolved provider, infrastructure detail, organizational policy, compliance standard, or strategy.
* **Not a Backend Implementation Responsibility:** The requirement belongs mainly to client applications, user-interface work, documentation, hardware, or another project responsibility.

---

### First Working End-to-End Flow

The first working Backend flow will demonstrate the confirmed authentication, account-administration, authorization, and read-only directory capabilities.

The flow will be:

1. An existing Super Administrator account authenticates using valid credentials.
2. Invalid authentication attempts are rejected.
3. The authenticated Super Administrator creates Doctor and Secretary accounts using only approved account information.
4. The created Doctor and Secretary accounts can authenticate.
5. Protected functionality applies role-based authorization.
6. Unauthorized role access is rejected.
7. Authenticated users can change their passwords.
8. Authenticated users can log out securely.
9. A Patient test account can authenticate and access the confirmed read-only medical-center directory capabilities.
10. The Patient can view departments, medical services, service costs, Doctor lists, Doctor profiles, and Doctor schedules or working hours using only the minimum SRS-supported representation.
11. Required validation, clear error handling, security controls, and audit logging are verified across the flow.

The creation or provisioning of the initial Super Administrator account and test accounts is a Phase 5 technical setup decision and is not a new functional requirement.

This first working flow determines development order only. It does not define the complete Backend functional scope.

---

### Ordered Implementation Waves

#### Wave 1 — Backend Foundation and Cross-Cutting Enforcement

Prepare the Backend foundation required by all later functionality.

The implementation must support the confirmed constraints and cross-cutting requirements for:

* Laravel and PHP.
* MariaDB.
* RESTful client communication.
* JSON request and response data.
* Secure HTTP/HTTPS communication boundaries.
* Authentication for protected functionality.
* Role-based authorization.
* Hashed password storage.
* Input validation.
* Clear error handling.
* Protection against unauthorized access and modification.
* Logging of login attempts, data updates, administrative changes, and other confirmed critical actions.
* Modular and independently testable components.
* Unit, integration, and system testing.

Laravel version, PHP version, MariaDB version, authentication mechanism, API conventions, error-response format, architecture structure, and testing tools remain Phase 5 technical decisions.

#### Wave 2 — Authentication and Role Authorization Core

Implement the confirmed authentication core:

* Login using valid credentials.
* Rejection of invalid login attempts.
* Secure logout.
* Password change for authenticated users.
* Authentication protection for protected functionality.
* Role-based authorization for Patient, Doctor, Secretary, and Super Administrator.
* Enforcement that users access only data and functions permitted to their roles.
* Enforcement of Patient ownership boundaries for personal data, appointments, and medical records where those resources are later implemented.
* Enforcement of Doctor access restrictions for assigned Patient medical records where medical records are later implemented.
* Enforcement of Secretary restrictions against modifying diagnoses and treatment plans where those resources are later implemented.

The following authentication features remain deferred or partially defined:

* Complete Patient registration because `Q-AUTH-001` is unresolved.
* Password-reset delivery and verification because `Q-AUTH-002` is unresolved.
* Final password-strength values, session-inactivity duration, and failed-login protection because `Q-AUTH-003` is unresolved.
* Final operational behavior of account revocation because `Q-ACCOUNT-001` is unresolved.

#### Wave 3 — Doctor and Secretary Account Administration

Implement the confirmed Super Administrator account-management behavior that does not depend on unresolved profile definitions:

* Creation of Doctor accounts.
* Editing of Doctor accounts.
* Creation of Secretary accounts.
* Editing of Secretary accounts.
* Restriction of these operations to the Super Administrator role.

Account revocation must remain incomplete until the operational meaning and effects recorded in `Q-ACCOUNT-001` are clarified.

Professional-profile fields and complete profile-editing behavior remain deferred under `Q-PROFILE-001` and `Q-PROFILE-002`.

#### Wave 4 — Read-Only Medical-Center Directory

Implement the confirmed Patient-facing read-only directory capabilities:

* Viewing medical departments.
* Viewing medical services.
* Viewing medical-service costs.
* Viewing department information.
* Viewing Doctor lists.
* Viewing Doctor profiles.
* Viewing Doctor schedules and working hours.

The implementation must use only the minimum representation necessary for the confirmed SRS concepts.

Additional department, service, or Doctor-profile fields must not be invented.

The following remain deferred:

* Complete department, service, and Doctor-profile field definitions under `Q-DIRECTORY-001`.
* Detailed administrative Doctor-management behavior under `Q-DIRECTORY-003`.
* Any unsupported department or service activation, deletion, archival, search, ordering, or price-history behavior.

#### Wave 5 — First-Version Verification and Hardening

Verify the first working flow and the complete immediate scope.

This wave must include:

* Positive and negative authentication tests.
* Authorization tests for all four roles.
* Tests proving that unauthorized role access is rejected.
* Tests for Super Administrator Doctor and Secretary account creation and editing.
* Tests for password change and logout.
* Tests for read-only directory access.
* Input-validation and error-handling tests.
* Tests for required audit-log generation.
* Security verification for the confirmed protection requirements.
* Verification that no unresolved functional behavior has been introduced.
* Recording of performance measurements for confirmed response-time targets without claiming final acceptance until the unresolved performance-test conditions are defined.

---

### Complete Immediate First-Version Scope

The immediate first-version Backend scope includes:

#### Authentication and Access Control

* Login.
* Invalid-login rejection.
* Logout.
* Authenticated password change.
* Protected functionality.
* Role-based authorization.
* Role-based data and function restrictions.
* Hashed password storage.
* Protection of sensitive information.
* Prevention of unauthorized modification and deletion.

#### Staff Account Administration

* Super Administrator creation of Doctor accounts.
* Super Administrator editing of Doctor accounts.
* Super Administrator creation of Secretary accounts.
* Super Administrator editing of Secretary accounts.

#### Read-Only Directory

* Department listing and viewing.
* Medical-service listing and viewing.
* Medical-service cost viewing.
* Doctor listing and profile viewing.
* Doctor schedule and working-hour viewing.

#### Cross-Cutting Requirements

* Input validation where the required fields are defined.
* Clear error responses.
* Data integrity and consistency controls.
* Logging of confirmed action categories.
* Robust handling of invalid input.
* Modular and testable implementation.
* Unit, integration, and system tests.
* REST and JSON interoperability with client applications.

---

### Partially Implementable Requirements

The following capabilities contain confirmed behavior but cannot be completed fully:

* Session-expiration support, because the inactivity duration is unresolved.
* Password-strength enforcement, because the final rules are unresolved.
* Account revocation, because its operational effects are unresolved.
* User-profile editing, because role-specific fields and permissions are unresolved.
* Department, service, and Doctor-profile display, because complete field sets are unresolved.
* Performance verification, because the final load, environment, and acceptance method are unresolved.
* Logging and monitoring, because the complete action list, fields, access rules, retention, and alert conditions are unresolved.
* Localization, because the first-version language and locale behavior are unresolved.
* Archive access, because archive-selection and retrieval rules are unresolved.

Only the explicitly supported portion may be implemented.

---

### Deferred Functional Implementation

The following modules or capabilities remain active requirements but are deferred because required functional definitions are missing:

#### Patient Registration and Profiles

Related questions:

* `Q-AUTH-001`
* `Q-PROFILE-001`
* `Q-PROFILE-002`

#### Password Reset and Final Authentication Policies

Related questions:

* `Q-AUTH-002`
* `Q-AUTH-003`
* `Q-ACCOUNT-001`

#### Consultation Forms

Related question:

* `Q-CONSULTATION-001`

#### Appointment and Schedule Management

Related questions:

* `Q-APPOINTMENT-001`
* `Q-APPOINTMENT-002`
* `Q-APPOINTMENT-003`
* `Q-APPOINTMENT-004`
* `Q-APPOINTMENT-005`
* `Q-SCHEDULE-001`
* `Q-SCHEDULE-002`

Appointment booking, modification, cancellation, availability calculation, schedule management, and daily tracking must not be implemented using invented durations, statuses, conflicts, approval behavior, or scheduling rules.

#### Patient Medical Records

Related questions:

* `Q-MEDICAL-RECORD-001`
* `Q-MEDICAL-RECORD-002`
* `Q-MEDICAL-RECORD-003`
* `Q-MEDICAL-RECORD-004`
* `Q-MEDICAL-RECORD-005`
* `Q-MEDICAL-RECORD-006`
* `Q-MEDICAL-RECORD-007`

Medical-record creation, searching, access, updating, and archival must not be completed using invented record structures, matching rules, assignment rules, or role boundaries.

#### Treatment Plans, Instructions, Requests, and Referrals

Related questions:

* `Q-TREATMENT-001`
* `Q-TREATMENT-002`
* `Q-LAB-REQUEST-001`
* `Q-RADIOLOGY-REQUEST-001`
* `Q-REFERRAL-001`
* `Q-MEDICAL-UPDATE-001`

#### Laboratory Results, Radiology Information, and Medical Files

Related questions:

* `Q-RESULT-001`
* `Q-RESULT-002`
* `Q-RESULT-003`
* `Q-RESULT-004`

#### Payment Behavior Not Dependent Solely on the Gateway

Related questions:

* `Q-PAYMENT-002`
* `Q-PAYMENT-003`
* `Q-PAYMENT-004`
* `Q-PAYMENT-005`

#### Notification Events and In-System Behavior

Related questions:

* `Q-NOTIFICATION-002`
* `Q-NOTIFICATION-003`
* `Q-NOTIFICATION-004`
* `Q-NOTIFICATION-005`

#### Complaint Management

Related questions:

* `Q-COMPLAINT-001`
* `Q-COMPLAINT-002`

#### Offer and Promotion Management

Related questions:

* `Q-OFFER-001`
* `Q-OFFER-002`

#### Administration and Policy Details

Related questions:

* `Q-ADMIN-001`
* `Q-ADMIN-002`
* `Q-POLICY-001`
* `Q-SECURITY-002`
* `Q-SECURITY-003`
* `Q-PRIVACY-001`
* `Q-AUDIT-001`
* `Q-MONITORING-001`
* `Q-PERFORMANCE-001`
* `Q-LOCALIZATION-001`

---

### Deferred External or Organizational Implementation

The following requirements remain confirmed but cannot be finalized because of unresolved external or organizational dependencies:

* Online-payment gateway integration — `Q-PAYMENT-001` and TBD-1.
* Email or SMS notification-service integration — `Q-NOTIFICATION-001` and TBD-2.
* Hosting environment and deployment constraints — `Q-HOSTING-001` and TBD-3.
* Data-retention periods and organizational archival policy — `Q-RETENTION-001` and TBD-4.
* Healthcare, privacy, and security compliance framework — `Q-SECURITY-001` and TBD-5.
* Backup and recovery strategy — `Q-BACKUP-001` and TBD-6.
* Report and analytics definitions — `Q-REPORT-001`, `Q-ANALYTICS-001`, and TBD-7.
* Optional external medical-file storage — `Q-FILE-STORAGE-001`.

Deferral does not remove these requirements from the SRS-derived Backend scope.

---

### Implementation Dependencies

The implementation order depends on the following relationships:

* Authentication and authorization are prerequisites for all protected modules.
* Staff account administration depends on authentication and Super Administrator authorization.
* Patient ownership enforcement depends on authentication and resource ownership information.
* Doctor medical-record authorization depends on a defined Patient-assignment rule.
* Appointment booking depends on Doctor directory data, schedule definitions, availability calculation, duration, and conflict rules.
* Medical-record access depends on role boundaries, record structure, and Patient-assignment definitions.
* Treatment plans depend on medical-record and clinical-access definitions.
* Laboratory and radiology results depend on file definitions, access rules, and request-linking behavior.
* Payment integration depends on the payment provider, payment statuses, and timing policy.
* Notification delivery depends on defined events, recipients, timing, channels, and provider.
* Reports and analytics depend on completed domain modules and TBD-7 definitions.
* Backup, retention, deployment, and compliance work depend on their respective external or organizational decisions.

---

### First-Version Success Criteria

The first working Backend version is successful when:

* The approved immediate scope is implemented without adding unsupported functional behavior.
* Valid users can authenticate.
* Invalid login attempts are rejected.
* Authenticated users can change passwords and log out.
* Role-based authorization is enforced for Patient, Doctor, Secretary, and Super Administrator.
* Unauthorized role access is rejected.
* The Super Administrator can create and edit Doctor and Secretary accounts.
* Patients can access the approved read-only directory information.
* Sensitive information and protected functionality are secured according to the confirmed rules.
* Required validation and clear error handling operate correctly.
* Required login, data-update, and administrative-change events are logged.
* Unit, integration, and system tests for the immediate scope pass.
* The implementation remains modular and ready for later expansion.
* Every deferred requirement remains documented and traceable.
* No Open Question is answered by assumption.

---

### Testing and Verification Criteria

Testing must verify:

* Successful and failed login behavior.
* Logout behavior.
* Authenticated password change.
* Protected-function access.
* Role-based authorization.
* Rejection of unauthorized access.
* Super Administrator account-management restrictions.
* Doctor and Secretary account creation and editing.
* Patient ownership restrictions where applicable.
* Directory listing and viewing behavior.
* Validation of every implemented input.
* Clear error behavior for invalid input and system failures.
* Required audit-log generation.
* Protection against the confirmed common web threats.
* Data integrity during concurrent operations within the implemented scope.
* REST and JSON compatibility.
* Unit, integration, and system test support.
* Confirmed response-time targets where the test environment permits measurement.

Final performance acceptance must remain pending until `Q-PERFORMANCE-001` is resolved.

---

### Phase 4 Completion Conditions

Phase 4 is complete when:

* This implementation plan is reviewed and approved.
* The immediate scope is confirmed.
* The first working end-to-end flow is confirmed.
* Functional deferrals are confirmed.
* External and organizational deferrals are confirmed.
* Success and testing criteria are confirmed.
* No technical or architecture decision has been selected prematurely.

After approval, `DEVELOPMENT_LOG.md` must record Phase 4 completion.

Phase 5 may then define only the technical and architectural decisions required for the approved immediate implementation scope.

## Phase 5 — Define Technical and Architecture Decisions

### Goal

Define only the technical decisions required to implement the approved SRS-based scope.

### Activities

* Laravel project structure.
* Authentication mechanism.
* Role-based authorization.
* Database design.
* API conventions.
* Validation and error-response conventions.
* File-storage strategy.
* Testing strategy.
* Required external-service boundaries.

### Documentation

Technical decisions must be stored in BACKEND_DESIGN_DECISIONS.md and the related technical documentation files.

Technical decisions must not introduce new functional requirements.

## Phase 6 — Implement the Backend

### Working Cycle

Phase 6 uses an accelerated sequential implementation workflow to minimize delivery time while preserving the approved scope, technical baseline, verification requirements, and SRS-only policy.

1. Chat defines and approves the ordered Phase 6 implementation queue before execution.
2. Multiple already-approved bounded implementation tasks may be delivered to Codex through one master execution task.
3. Each task inside the master execution task remains an independent bounded subtask with its own implementation scope, exclusions, tests, verification gate, and documentation closeout.
4. Codex must execute the subtasks strictly in the approved dependency order.
5. Codex may continue automatically from one subtask to the next only after the current subtask's required tests and quality checks pass.
6. Routine implementation corrections, test corrections, formatting fixes, and compatible security dependency corrections may be completed automatically when they remain fully inside the approved technical and functional scope.
7. After each successfully completed subtask, Codex must append the required completion record to `DEVELOPMENT_LOG.md` before continuing.
8. Other documentation files may be modified only when the master task explicitly authorizes the exact file and change.
9. Codex must stop before continuing if implementation requires:
   * A functional requirement not explicitly supported by the SRS-derived baseline.
   * An answer to an unresolved item in `PROJECT_UNDERSTANDING_QA.md`.
   * A new field, permission, workflow, status, Business Rule, provider, or policy.
   * A new database relationship or API behavior not already approved.
   * A change to an approved Phase 5 technical or architecture decision.
   * Implementation of a deferred requirement.
   * Any genuinely new technical decision that cannot be resolved from the approved documentation.
10. A stopped master execution task must report the blocking decision without inventing a workaround or assumption.
11. Codex must not create commits, push changes, merge branches, create branches, or create Pull Requests unless explicitly authorized in a separate instruction.
12. Chat reviews the resulting implementation, verification evidence, documentation changes, and Git diff before the changes are committed.
13. The SRS remains the sole authoritative source for functional requirements until delivery of the first working Backend version.

## Phase 7 — Post-First-Version Team Clarification

### Goal

Review all unresolved SRS questions with the project team after delivery of the first working version.

### Activities

* Present the canonical Open Questions to the team.
* Record confirmed answers.
* Identify changes to the original SRS requirements.
* Update the documentation.
* Revisit deferred implementation.
* Plan the next project version.

## Current Next Step

Phase 6 Tasks 2 through 6 and the approved consolidated coding-style, architecture-alignment, cleanup, Postman, testing, and documentation refactor are complete.

The implemented first-version Backend retains exactly `23` approved API routes, uses complete collection responses for the current Patient directory lists, and runs automated database tests against the dedicated MariaDB database `alamal_medical_center_testing`.

The next step is final team review of the implementation, verification evidence, documentation, Postman collection, and Git diff before any separately authorized commit or push.

No unresolved functional question was answered through implementation assumption, and deferred functionality remains unimplemented.
