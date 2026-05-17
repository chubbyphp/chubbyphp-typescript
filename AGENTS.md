# Project Context — chubbyphp-typescript

PHP port of JavaScript's `Array` API with TypeScript-style generics. Keep behavior close to JavaScript `Array`; the test suite is the spec.

## Where To Work
- `src/Arr.php` is the main implementation.
- `tests/Unit/ArrTest.php` is the main spec and is organized by JS API section order.
- Update `doc/Arr.md` and `README.md` when public behavior changes.

## Important Conventions
- Keep `declare(strict_types=1);`, typed properties, `final` classes, and the detailed PHPDoc generics/callable signatures in `Arr`.
- Keep magic methods (`__*`) at the beginning, JS `Array` methods aligned with MDN instance method order after them, and other non-JS `Array` methods at the end. Mirror that order in `tests/Unit/ArrTest.php` and in any ordered API docs.
- `thisArg` support is intentional: bind only non-static `Closure` callables; other callables ignore it.

## Important Behavior
- Preserve sparse-array semantics. `length` may be greater than the number of populated indexes.
- Holes read back as `null` through `at()`, `values()`, `toArray()`, and `jsonSerialize()`, but `offsetExists()`/`isset()` must still distinguish between missing indexes and explicit `null` values.
- Favor JavaScript `Array` semantics over idiomatic PHP shortcuts.

## Verification
- Use Composer scripts as the default workflow: `composer test:unit`, `composer test:integration`, `composer test:static-analysis`, `composer test:cs`, or `composer test`.
- PHPUnit runs in random order, so avoid hidden test coupling.
- If you edit `src/Arr.php` and line numbers move, update `infection.json` ignore entries in the same change so mutation-test ignores stay aligned.
