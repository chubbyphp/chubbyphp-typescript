# `Map`

`Map` is a PHP port of the JavaScript `Map` class, implemented as `Chubbyphp\Typescript\Map`. It provides a close mapping of JavaScript's `Map<K, V>` API using PHP syntax and conventions.

- **Generic type**: `@template K, V` — every `Map` instance carries type parameters for its keys and values.
- **Internal storage**: `list<null|array{0: K, 1: V}>` — an ordered list of key-value pairs with `null` sentinels for deleted entries, matching JS `MapData` semantics.
- **Errors**: Throws `\TypeError` when the constructor receives an invalid entry object.

---

## Constructor

```php
use Chubbyphp\Typescript\Map;

new Map();                            // size 0
new Map([['a', 1], ['b', 2]]);        // size 2
new Map(null);                        // size 0
```

The constructor accepts an iterable of entries. Each entry must itself be iterable and yield at least a key and a value. Extra values in an entry are ignored.

---

## Instance properties

### `size`

Returns the number of key-value pairs in the map. Accessed via magic `__get`.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->size;  // 2

$map->set('c', 3);
$map->size;  // 3

$map->delete('a');
$map->size;  // 2
```

---

## Instance methods

### `clear(): void`

Removes all key-value pairs from the map.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->clear();

$map->size;  // 0
```

---

### `delete(mixed $key): bool`

Removes the entry for the given key and returns `true` if the key existed, otherwise `false`.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->delete('a');  // true
$map->delete('c');  // false

$map->size;  // 1
```

---

### `entries(): \Generator`

Returns a `Generator` yielding `[key, value]` pairs in insertion order.

```php
$map = new Map([['a', 1], ['b', 2]]);

$entries = [];
foreach ($map->entries() as $entry) {
    $entries[] = $entry;
}

// $entries === [['a', 1], ['b', 2]]
```

---

### `forEach(callable $callback, ?object $thisArg = null): void`

Invokes the callback once for each key-value pair, in insertion order. The callback receives `value`, `key`, and the map itself.

```php
$map = new Map([['a', 1], ['b', 2]]);

$seen = [];
$map->forEach(static function (int $value, string $key, Map $map) use (&$seen): void {
    $seen[] = [$key, $value];
});

// $seen === [['a', 1], ['b', 2]]
```

---

### `get(mixed $key): mixed`

Returns the value associated with the key, or `null` if the key is not present.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->get('a');  // 1
$map->get('c');  // null
```

---

### `has(mixed $key): bool`

Returns `true` if the map contains the key, otherwise `false`.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->has('a');  // true
$map->has('c');  // false
```

`Map` uses `SameValueZero` equality, so `NaN` matches `NaN` and `-0` matches `+0`.

```php
$map = new Map();
$map->set(NAN, 'found');
$map->has(NAN);  // true

$map->set(-0.0, 'zero');
$map->has(0);    // true
```

---

### `keys(): \Generator`

Returns a `Generator` yielding keys in insertion order.

```php
$map = new Map([['a', 1], ['b', 2]]);
iterator_to_array($map->keys());  // ['a', 'b']
```

---

### `set(mixed $key, mixed $value): self`

Adds or updates a key-value pair. If the key already exists, the value is updated without changing insertion order. Returns the map for chaining.

```php
$map = new Map();
$map->set('a', 1)->set('b', 2);

$map->set('a', 3);

// size 2, entries [['a', 3], ['b', 2]]
```

---

### `values(): \Generator`

Returns a `Generator` yielding values in insertion order.

```php
$map = new Map([['a', 1], ['b', 2]]);
iterator_to_array($map->values());  // [1, 2]
```

---

## Default iterator

A `Map` is itself iterable and yields `[key, value]` pairs, matching `Map.prototype[Symbol.iterator]`.

```php
$map = new Map([['a', 1], ['b', 2]]);

$entries = [];
foreach ($map as $entry) {
    $entries[] = $entry;
}

// $entries === [['a', 1], ['b', 2]]
```

---

## `thisArg` support

`forEach` accepts a `$thisArg` parameter. Only non-static `Closure` callables are bound to the given object via `Closure::bindTo`; other callable types ignore `$thisArg`.

```php
$map = new Map([['a', 1]]);
$context = new class {
    public int $multiplier = 10;
};

$map->forEach(
    function (int $value, string $key, Map $map): void {
        $map->set($key, $value * $this->multiplier);
    },
    $context,
);

// $map->toArray() === [['a', 10]]
```

---

## Chaining

Methods that return `self` can be chained:

```php
$map = (new Map())
    ->set('a', 1)
    ->set('b', 2)
    ->set('a', 3);

// $map->toArray() === [['a', 3], ['b', 2]]
```

---

## Non-JS helpers

### `toArray(): array`

Returns a plain PHP array copy of the internal entries list, omitting deleted entries.

```php
$map = new Map([['a', 1], ['b', 2]]);
$map->toArray();  // [['a', 1], ['b', 2]]
```
