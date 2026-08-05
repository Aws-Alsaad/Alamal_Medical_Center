# Decisions

## DEC-001 — SRS-Only Functional Baseline Before the First Delivery

**Status:** Adopted  
**Date:** 2026-07-25

Until the first working Backend version is delivered, the SRS is the sole authoritative source for functional requirements.

Previous answers, assumptions, interpretations, proposals, or preliminary decisions must not be used as implementation requirements when they are not explicitly supported by the SRS.

## DEC-002 — Handling Documentation That Conflicts with the SRS

**Status:** Adopted  
**Date:** 2026-07-25

When existing documentation conflicts with the SRS:

* The conflicting active requirement must be removed or corrected.
* The corresponding SRS requirement must be used.
* The old unsupported statement must not remain as an active requirement.
* A conflict is recorded only when the SRS itself contains incompatible requirements that cannot be reconciled.

## DEC-003 — Handling Information Not Answered by the SRS

**Status:** Adopted  
**Date:** 2026-07-25

When the SRS does not answer a functional question:

* No answer will be invented.
* No temporary functional rule will be adopted for implementation.
* The point will be recorded as an Open Question.
* Clear parts of the related module may still be implemented.
* The unresolved question will be reviewed with the project team after delivery of the first working version.

## DEC-004 — Treatment of Previous Answers

**Status:** Adopted  
**Date:** 2026-07-25

Previous answers are not active requirements when they:

* Are not explicitly supported by the SRS.
* Conflict with the SRS.
* Are based on assumptions, personal preference, inference, or preliminary discussion.

A previous answer that is useful only for later discussion may be preserved as:

`Unverified User Note — Not Approved for Implementation`

Such a note must not appear in Confirmed Information, Business Rules, API specifications, or implementation instructions.

## DEC-005 — First-Version Implementation Coverage

**Status:** Adopted  
**Date:** 2026-07-25

Every clear and implementable Backend requirement explicitly contained in the SRS must be included in the implementation plan.

A requirement must not be excluded merely because it is not required by the first end-to-end implementation flow.

End-to-end flows are used to organize development and testing, not to define the complete functional scope.

## DEC-006 — Deferred Implementation

**Status:** Adopted  
**Date:** 2026-07-25

Implementation may be deferred when:

* The SRS does not provide a detail required for correct implementation.
* An external provider or integration has not been selected.
* Implementation would require inventing a new functional requirement or Business Rule.
* The requirement is not a Backend responsibility.

Deferring implementation does not remove the requirement from the SRS-derived requirements baseline.

## DEC-007 — Question Deduplication and Canonical Location

**Status:** Adopted  
**Date:** 2026-07-25

* A question must not be recorded when the SRS already provides the answer.
* The same question must not appear more than once, including equivalent questions written with different wording.
* Every Open Question must have one canonical record and a stable identifier.
* PROJECT_UNDERSTANDING_QA.md is the authoritative location for project-understanding questions.
* notes/questions.md is only a temporary intake queue and is not an authoritative source.

## DEC-008 — Documentation-File Creation

**Status:** Adopted  
**Date:** 2026-07-25

No fixed number of new documentation files is predetermined.

A new file may be created only when:

* No existing file has the same responsibility.
* The new file prevents confusion rather than duplicating information.
* Its purpose and relationship with existing files are explicitly defined.

## DEC-009 — Responsibilities of Chat, Work, and Codex

**Status:** Adopted  
**Date:** 2026-07-25

Chat is responsible for analysis, decisions, documentation placement, task preparation, and result review.

Work is responsible only for explicitly requested documentation changes and must not invent requirements or decisions.

Codex is responsible only for approved implementation, commands, and tests and must not invent functional requirements or Business Rules.
