# Advanced Polls

[![Latest release](https://img.shields.io/github/v/release/Leinad4Mind/advancedpolls?display_name=tag&sort=semver)](https://github.com/Leinad4Mind/advancedpolls/releases)
[![Tests](https://github.com/Leinad4Mind/advancedpolls/actions/workflows/tests.yml/badge.svg)](https://github.com/Leinad4Mind/advancedpolls/actions/workflows/tests.yml)
[![License](https://img.shields.io/badge/license-GPL--2.0-blue.svg)](license.txt)

Advanced Polls extends phpBB's poll system with configurable visibility and vote-change rules, scoring and ranking polls, multi-question ballots, voter information, notifications, and more.

## Requirements

- phpBB 3.3.0 or later (phpBB 4 is not supported)
- PHP 7.1.3 or later
- One of the included styles: prosilver, BBOOTS, or FLATBOOTS

## Features

### Poll types and questions

- Standard choice polls.
- Numeric scoring polls with a configurable minimum and maximum score.
- Scoring results can show accumulated points or the arithmetic average per option.
- Ordered ranking polls: users select options in preference order and the configured decreasing point values are assigned automatically.
- Multi-question polls presented as pages within one ballot. All questions share the poll type, limits, points, visibility, and vote-change rules.
- Each question can be required or optional, allowing users to continue without answering optional pages.

### Voting and visibility

- Four result visibility modes: always public, after the first vote, after all available votes are used, or only after the poll ends.
- Three vote-change modes: no changes, incremental voting, or unrestricted changes while the poll is open.
- Optional deletion of a user's own vote when vote changes are allowed.
- Multiple votes or points may be assigned to an option, with per-option and total limits.
- Voting may be restricted to users who have already posted in the topic.
- Voting can be allowed in locked topics while the poll itself remains open.
- Users may explicitly abstain and view results; the abstainer count and permitted names can be displayed.
- Registered and guest voting are supported by the applicable phpBB permissions.

### Results and management

- Voters can be shown per option, controlled by forum and moderator permissions.
- Detailed scoring and ranking breakdowns are available without reloading the topic.
- Numeric scoring bars can display averages and optionally hide percentage labels.
- Results may be sorted by their result value.
- A board-wide poll directory lists accessible open and closed polls, with an optional navigation-bar link.
- Polls can end after a duration in days or hours, or at an exact date and time.
- Users can collapse individual polls when the feature is enabled in the ACP. It defaults to enabled on a new installation when `phpbb/collapsiblecategories` is installed, but administrators can always override it.
- Poll voting, multi-question navigation, and voter information use AJAX where supported by the page action.

### Safe poll updates and notifications

- New options can be appended to an active poll without resetting existing votes.
- Safe append mode requires vote changes to be allowed and does not permit existing questions or options to be renamed, removed, or reordered.
- Previous registered voters can be notified when new options are added, subject to the ACP setting and their notification preferences.
- Eligible voters of hidden polls can be notified when the poll ends and its results become visible.
- Option additions are recorded in a revision log.
- Votes belonging to deleted accounts follow the selected phpBB deletion operation: retaining posts preserves the vote under the retained username, while deleting posts removes the vote.

## Changes by release

### 1.6.0

- Added accumulated-points and average-rating result modes for numeric scoring polls.
- Added detailed score/rank distributions and AJAX result details.
- Added the accessible poll directory and optional navigation-bar link.
- Added the option to hide percentage labels on scoring results.

### 1.5.0

- Added safe appending of options without resetting existing votes.
- Added fairness warnings, revision tracking, and notifications for previous voters.

### 1.4.0

- Added multi-question, paginated polls with required or optional questions.
- Added ordered ranking polls with automatic points based on selection order.
- Added globally shared scoring/ranking rules across question pages.
- Added independently configurable collapsible polls.
- Added and adapted templates for BBOOTS and FLATBOOTS.

### 1.3.0

- Reworked result visibility and vote-change settings into explicit modes.
- Restored reliable notifications when hidden polls end.
- Added vote deletion and abstainer information controls.
- Added safe handling of votes after phpBB user deletion.
- Added a phpBB compatibility check, PHP 8 compatibility work, broader automated tests, and completed language catalogues.

## Installation

1. Download the installable `advancedpolls-<version>.zip` asset from the [latest GitHub release](https://github.com/Leinad4Mind/advancedpolls/releases/latest). Do not use GitHub's automatically generated **Source code** archives.
2. Extract the package into the `ext/` directory of your phpBB installation. The resulting path must be:

   ```text
   ext/wolfsblvt/advancedpolls/
   ```

3. In the ACP, open **Customise > Manage extensions** and enable **Advanced Polls**.

The release ZIP already contains the required `wolfsblvt/advancedpolls` directory structure.

## Configuration after installation

1. Open the Advanced Polls settings in the ACP and enable the board-wide features you want to offer. Review the defaults applied when users create polls.
2. Review the **Can see poll voters** forum permission and the corresponding moderator permission. Grant access only to roles or groups that may see voter identities.
3. If required, enable collapsible polls and the poll-directory navigation link in the extension settings.

No additional setup is required for the remaining features.

## Updating

1. Disable Advanced Polls in **ACP > Customise > Manage extensions**. Do not delete its data.
2. Replace the files in `ext/wolfsblvt/advancedpolls/` with those from the new release package.
3. Enable the extension again so phpBB can apply the new migrations.
4. Purge the phpBB cache and review the extension settings and permissions.

## Languages

The repository includes German, German (formal), English, Spanish, French, Hebrew, Italian, Japanese, Dutch, Polish, Portuguese, Brazilian Portuguese, Pre-AO Portuguese, Russian, and Swedish language packs.

## Authors

- [Leinad4Mind](https://github.com/Leinad4Mind) — current developer
- José Alfonso Solera (jasolo) — previous developer
- Javier López (javiexin) — previous developer
- Clemens Husung (Wolfsblvt) — original developer

## License

Advanced Polls is released under the [GNU General Public License v2](license.txt).
