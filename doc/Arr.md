# `Arr`

`Arr` is a PHP port of the JavaScript `Array` class, implemented as `Chubbyphp\Typescript\Arr`. It provides a close mapping of JavaScript's `Array` API using PHP syntax and conventions.

- **Generic type**: `@template T` — every `Arr` instance carries a type parameter for its elements.
- **Internal storage**: `array<int, null|T>` — an ordered, integer-keyed array with sparse-array semantics.
- **Errors**: Throws `Chubbyphp\Typescript\RangeError` for invalid array lengths and `Chubbyphp\Typescript\NumberFormatError` when locale-based number formatting fails.

---

## Static methods

### `from(mixed $items, ?callable $mapFn = null, ?object $thisArg = null): self`

Creates a new array from another `Arr`, a PHP iterable, or a string. If `$mapFn` is provided, it is applied to each value before insertion.

```php
use Chubbyphp\Typescript\Arr;

Arr::from(new Arr(2));                                 // [null, null]
Arr::from(['a', 'b'], static fn ($v, $i) => $i.':'.$v); // ['0:a', '1:b']
Arr::from('abc');                                      // ['a', 'b', 'c']
```

Sparse `Arr` inputs are converted to dense arrays with explicit `null` values, mirroring `Array.from()` turning holes into elements.

---

### `of(mixed ...$items): self`

Creates a new array from the provided arguments. Unlike the constructor, `Arr::of(3)` creates `[3]` rather than an array with length `3`.

```php
Arr::of(3);        // [3]
Arr::of(1, 2, 3);  // [1, 2, 3]
```

---

## Constructor

```php
use Chubbyphp\Typescript\Arr;

new Arr();              // []
new Arr(5);             // [null, null, null, null, null] (length 5)
new Arr(1, 2, 3);       // [1, 2, 3]
new Arr('hello');       // ['hello']
```

Passing a single `int` argument creates an array of that length (filled with `null`). Passing a single non-`int` argument creates a single-element array. Float or negative lengths throw `RangeError`.

---

## Instance properties

### `length`

Returns the number of elements in the array. Accessed via magic `__get`.

```php
$arr = new Arr(1, 2, 3);
$arr->length;  // 3

$arr->push(4);
$arr->length;  // 4

$arr->pop();
$arr->length;  // 3
```

---

## Magic methods

### `__toString(): string`

Magic method that delegates to `toString()`.

```php
$arr = new Arr(1, 2, 3);
echo $arr;  // '1,2,3'
```

---

## Instance methods

### `at(int $index): mixed`

Returns the element at the given index. Accepts negative integers to count from the end.

```php
$arr = new Arr(10, 20, 30);
$arr->at(0);   // 10
$arr->at(-1);  // 30
$arr->at(5);   // null
```

---

### `concat(mixed ...$items): self`

Returns a new array with the calling array joined with the provided items. `Arr` arguments are flattened; other values are appended as-is.

```php
$a = new Arr(1, 2);
$a->concat(new Arr(3, 4), 5); // [1, 2, 3, 4, 5]
```

---

### `copyWithin(int $target, int $start, ?int $end = null): self`

Shallow copies a portion of the array to another location within the same array, modifying it in place and returning it.

```php
$arr = new Arr('a', 'b', 'c', 'd', 'e');
$arr->copyWithin(0, 3, 4);      // ['d', 'b', 'c', 'd', 'e']
$arr->copyWithin(1, 3);         // ['d', 'd', 'e', 'd', 'e']
```

---

### `entries(): \Generator`

Returns a `Generator` yielding `[index, value]` pairs.

```php
$arr = new Arr('x', 'y');
foreach ($arr->entries() as [$i, $v]) {
    // $i => 0, $v => 'x'
    // $i => 1, $v => 'y'
}
```

---

### `every(callable $callback, ?object $thisArg = null): bool`

Tests whether every element passes the callback. Returns `false` as soon as one fails.

