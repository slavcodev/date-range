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

## [0.5.0] 2023-05-17

### Changed
- Changed license to `MIT`.
- Increased minimum version of the PHP to v8.2.
- Enable strict mode for all code.
- Migrated from TravisCI to GitHub actions.
- Upgraded PhpUnit to v10.
- Renamed the interface `Exception` to `DateRangeException`.
- Renamed the class `DateRangeException` to `InvalidDateRangeDateRangeException`.

## [0.4.0] 2018-02-16

### Added
- Added new method `getTimestampInterval` to returns duration in seconds.

## [0.3.0] 2017-11-18

### Added
- Added `DateRangeProvider` interface and basic provider `FiniteDateRangeProvider`.
- Added new method `getDateInterval`, `getDatePeriod`, `split`.

### Changed
- Rename methods from using `time` ot `date`.
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
