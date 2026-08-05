# PROJECT_2_CONTEXT.md

# Project 2 - Al Amal Medical Center Management System (AMC-MS)

## Project Information

* Course: Project 2
* University: Damascus University
* Faculty: Faculty of Information Technology Engineering
* Department: Software Engineering and Information Systems
* Academic Year: 2025-2026
* Expected Delivery Date: Mid August 2026

---

# Team Information

## Team Members

The project is developed by a team of four students.

### Aws Alsaad

Role:

* Backend Developer
* Responsible for the entire backend system
* Responsible for database design
* Responsible for REST API development
* Responsible for authentication and authorization
* Responsible for business logic implementation

Technologies:

* Laravel
* PHP
* MySQL

### Other Team Members

#### Mobile Team

* Flutter Application Development

#### Web Team

* Web Application Development

---

# Project Overview

Project Name:

Al Amal Medical Center Management System (AMC-MS)

Project Type:

Medical Center Management System

Project Goal:

Develop a complete healthcare management platform that digitizes and automates the administrative and medical operations of Al Amal Medical Center.

The system aims to:

* Improve patient experience.
* Reduce manual paperwork.
* Improve appointment management.
* Organize medical records digitally.
* Facilitate communication between patients and doctors.
* Improve administrative efficiency.
* Provide centralized healthcare information management.

---

# System Architecture

Frontend:

* Flutter Mobile Application
* React Web Application

Backend:

* Laravel REST API

Database:

* MySQL

Communication:

* JSON
* REST APIs
* HTTPS

---

# Main User Roles

## Patient

Main Features:

* Register account
* Login / Logout
* Edit profile
* Browse departments
* Browse services
* View doctors
* View doctor information
* View doctor schedules
* Book appointments
* Edit appointments
* Cancel appointments
* Receive appointment reminders
* View medical records
* View treatment plans
* View laboratory results
* View radiology results
* Receive notifications
* View offers and promotions
* Submit complaints
* Make payments

---

## Doctor

Main Features:

* Login
* View dashboard
* Manage profile
* View work schedule
* View daily appointments
* Access patient records
* Update medical records
* Create treatment plans
* Add medications
* Add diet instructions
* Add laboratory requests
* Add radiology requests
* Add medical instructions
* Refer patients to other departments
* Receive notifications

---

## Secretary

Main Features:

* Login
* View dashboard
* Manage appointments
* Create appointments
* Edit appointments
* Cancel appointments
* Manage patient records
* Create medical records
* Search medical records
* Upload laboratory results
* Upload radiology images
* View doctor schedules
* Manage daily operations

---

## Super Administrator

Main Features:

* Login
* Manage doctor accounts
* Manage secretary accounts
* Create accounts
* Edit accounts
* Revoke accounts
* View schedules
* View appointments
* Manage offers
* Manage complaints
* Generate reports
* View analytics
* Configure cancellation policies

---

# Functional Modules

## Authentication Module

Features:

* Login
* Logout
* Password Reset
* Password Change
* Profile Management

---

## Department Management Module

Features:

* Manage departments
* View department information
* View services

---

## Doctor Management Module

Features:

* Doctor profiles
* Doctor schedules
* Doctor availability

---

## Appointment Management Module

Features:

* Appointment booking
* Appointment editing
* Appointment cancellation
* Appointment approval
* Appointment reminders

Business Rule:

Patients may only edit or cancel appointments before a predefined period (currently planned as 3 days).

---

## Medical Records Module

Features:

* Create medical records
* View medical records
* Update medical records
* Archive records

---

## Treatment Plans Module

Features:

* Medications
* Diet plans
* Laboratory requests
* Radiology requests
* Medical instructions

---

## Laboratory Module

Features:

* Upload test results
* View test results

---

## Radiology Module

Features:

* Upload radiology images
* View radiology reports

---

## Notification Module

Features:

* Appointment reminders
* System notifications
* Promotions and offers

---

## Complaint Management Module

Features:

* Submit complaints
* Review complaints
* Resolve complaints

---

## Payment Module

Features:

* Online payment
* Payment confirmation
* Payment history

