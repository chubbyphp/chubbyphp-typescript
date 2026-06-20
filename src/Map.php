<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

/**
 * @template K
 * @template V
 *
 * @implements \IteratorAggregate<int, array{0: K, 1: V}>
 *
 * @property int $size
 */
final class Map implements \Countable, \IteratorAggregate
{
    private const INVALID_ENTRY = 'Iterator value is not an entry object';

    /**
     * @var list<null|array{0: K, 1: V}>
     */
    private array $entries = [];

    /**
     * @param null|iterable<int, mixed> $entries
     */
    public function __construct(mixed $entries = null)
    {
        if (null === $entries) {
            return;
        }

        // @phpstan-ignore-next-line is_iterable (runtime guard for mixed input)
        if (!is_iterable($entries)) {
            throw new \TypeError(self::INVALID_ENTRY);
        }

        foreach ($entries as $entry) {
            if (!is_iterable($entry)) {
                throw new \TypeError(self::INVALID_ENTRY);
            }

            $values = self::entryValues($entry);

            if (\count($values) < 2) {
                throw new \TypeError(self::INVALID_ENTRY);
            }

            $this->set($values[0], $values[1]);
        }
    }

    public function __isset(string $name): bool
    {
        return 'size' === $name;
    }

    public function __get(string $name): mixed
    {
        if ('size' === $name) {
            return $this->count();
        }

        trigger_error('Undefined property: Map::$'.$name, E_USER_WARNING);

        return null;
    }

    /**
     * @return non-negative-int
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->entries as $entry) {
            if (null !== $entry) {
                ++$count;
            }
        }

        return $count;
    }

    /**
     * @return \Generator<int, array{0: K, 1: V}, mixed, void>
     */
    public function getIterator(): \Generator
    {
        return $this->entries();
    }

    /**
     * @template GK
     * @template GV
     *
     * @param Arr<GV>|iterable<int, GV> $items
     * @param callable(GV, int): GK     $callback
     *
     * @return self<GK, Arr<GV>>
     */
    public static function groupBy(iterable $items, callable $callback): self
    {
        /** @var self<GK, Arr<GV>> $map */
        $map = new self();

        if ($items instanceof Arr) {
            $length = $items->length;

            for ($i = 0; $i < $length; ++$i) {
                $value = $items[$i];
                $key = $callback($value, $i);
                self::appendToGroup($map, $key, $value);
            }
        } else {
            $i = 0;

            foreach ($items as $value) {
                $key = $callback($value, $i);
                self::appendToGroup($map, $key, $value);
                ++$i;
            }
        }

        return $map;
    }

    public function clear(): void
    {
        $this->entries = [];
    }

    public function delete(mixed $key): bool
    {
        $index = $this->findEntryIndex($key);

        if (null === $index) {
            return false;
        }

        // @phpstan-ignore-next-line (sentinel deletion keeps list shape)
        $this->entries[$index] = null;

        return true;
    }

    /**
     * @return \Generator<int, array{0: K, 1: V}, mixed, void>
     */
    public function entries(): \Generator
    {
        for ($i = 0; $i < \count($this->entries); ++$i) {
            $entry = $this->entries[$i];

            if (null !== $entry) {
                yield $entry;
            }
        }
    }

    /**
     * @param callable(V, K, self<K, V>): void $callback
     */
    public function forEach(callable $callback, ?object $thisArg = null): void
    {
        $callback = self::bindCallback($callback, $thisArg);

        for ($i = 0; $i < \count($this->entries); ++$i) {
            $entry = $this->entries[$i];

            if (null === $entry) {
                continue;
            }

            $callback($entry[1], $entry[0], $this);
        }
    }

    /**
     * @return null|V
     */
    public function get(mixed $key): mixed
    {
        $index = $this->findEntryIndex($key);

        if (null === $index) {
            return null;
        }

        $entry = $this->entryAt($index);

        return $entry[1];
    }

    /**
     * @return V
     */
    public function getOrInsert(mixed $key, mixed $defaultValue): mixed
    {
        $index = $this->findEntryIndex($key);

        if (null !== $index) {
            $entry = $this->entryAt($index);

            return $entry[1];
        }

        $this->set($key, $defaultValue);

        return $defaultValue;
    }