```php
$arr = new Arr(1, 30, 39, 42);
$arr->every(static fn ($v) => $v < 40);    // false
$arr->every(static fn ($v) => $v < 50);    // true
```

---

### `fill(mixed $value, int $start = 0, ?int $end = null): self`

Fills the array with a static value from `$start` to `$end` (exclusive). Modifies in place.

```php
$arr = new Arr(1, 2, 3, 4);
$arr->fill(0, 2, 4);               // [1, 2, 0, 0]
$arr->fill(5, 1);                  // [1, 5, 5, 5]
$arr->fill(6);                     // [6, 6, 6, 6]
```

---

### `filter(callable $callback, ?object $thisArg = null): self`

Returns a new array with elements that pass the callback.

```php
$arr = new Arr(10, 20, 30, 40);
$arr->filter(static fn ($v) => $v > 25);  // [30, 40]
```

---

### `find(callable $callback, ?object $thisArg = null): mixed`

Returns the first element that passes the callback, or `null`.

```php
$arr = new Arr(5, 12, 8, 130, 44);
$arr->find(static fn ($v) => $v > 10);    // 12
```

---

### `findIndex(callable $callback, ?object $thisArg = null): int`

Returns the index of the first element that passes the callback, or `-1`.

```php
$arr = new Arr(5, 12, 8, 130, 44);
$arr->findIndex(static fn ($v) => $v > 10);  // 1
```

---

### `findLast(callable $callback, ?object $thisArg = null): mixed`

Returns the last element that passes the callback, or `null`.

```php
$arr = new Arr(5, 12, 8, 130, 44);
$arr->findLast(static fn ($v) => $v > 10);   // 44
```

---

### `findLastIndex(callable $callback, ?object $thisArg = null): int`

Returns the index of the last element that passes the callback, or `-1`.

```php
$arr = new Arr(5, 12, 8, 130, 44);
$arr->findLastIndex(static fn ($v) => $v > 10);  // 4
```

---

### `flat(int $depth = 1): self`

Returns a new array with all sub-array elements concatenated up to the specified depth.

```php
$arr = new Arr(new Arr(1, 2), new Arr(3, Arr::of(4)));
$arr->flat(1);   // [1, 2, 3, [4]]
$arr->flat(2);   // [1, 2, 3, 4]
```

---

### `flatMap(callable $callback, ?object $thisArg = null): self`

Maps each element then flattens the result by one level.

```php
$arr = new Arr(1, 2, 3);
$arr->flatMap(static fn ($v) => new Arr($v, $v * 2));  // [1, 2, 2, 4, 3, 6]
```

---

### `forEach(callable $callback, ?object $thisArg = null): void`

Executes a callback for each element.

```php
$arr = new Arr('a', 'b', 'c');
$arr->forEach(static function (string $v) {
    // process $v
});
```

---

### `includes(mixed $searchElement, int $fromIndex = 0): bool`

Determines whether the array contains a value. Uses strict comparison (`===`) with special handling for `NAN`.

```php
$arr = new Arr(1, 2, 3);
$arr->includes(2);       // true
$arr->includes(4);       // false
$arr->includes(NAN);     // true (matches NaN per spec)
```

---

### `indexOf(mixed $searchElement, int $fromIndex = 0): int`

Returns the first index of a value, or `-1`.

```php
$arr = new Arr('a', 'b', 'c', 'b');
$arr->indexOf('b');      // 1
$arr->indexOf('b', 2);   // 3
$arr->indexOf('z');      // -1
```

---

### `join(?string $separator = null): string`

Joins all elements into a string separated by `$separator` (default `','`).

```php
$arr = new Arr('Wind', 'Rain', 'Fire');
$arr->join();          // 'Wind,Rain,Fire'
$arr->join(' - ');     // 'Wind - Rain - Fire'
$arr->join(', ');      // 'Wind, Rain, Fire'
```

---

### `keys(): \Generator`

