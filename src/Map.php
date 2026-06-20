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

        $entry = $this->entries[$index];
        \assert(null !== $entry);

        return $entry[1];
    }

    public function has(mixed $key): bool
    {
        return null !== $this->findEntryIndex($key);
    }

    /**
     * @return $this
     */
    public function set(mixed $key, mixed $value): self
    {
        $index = $this->findEntryIndex($key);

        if (null !== $index) {
            $entry = $this->entries[$index];
            \assert(null !== $entry);
            $entry[1] = $value;
            $this->entries[$index] = $entry;
        } else {
            /** @var array{0: K, 1: V} $entry */
            $entry = [$key, $value];
            $this->entries[] = $entry;
        }

        return $this;
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
     * @return \Generator<int, array{0: K, 1: V}, mixed, void>
     */
    public function getIterator(): \Generator
    {
        return $this->entries();
    }

    /**
     * @return non-negative-int
     */
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