    /**
     * @param callable(K): V $callback
     *
     * @return V
     */
    public function getOrInsertComputed(mixed $key, callable $callback): mixed
    {
        $index = $this->findEntryIndex($key);

        if (null !== $index) {
            $entry = $this->entryAt($index);

            return $entry[1];
        }

        $value = $callback($key);
        $this->set($key, $value);

        return $value;
    }

    public function has(mixed $key): bool
    {
        return null !== $this->findEntryIndex($key);
    }

    /**
     * @return \Generator<int, K, mixed, void>
     */
    public function keys(): \Generator
    {
        for ($i = 0; $i < \count($this->entries); ++$i) {
            $entry = $this->entries[$i];

            if (null !== $entry) {
                yield $entry[0];
            }
        }
    }

    /**
     * @return $this
     */
    public function set(mixed $key, mixed $value): self
    {
        // ECMAScript canonicalizes -0 to +0 for Map keys.
        if (\is_float($key) && !is_nan($key) && '-0' === (string) $key) {
            $key = 0.0;
        }

        $index = $this->findEntryIndex($key);

        if (null !== $index) {
            $entry = $this->entryAt($index);
            $entry[1] = $value;
            // @phpstan-ignore-next-line (preserving list shape; index was returned by findEntryIndex)
            $this->entries[$index] = $entry;
        } else {
            /** @var array{0: K, 1: V} $entry */
            $entry = [$key, $value];
            $this->entries[] = $entry;
        }

        return $this;
    }

    /**
     * @return \Generator<int, V, mixed, void>
     */
    public function values(): \Generator
    {
        for ($i = 0; $i < \count($this->entries); ++$i) {
            $entry = $this->entries[$i];

            if (null !== $entry) {
                yield $entry[1];
            }
        }
    }

    /**
     * @return list<array{0: K, 1: V}>
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->entries as $entry) {
            if (null !== $entry) {
                $result[] = $entry;
            }
        }

        return $result;
    }

    private function findEntryIndex(mixed $key): ?int
    {
        foreach ($this->entries as $index => $entry) {
            if (null !== $entry && self::sameValueZero($entry[0], $key)) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @return array{0: K, 1: V}
     */
    private function entryAt(int $index): array
    {
        $entry = $this->entries[$index];

        if (null === $entry) {
            throw new \RuntimeException('Map entry unexpectedly deleted');
        }

        return $entry;
    }

    private static function sameValueZero(mixed $value, mixed $searchElement): bool
    {
        if (self::strictlyEqual($value, $searchElement)) {
            return true;
        }

        return \is_float($value)
            && is_nan($value)
            && \is_float($searchElement)
            && is_nan($searchElement);
    }

    private static function strictlyEqual(mixed $value, mixed $searchElement): bool
    {
        if ((\is_int($value) || \is_float($value)) && (\is_int($searchElement) || \is_float($searchElement))) {
            return (float) $value === (float) $searchElement;
        }

        return $value === $searchElement;
    }

    private static function bindCallback(callable $callback, ?object $thisArg = null): callable
    {
        if (
            null !== $thisArg
            && $callback instanceof \Closure
            && !(new \ReflectionFunction($callback))->isStatic()
        ) {
            $bound = $callback->bindTo($thisArg);

            if (null !== $bound) {
                $callback = $bound;
            }
        }

        return $callback;
    }

    /**
     * @template GK
     * @template GV
     *
     * @param self<GK, Arr<GV>> $map
     * @param GK                $key
     * @param GV                $value
     */
    private static function appendToGroup(self $map, mixed $key, mixed $value): void
    {
        if ($map->has($key)) {
            /** @var Arr<GV> $group */
            $group = $map->get($key);
            $group->push($value);
        } else {
            $map->set($key, Arr::of($value));
        }
    }

    /**
     * @param iterable<array-key, mixed> $entry
     *
     * @return list<mixed>
     */
    private static function entryValues(iterable $entry): array
    {
        $values = [];

        foreach ($entry as $value) {
            $values[] = $value;

            if (\count($values) >= 2) {
                break;
            }
        }

        return $values;
    }
}