Returns a `Generator` yielding the index of each element.

```php
$arr = new Arr('a', 'b', 'c');
foreach ($arr->keys() as $key) {
    // 0, 1, 2
}
```

---

### `lastIndexOf(mixed $searchElement, ?int $fromIndex = null): int`

Returns the last index of a value, or `-1`.

```php
$arr = new Arr('a', 'b', 'c', 'b');
$arr->lastIndexOf('b');      // 3
$arr->lastIndexOf('b', 2);   // 1
```

---

### `map(callable $callback, ?object $thisArg = null): self`

Returns a new array with the result of calling `$callback` on every element.

```php
$arr = new Arr(1, 4, 9);
$arr->map(static fn ($v) => $v * 2);  // [2, 8, 18]
$arr->map(static fn ($v) => (string) $v);  // ['1', '4', '9']
```

---

### `pop(): mixed`

Removes and returns the last element, or `null` if empty.

```php
$arr = new Arr(1, 2, 3);
$arr->pop();   // 3, arr is now [1, 2]
$arr->pop();   // 2, arr is now [1]
```

---

### `push(mixed ...$items): int`

Appends elements to the end and returns the new length.

```php
$arr = new Arr('a');
$arr->push('b');        // 2
$arr->push('c', 'd');   // 4
// arr is ['a', 'b', 'c', 'd']
```

---

### `reduce(callable $callback, mixed $initialValue = null): mixed`

Reduces the array to a single value, processing left-to-right.

```php
$arr = new Arr(1, 2, 3, 4);
$arr->reduce(static fn ($acc, $v) => $acc + $v, 0);    // 10
$arr->reduce(static fn ($acc, $v) => $acc . '-' . $v);  // '1-2-3-4'
```

Throws `TypeError` on an empty array with no initial value.

---

### `reduceRight(callable $callback, mixed $initialValue = null): mixed`

Reduces the array to a single value, processing right-to-left.

```php
$arr = new Arr('a', 'b', 'c');
$arr->reduceRight(static fn ($acc, $v) => $acc . $v, '');  // 'cba'
```

---

### `reverse(): static`

Reverses the array in place and returns it.

```php
$arr = new Arr(1, 2, 3);
$arr->reverse();   // [3, 2, 1]
```

---

### `shift(): mixed`

Removes and returns the first element, or `null` if empty.

```php
$arr = new Arr(1, 2, 3);
$arr->shift();   // 1, arr is now [2, 3]
```

---

### `slice(int $start = 0, ?int $end = null): self`

Returns a shallow copy of a portion of the array.

```php
$arr = new Arr('a', 'b', 'c', 'd', 'e');
$arr->slice(2);        // ['c', 'd', 'e']
$arr->slice(2, 4);     // ['c', 'd']
$arr->slice(-2);       // ['d', 'e']
```

---

### `some(callable $callback, ?object $thisArg = null): bool`

Tests whether at least one element passes the callback. Returns `true` as soon as one passes.

```php
$arr = new Arr(1, 2, 3, 4);
$arr->some(static fn ($v) => $v % 2 === 0);  // true
$arr->some(static fn ($v) => $v > 10);        // false
```

---

### `sort(?callable $callback = null): static`