Note:
Payment gateway has not been finalized yet.

---

## Reporting Module

Features:

* Administrative reports
* Statistics
* Analytics

---

# Backend Responsibilities

The backend system must provide:

* RESTful APIs
* Authentication APIs
* Authorization and Roles
* Database Management
* Business Logic
* File Upload Management
* Notifications Management
* Reporting APIs

---

# Current Known Technologies

Backend:

* Laravel

Database:

* MySQL

Authentication:

* Laravel Sanctum (preferred candidate)

API Format:

* JSON

Version Control:

* Git / GitHub

---

# Known Open Questions

The following points still need clarification from the team:

1. Referral workflow between departments.
2. Exact secretary permissions.
3. Final payment gateway provider.
4. Notification provider.
5. Hosting environment.
6. Final database schema.
7. Final UI designs.

---

# Current First-Version Delivery Policy

## Highest Priority

The highest project priority is to deliver the first working Backend version as quickly as possible while preserving the minimum organization required for later development.

## Functional Requirements Source Policy

Until the first working version is delivered, the SRS is the sole authoritative source for functional requirements.

The following rules apply:

* Only functional requirements explicitly supported by the SRS may be treated as active implementation requirements.
* Existing documentation that conflicts with the SRS must be corrected to match the SRS.
* Existing statements that are not supported by the SRS must not be treated as confirmed requirements.
* Previous answers, assumptions, inferences, proposals, or preliminary decisions that are not supported by the SRS must not control the implementation of the first version.
* Details not answered by the SRS must be recorded as Open Questions.
* Missing functional details must not be invented.
* A question must not be recorded when its answer already exists in the SRS.
* Duplicate questions are prohibited, including questions that use different wording but have the same meaning.

## Team-Discussion Context

The Backend Developer did not participate in all original project-requirements discussions.

The SRS was primarily prepared through discussions involving the other project team members.

Therefore, the Backend Developer may not currently know the answers to all unresolved requirements questions.

Questions not answered by the SRS will be preserved and reviewed with the project team after the first working version has been delivered.

## First-Version Implementation Policy

All clear and implementable Backend requirements explicitly contained in the SRS should be included in the implementation plan.

A clear SRS requirement must not be excluded merely because it is not required for the first end-to-end implementation flow.

End-to-end functional flows will be used to organize implementation and testing, not to remove other clear SRS requirements from the first-version plan.

Implementation may be deferred only when:

* The SRS does not provide a detail required for correct implementation.
* An external provider or service has not yet been selected.
* Implementing the behavior would require inventing a new functional requirement or Business Rule.
* The requirement is not a Backend responsibility.

## Documentation Responsibilities

Chat is responsible for:

* Analyzing project information.
* Comparing documentation with the SRS.
* Identifying duplicates, unsupported information, and unresolved questions.
* Making decisions with the user.
* Determining the correct documentation file for every result.
* Preparing precise instructions for Work and Codex.
* Reviewing the results returned by Work and Codex.

Work is responsible only for:

* Creating or updating documentation files according to explicit instructions.
* Preserving content that it was not instructed to modify.
* Reporting the exact files and sections modified.

Work must not invent:

* Functional requirements.
* Business Rules.
* Technical decisions.
* Architecture decisions.
* Answers to Open Questions.

Codex is responsible only for:

* Implementing approved code tasks.
* Running commands and tests.
* Reporting modified files and test results.

Codex must not invent:

* Functional requirements.
* Business Rules.
* Permissions.
* Workflow rules.
* Answers to Open Questions.

## Documentation-Change Requirement

Whenever information must be added to project documentation, Chat must provide:

* The exact text to add or modify.
* The exact target file.
* The location of the change when relevant.
* A precise message that can be sent to Work.
* A review of the result returned by Work.

# Important Notes For Future Chats

When discussing this project:

* Aws is responsible only for Backend.
* Ignore Flutter implementation details unless API requirements are needed.
* Ignore React implementation details unless API requirements are needed.
* Focus on Laravel architecture, database design, APIs, authentication, authorization, testing, deployment, and documentation.
* The SRS document is considered the primary source of requirements.
