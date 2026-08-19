# Changelog

All notable changes to Advanced Polls are documented here.

## 1.7.3 - 2026-08-19

- Treated phpBB's `<t></t>` rich-text wrapper as an empty poll title instead of a valid title.
- Added a confirmed ACP action that normalizes empty stored titles without modifying poll options, votes or timing data.
- Reported how many requested residual rows were cleaned and how many were skipped after safety revalidation.

## 1.7.2 - 2026-08-19

- Fixed the poll directory and status manager counting stale topic metadata as real polls.
- Required real poll options before a poll can be listed, opened or closed.
- Added an ACP integrity report with raw titles, timing fields, poll options and vote counts.
- Added selective and board-wide cleanup for residual poll metadata, protected by confirmation, CSRF validation and an administrator log entry.
- Added an ACP setting for the poll-directory tab order; the first configured tab is the default, while new installations retain All, Open, Closed.
- Kept ambiguous rows with poll options or vote history read-only for manual review.

## 1.7.1 - 2026-08-18

- Fixed the scheduled poll start column using phpBB's portable full timestamp type.
- Added a migration that widens columns already created by version 1.7.0 without losing data.

## 1.7.0 - 2026-08-18

- Added optional poll start scheduling with local date/time input.
- Kept scheduled polls hidden while their topics remain visible.
- Blocked normal, AJAX and multi-question voting before the scheduled start.
- Excluded future polls from the poll directory and bulk status actions.
- Based finite poll durations on the scheduled start.
- Added ACP configuration, migrations, prosilver support and translations for all bundled languages.

## 1.6.1 - 2026-08-18

- Consolidated the unreleased schema repair into the final 1.6.1 migration.
- Added permission-aware open/close management for individual or selected polls.
- Improved poll directory pagination, responsive toolbars, row status cues and theme consistency.
- Fixed encoded URL separators, escaped titles and poll result labels.

## 1.6.0 - 2026-08-06

- Added the searchable and filterable poll directory.
- Added total/average scoring summaries, score distributions and ranked result breakdowns.
- Added configurable result percentages and result ordering.
- Added Danish and completed the bundled language catalogues.

## 1.5.0 - 2026-08-04

- Added permission-controlled appending of options to existing polls.
- Added notifications when options are appended.
- Preserved existing votes and validated structural changes.

## 1.4.0 - 2026-08-03

- Added multi-question polls with required and optional questions.
- Added ranked and scoring vote support for additional questions.
- Added collapsible poll presentation.
- Added guest ballot tracking and supporting database tables.

## 1.3.0 - 2026-08-02

- Added explicit result visibility and vote mode policies.
- Added choice, scoring and ranking poll types.
- Added poll-end notifications, vote deletion and abstainer display.
- Retained names for votes belonging to deleted users.

## 1.2.4.3 - 2022-11-29

- Last release from the previous public branch baseline.
