# Change Log
All notable changes to this project will be documented in this file
using the [Keep a CHANGELOG](http://keepachangelog.com/) principles.
This project adheres to [Semantic Versioning](http://semver.org/).

<!--
Types of changes

Added - for new features.
Changed - for changes in existing functionality.
Deprecated - for soon-to-be removed features.
Removed - for now removed features.
Fixed - for any bug fixes.
Security - in case of vulnerabilities.
-->

## [Unreleased]

_TBD_

### Changed
- Changed constraint to allow empty ranges, allowing you to use the end time exactly the same as the start time. ([#18](../../pull/19)).

## [0.4.0] 2018-02-16

### Added
- Added new method `getTimestampInterval` to returns duration in seconds ([#18](../../pull/18)).

## [0.3.0] 2017-11-18

### Added
- Added `DateRangeProvider` interface and basic provider `FiniteDateRangeProvider` ([#13](../../pull/13)).
- Added new method `getDateInterval`, `getDatePeriod`, `split` ([#9](../../pull/9)).

### Changed
- Rename methods from using `time` ot `date` ([#11](../../pull/11)).
- Refactored internals.

## [0.1.1] 2017-11-17

### Changed
- Implement `State` pattern to control ranges objects.
- Change JSON representation to array instead of string in previous version.

### Removed
- Remove mutable object, leave only immutable.
- Remove implementation of Serializable interface.

## [0.0.1] 2017-11-16

Initial release.
