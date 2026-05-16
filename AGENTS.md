# Project Context — chubbyphp-typescript

PHP 1:1 port of JS `Array`. Test262-based tests.

## Conventions
- Method ordering: MDN instance method order; `__toString` after `__construct` (PHP-CS-Fixer).
- `thisArg`: `Closure::bindTo` for Closure callables; non-Closure ignores.
