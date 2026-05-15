# Project Context — chubbyphp-typescript

## What This Is
PHP 1:1 port of JavaScript's `Array`, with `@template T` generics, `RangeError` custom exception, and Test262-based tests.

## Class: `Arr` (`Arr`, not `Array` — PHP reserved keyword)
- Namespace: `Chubbyphp\Typescript`
- `@template T` on the class docblock
- `@var list<T> private array $data` — internal storage
- Errors thrown as `RangeError` (extends `RuntimeException`, in `src/RangeError.php`)

## Method Ordering
Follow MDN instance methods order, EXCEPT `__toString` goes immediately after `__construct` (PHP-CS-Fixer enforces magic methods next to constructor).

## `thisArg` Support
`Closure::bindTo($thisArg)` for Closure callables. Non-Closure callables ignore `thisArg`.

## Test Convention (Test262)
- PHPUnit, `tests/Unit/ArrTest.php`
- Section comments: `// Array.prototype.<method>`
- Test method names: `test<Method><Scenario>`
- Callback assertions use `static fn/Closure` for conciseness
- Assert via `iterator_to_array($arr->values())` or `$arr->at($i)`

## Commands
```sh
vendor/bin/phpunit tests/Unit/ArrTest.php
vendor/bin/phpstan analyse --level 0 src/Arr.php tests/Unit/ArrTest.php
composer fix:cs     # PHP-CS-Fixer (applies)
composer test:cs    # PHP-CS-Fixer (dry-run)
composer test:static-analysis  # PHPStan level 9 on src/
composer test:unit  # Full unit suite with coverage
```
