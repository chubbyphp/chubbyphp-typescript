# Project Context — chubbyphp-typescript

PHP port of JavaScript's `Array` API with TypeScript-style generics. Keep behavior close to JavaScript `Array`; the test suite is the spec.

## Where To Work
- `src/Arr.php` is the main implementation.
- `tests/Unit/ArrTest.php` is the main spec and is organized by JS API section order.
- `tests/Integration/DocumentationExamplesTest.php` verifies the PHP examples in `README.md` and `doc/Arr.md`.
- Update `doc/Arr.md` and `README.md` when public behavior changes.

## Important Conventions
- Keep `declare(strict_types=1);`, typed properties, `final` classes, and the detailed PHPDoc generics/callable signatures in `Arr`.
- Method ordering rule for `Arr.php`: (1) magic methods `__*`; (2) interface methods, in the order listed in `implements`; (3) the rest sorted by MDN JS `Array` order (statics first, then instance methods); (4) non-JS methods at the end. Mirror that order in `tests/Unit/ArrTest.php`, `doc/Arr.md`, and `tests/Integration/DocumentationExamplesTest.php`.
- `thisArg` support is intentional: bind only non-static `Closure` callables; other callables ignore it.

## Important Behavior
- Preserve sparse-array semantics. `length` may be greater than the number of populated indexes.
- Holes read back as `null` through `at()`, `values()`, `toArray()`, and `jsonSerialize()`, but `offsetExists()`/`isset()` must still distinguish between missing indexes and explicit `null` values.
- Favor JavaScript `Array` semantics over idiomatic PHP shortcuts.

## Verification
- Use Composer scripts as the default workflow: `composer test:unit`, `composer test:integration`, `composer test:static-analysis`, `composer test:cs`, or `composer test`.
- PHPUnit runs in random order, so avoid hidden test coupling.
- Keep every PHP example in `README.md` and `doc/Arr.md` executable and in sync with `tests/Integration/DocumentationExamplesTest.php`; add one integration test per documented example block.
