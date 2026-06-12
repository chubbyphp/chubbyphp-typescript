# Project Context — chubbyphp-typescript

PHP (^8.3) port of JavaScript's `Array` API with TypeScript-style generics.

**Golden rule:** behave exactly like JavaScript `Array`, not like idiomatic PHP.
When unsure what JS does, do not guess — run it: `node` is available.

```bash
node -e 'console.log([1, , 3].findIndex(x => x === undefined))'  # prints 1
```

## File Map

| Path | Purpose |
|---|---|
| `src/Arr.php` | The whole implementation (one class) |
| `src/RangeError.php`, `src/NumberFormatError.php` | Project exception classes |
| `tests/Unit/ArrTest.php` | Main spec, organized in JS API order (see ordering rule) |
| `tests/Unit/Test262*Test.php` | Ports of the official test262 suite, one file per `Array` method |
| `tests/Integration/DocumentationExamplesTest.php` | Mirrors every PHP example block in `README.md` / `doc/Arr.md` |
| `tests/Stub/*.php` | Shared test fixtures |
| `doc/Arr.md` | API documentation with runnable examples |

## Commands (run from repo root)

| Command | What it checks |
|---|---|
| `composer test` | Everything below, in order — **must exit 0 before you are done** |
| `composer test:lint` | `php -l` on all files |
| `composer test:static-analysis` | PHPStan level 9 (analyzes `src/` only, not tests) |
| `composer test:cs` | php-cs-fixer dry-run (covers `src/` AND `tests/`) |
| `composer test:unit` | PHPUnit Unit suite with coverage |
| `composer test:integration` | PHPUnit Integration suite |
| `composer test:infection` | Mutation testing, fails below 95% MSI (needs `test:unit` coverage first) |
| `composer fix:cs` | Auto-fix code style |

Quality gates to preserve:
- 100% line and method coverage of `src/Arr.php` (check the coverage summary `composer test:unit` prints).
- Mutation score ≥ 95%. Kill mutants with **exact** assertions: assert exact strings/values,
  test boundary values (`0`, `-1`, `length`, `length - 1`, `21`, `-6`), and test negative numbers,
  empty arrays, and sparse arrays for every new branch.

## Hard Conventions

- Keep `declare(strict_types=1);`, `final` classes, typed properties, and the detailed
  PHPDoc generics/callable signatures (`@template T`, `callable(null|T, int, self<T>): bool`, ...).
- Method ordering in `Arr.php`: (1) magic methods `__*`; (2) interface methods in the order
  listed in `implements`; (3) JS API methods in MDN order (statics first, then instance methods);
  (4) non-JS helpers (`toArray()`, private helpers) at the end.
  Mirror the same order in `tests/Unit/ArrTest.php`, `doc/Arr.md`, and
  `tests/Integration/DocumentationExamplesTest.php`.
- `thisArg` support: bind only non-static `Closure` callables via `Closure::bindTo`;
  every other callable type silently ignores `$thisArg`.

## JavaScript Semantics Cheat Sheet (read before touching `src/Arr.php`)

- PHP `null` plays the role of JS `undefined` everywhere.
- **Sparse arrays:** `length` can exceed the number of stored indexes ("holes").
  Reading a hole returns `null`, but `offsetExists()`/`isset()` returns `false` for holes
  and `true` for explicit `null` values. Never collapse that distinction.
- **Methods that SKIP holes** (callback not invoked / index not matched):
  `every`, `some`, `filter`, `forEach`, `map` (keeps holes in result), `reduce`, `reduceRight`,
  `flat`, `indexOf`, `lastIndexOf`.
- **Methods that DO NOT skip holes** (hole is treated as `null`):
  `find`, `findIndex`, `findLast`, `findLastIndex`, `includes`, `join`, `keys`, `entries`, `values`, `fill`, `at`.
- **Always-dense results:** `toReversed`, `toSorted`, `toSpliced`, `with` never return sparse
  arrays — holes materialize as explicit `null`s.
- Iteration methods capture `$len = $this->internalLength` **before** the loop
  (JS uses the initial length even if the callback mutates the array).
- `$this->internalArray` keys are in **insertion order, not index order**
  (`$a[2] = ...; $a[0] = ...;`). When order matters, never `foreach` over it directly;
  loop `for ($i = 0; $i < $len; ++$i)` and check `\array_key_exists($i, ...)`.
- Floats stringify via `numberToString()` which implements ECMAScript `Number::toString`
  (shortest round-trip): `0.1` → `"0.1"`, `1.0` → `"1"`, `-0.0` → `"0"`, `INF` → `"Infinity"`,
  `NAN` → `"NaN"`, `1e21` → `"1e+21"`, `1e-7` → `"1e-7"`. Do not use `sprintf('%g')` or `(string)` casts.
- `sort()` moves explicit `null`s (JS `undefined`) to the end without calling the comparator;
  holes end up after those (length stays, trailing indexes unset).
- Out-of-range / non-numeric `ArrayAccess` offsets become string "properties" stored separately
  (they never affect `length`), mirroring JS property access; offsets that cannot be stringified throw.

## Testing Rules

- The test suite is the spec. PHPUnit runs tests in **random order** — no hidden coupling between tests.
- `tests/Unit/Test262*Test.php`: each test method names the original test262 file in its PHPDoc.
  Non-portable test262 cases are recorded as two comment lines:
  `// SKIPPED: test/built-ins/Array/...js` followed by `// Reason: ...`.
  Adapted cases explain the adaptation in a comment. Keep that style when adding or changing tests.
- If you change public behavior: update `tests/Unit/ArrTest.php`, the matching `Test262*Test.php`,
  `doc/Arr.md`, and `README.md` together.
- Every PHP example block in `README.md` and `doc/Arr.md` must stay executable and have exactly
  one matching test in `tests/Integration/DocumentationExamplesTest.php` (`testDoc<Method>Example`).
- PHPStan does not analyze `tests/`, but php-cs-fixer does — run `composer fix:cs` after writing tests.

## Done Checklist

1. JS behavior verified against `node` (not assumed).
2. `composer test` exits 0 (includes 95% MSI and code style).
3. Coverage still 100% for `src/Arr.php`.
4. Docs + integration examples updated if public behavior changed.