Sorts the array in place. Without a callback, elements are converted to strings and sorted lexicographically (matching JavaScript's default sort).

```php
$arr = new Arr(3, 30, 1, 100);
$arr->sort();                 // [1, 100, 3, 30] (string sort)

$arr->sort(static fn ($a, $b) => $a <=> $b);  // [1, 3, 30, 100] (numeric)
```

---

### `splice(int $start, ?int $deleteCount = null, mixed ...$items): self`

Changes the array by removing/replacing elements and returns the removed elements.

```php
$arr = new Arr(1, 2, 3, 4, 5);
$arr->splice(2);          // returns [3, 4, 5], arr is [1, 2]
$arr->splice(1, 1);       // returns [2], arr is [1]
```

---

### `toLocaleString(?string $locales = null, ?array $options = null): string`

Returns a locale-sensitive string representation of the array.

```php
$arr = new Arr(1000, 2000);
$arr->toLocaleString('de-DE');               // '1.000,2.000'
$arr->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'EUR']);  // '€1,000.00,€2,000.00'
```

---

### `toReversed(): self`

Returns a new array with the elements reversed (does not modify the original).

```php
$arr = new Arr(1, 2, 3);
$arr->toReversed();   // [3, 2, 1]
// $arr is still [1, 2, 3]
```

---

### `toSorted(?callable $callback = null): self`

Returns a new array with the elements sorted (does not modify the original).

```php
$arr = new Arr(3, 1, 2);
$sorted = $arr->toSorted();
// $sorted is [1, 2, 3], $arr is [3, 1, 2]
```

---

### `toSpliced(int $start, ?int $deleteCount = null, mixed ...$items): self`

Returns a new array with elements removed/replaced (does not modify the original).

```php
$arr = new Arr(1, 2, 3, 4);
$spliced = $arr->toSpliced(1, 2, 100);
// $spliced is [1, 100, 4], $arr is [1, 2, 3, 4]
```

---

### `with(int $index, mixed $value): self`

Returns a new array with the element at `index` replaced by `value` (does not modify the original). Supports negative indices.

```php
$arr = new Arr(1, 2, 3, 4, 5);
$result = $arr->with(2, 99);
// $result is [1, 2, 99, 4, 5], $arr is [1, 2, 3, 4, 5]

$arr2 = new Arr(1, 2, 3);
$result2 = $arr2->with(-1, 'x');
// $result2 is [1, 2, 'x']
```

---

### `toString(): string`

Returns a string representation by joining with `','`.

```php
$arr = new Arr(1, 2, 3);
$arr->toString();   // '1,2,3'
```

---

### `unshift(mixed ...$items): int`

Prepends elements to the start and returns the new length.

```php
$arr = new Arr(3, 4);
$arr->unshift(1, 2);   // 4, arr is [1, 2, 3, 4]
```

---

### `values(): \Generator`

Returns a `Generator` yielding the value of each element.

```php
$arr = new Arr('a', 'b', 'c');
foreach ($arr->values() as $value) {
    // 'a', 'b', 'c'
}
```

Use `iterator_to_array($arr->values())` to get a plain PHP array.

---

### `toArray(): array`

Returns a plain PHP array view of the `Arr`, preserving sparse positions as `null` values and recursively converting nested `Arr` instances.

```php
$arr = new Arr(1, 'two', null, true);
$arr->toArray();  // [1, 'two', null, true]

$nested = new Arr(new Arr('a', 'b'));
$nested->toArray();  // [['a', 'b']]
```

---

### `jsonSerialize(): array`

Returns a plain PHP array suitable for `json_encode`, preserving sparse positions as `null` values and recursively serializing nested values.

```php
$arr = new Arr(1, 'two', null, true);
json_encode($arr);  // '[1,"two",null,true]'
```

---

## `thisArg` support

Methods that accept a `$thisArg` parameter (`every`, `filter`, `find`, `findIndex`, `findLast`, `findLastIndex`, `flatMap`, `forEach`, `map`, `some`) bind a `Closure` callable to the given object using `Closure::bindTo`. Non-`Closure` callables ignore `$thisArg`.

```php
$arr = new Arr(1, 2, 3);
$context = new class {
    public int $multiplier = 10;
};
$arr->map(
    function ($v) {
        return $v * $this->multiplier;
    },
    $context,
);
// [10, 20, 30]
```

---

## Chaining

Methods that return `self` (or a new `self`) can be chained:

```php
$result = (new Arr(5, 2, 8, 1, 9))
    ->filter(static fn ($v) => $v > 3)
    ->sort()
    ->map(static fn ($v) => $v ** 2);
// [25, 64, 81]
```
