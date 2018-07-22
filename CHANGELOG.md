# Release Notes


## v1.3.5 (07/22/2018)

### Added
* Added `folders()` method within `Filesystem` for extracting only directories.

### Changed
* The `getAll()` within `Filesystem` added `type` for `folders` and `files`.


## v1.3.4 (07/14/2018)

### Added
* Added `rename()` method for renaming files or directories in the `Filesystem`.
* Added `files()` method as an alias (future replacement to `getAll()`) in the `Filesystem`.


## v1.3.3 (07/13/2018)

### Added
* Added real path option on `Filesystem::getPath()`, before it would only give file names.


## v1.3.2 (07/08/2018)

### Added
* Added new method `replace()` on `Collection`

### Changed
* Allowing `replace()`, `set()` and `remove()` to return `$this` for chaining.


## v1.3.1 (07/07/2018)

### Added
* Added new methods `pull()`, `push()`, `put()` on `Collection`


## v1.3.0 (07/07/2018)

### Added
* Added new method `random()` on `Collection`
* Added new method `only()` and `except()` on `Collection`


## v1.2.0 (07/07/2018)

### Added
* Added new `Collection` methods, `where()`, `whereIn()` and `filter()`
* Added protected method on `Collection` for `filterWhere()` on an operator check.


## v1.1.0 (07/06/2018)

### Added
* Added new `Collection` methods, `sort()` and `sortBy()` (ability to sort the items in collection)
* Added protected methods on `Collection` for `isCallable()` and `ValueCallable()`.


## v1.0.1 (06/07/2018)

### Added
* Added more `Collection` tests to improve code coverage.

### Changed
* Changed the `collection->has()` to work with "dot" notation.

### Fixed
* Minor updates to `Arr` class and added `Arr` tests for code better code coverage.
