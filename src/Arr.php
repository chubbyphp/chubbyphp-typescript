<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

/**
 * @template T
 *
 * @implements \ArrayAccess<array-key, null|T>
 *
 * @property int $length
 */
final class Arr implements \ArrayAccess, \JsonSerializable, \Stringable
{
    private const RANGE_ERROR_INVALID_LENGTH = 'Invalid array length';
    private const DEFAULT_DELIMITER = ',';

    /**
     * @var array<int, null|T>
     */
    private array $internalArray = [];

    private int $internalLength = 0;

    /**
     * @param null|T ...$arguments
     */
    public function __construct(mixed ...$arguments)
    {
        if (1 === \count($arguments)) {
            $argument = $arguments[0];

            if (\is_int($argument)) {
                if (0 > $argument) {
                    throw new RangeError(self::RANGE_ERROR_INVALID_LENGTH);
                }

                if ((2 ** 32) - 1 < $argument) {
                    throw new RangeError(self::RANGE_ERROR_INVALID_LENGTH);
                }

                $this->internalLength = $argument;

                return;
            }

            if (\is_float($argument)) {
                throw new RangeError(self::RANGE_ERROR_INVALID_LENGTH);
            }
        }

        /** @var list<null|T> $arguments */
        $this->internalArray = $arguments;
        $this->internalLength = \count($arguments);
    }

    public function __get(string $name): mixed
    {
        if ('length' === $name) {
            return $this->internalLength;
        }

        trigger_error('Undefined property: A::$'.$name, E_USER_WARNING);

        return null;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @template U
     *
     * @param iterable<mixed>|self<mixed>|string $items
     * @param null|callable(mixed, int): U       $mapFn
     *
     * @return self<mixed|U>
     */
    public static function from(iterable|self|string $items, ?callable $mapFn = null, ?object $thisArg = null): self
    {
        if ($items instanceof self) {
            $iterable = $items->values();
        } elseif (\is_string($items)) {
            $iterable = preg_split('//u', $items, -1, PREG_SPLIT_NO_EMPTY);

            if (false === $iterable) {
                $iterable = str_split($items);
            }
        } else {
            $iterable = $items;
        }

        if (null !== $mapFn) {
            $mapFn = self::bindCallback($mapFn, $thisArg);
        }

        /** @var self<mixed|U> $result */
        $result = new self();

        $i = 0;
        foreach ($iterable as $value) {
            $result->push(null !== $mapFn ? $mapFn($value, $i) : $value);
            ++$i;
        }

        return $result;
    }

    /**
     * @param null|T ...$arguments
     *
     * @return self<T>
     */
    public static function of(mixed ...$arguments): self
    {
        /** @var self<T> $result */
        $result = new self();
        $result->push(...$arguments);

        return $result;
    }

    /**
     * @return null|T
     */
    public function at(int $index): mixed
    {
        if (0 > $index) {
            $index = $this->internalLength + $index;
        }

        return $this->internalArray[$index] ?? null;
    }

    /**
     * @return self<T>
     */
    public function concat(mixed ...$items): self
    {
        /** @var self<T> $result */
        $result = new self($this->internalLength);
        $result->internalArray = $this->internalArray;

        foreach ($items as $item) {
            if ($item instanceof self) {
                $offset = $result->internalLength;
                foreach ($item->internalArray as $key => $value) {
                    $result->internalArray[$offset + $key] = $value;
                }
                $result->internalLength += $item->internalLength;
            } else {
                $result->push($item);
            }
        }

        return $result;
    }

    /**
     * @return self<T>
     */
    public function copyWithin(int $target, int $start, ?int $end = null): self
    {
        $len = $this->internalLength;

        $to = $target < 0 ? max($len + $target, 0) : min($target, $len);
        $from = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        $count = min($final - $from, $len - $to);

        if (0 < $count) {
            $copied = [];
            for ($i = 0; $i < $count; ++$i) {
                $fromKey = $from + $i;
                if (\array_key_exists($fromKey, $this->internalArray)) {
                    $copied[$i] = $this->internalArray[$fromKey];
                }
            }

            for ($i = 0; $i < $count; ++$i) {
                $toKey = $to + $i;
                if (\array_key_exists($i, $copied)) {
                    $this->internalArray[$toKey] = $copied[$i];
                } else {
                    unset($this->internalArray[$toKey]);
                }
            }
        }

        return $this;
    }

    /**
     * @return \Generator<int, array{int, null|T}, mixed, void>
     */
    public function entries(): \Generator
    {
        for ($key = 0; $key < $this->internalLength; ++$key) {
            yield [$key, $this->internalArray[$key] ?? null];
        }
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function every(callable $callback, ?object $thisArg = null): bool
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->internalArray)) {
                continue;
            }

            $value = $this->internalArray[$key];

            if (!$callback($value, $key, $this)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return self<T>
     */
    public function fill(mixed $value, int $start = 0, ?int $end = null): self
    {
        $len = $this->internalLength;

        $k = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        for (; $k < $final; ++$k) {
            $this->internalArray[$k] = $value;
        }

        return $this;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     *
     * @return self<T>
     */
    public function filter(callable $callback, ?object $thisArg = null): self
    {
        $callback = self::bindCallback($callback, $thisArg);

        /** @var self<T> $result */
        $result = new self();

        $len = $this->internalLength;
        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->internalArray)) {
                continue;
            }

            $value = $this->internalArray[$key];
            if ($callback($value, $key, $this)) {
                $result->push($value);
            }
        }

        return $result;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     *
     * @return null|T
     */
    public function find(callable $callback, ?object $thisArg = null): mixed
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->internalArray[$key] ?? null;

            if ($callback($value, $key, $this)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function findIndex(callable $callback, ?object $thisArg = null): int
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->internalArray[$key] ?? null;

            if ($callback($value, $key, $this)) {
                return $key;
            }
        }

        return -1;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     *
     * @return null|T
     */
    public function findLast(callable $callback, ?object $thisArg = null): mixed
    {
        $callback = self::bindCallback($callback, $thisArg);

        for ($k = $this->internalLength - 1; 0 <= $k; --$k) {
            $value = $this->internalArray[$k] ?? null;

            if ($callback($value, $k, $this)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function findLastIndex(callable $callback, ?object $thisArg = null): int
    {
        $callback = self::bindCallback($callback, $thisArg);

        for ($k = $this->internalLength - 1; 0 <= $k; --$k) {
            if ($callback($this->internalArray[$k] ?? null, $k, $this)) {
                return $k;
            }
        }

        return -1;
    }

    /**
     * @return self<T>
     */
    public function flat(int $depth = 1): self
    {
        /** @var self<T> $result */
        $result = new self();

        foreach ($this->internalArray as $value) {
            if ($value instanceof self && 0 < $depth) {
                foreach ($value->flat($depth - 1)->internalArray as $flattenedValue) {
                    $result->push($flattenedValue);
                }
            } else {
                $result->push($value);
            }
        }

        return $result;
    }

    /**
     * @param callable(null|T, int, self<T>): mixed $callback
     *
     * @return self<mixed>
     */
    public function flatMap(callable $callback, ?object $thisArg = null): self
    {
        return $this->map($callback, $thisArg)->flat(1);
    }

    /**
     * @param callable(null|T, int, self<T>): void $callback
     */
    public function forEach(callable $callback, ?object $thisArg = null): void
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->internalArray)) {
                continue;
            }

            $value = $this->internalArray[$key];

            $callback($value, $key, $this);
        }
    }

    public function includes(mixed $searchElement = null, int $fromIndex = 0): bool
    {
        $len = $this->internalLength;

        $k = $fromIndex < 0 ? max($len + $fromIndex, 0) : $fromIndex;

        for (; $k < $len; ++$k) {
            $value = $this->internalArray[$k] ?? null;

            if (self::sameValueZero($value, $searchElement)) {
                return true;
            }
        }

        return false;
    }

    public function indexOf(mixed $searchElement = null, int $fromIndex = 0): int
    {
        $k = $fromIndex < 0 ? max($this->internalLength + $fromIndex, 0) : $fromIndex;

        for ($i = $k; $i < $this->internalLength; ++$i) {
            if (\array_key_exists($i, $this->internalArray) && self::strictlyEqual($this->internalArray[$i], $searchElement)) {
                return $i;
            }
        }

        return -1;
    }

    public function join(?string $separator = null): string
    {
        $values = [];

        for ($key = 0; $key < $this->internalLength; ++$key) {
            $values[] = self::mixedToString($this->internalArray[$key] ?? null);
        }

        return implode($separator ?? self::DEFAULT_DELIMITER, $values);
    }

    /**
     * @return \Generator<int, int, mixed, void>
     */
    public function keys(): \Generator
    {
        if (0 === $this->internalLength) {
            return;
        }

        yield from range(0, $this->internalLength - 1);
    }

    public function lastIndexOf(mixed $searchElement = null, ?int $fromIndex = null): int
    {
        $len = $this->internalLength;

        if (0 === $len) {
            return -1;
        }

        $n = $fromIndex ?? $len - 1;
        $k = $n >= 0 ? min($n, $len - 1) : $len + $n;

        for (; $k >= 0; --$k) {
            if (\array_key_exists($k, $this->internalArray) && self::strictlyEqual($this->internalArray[$k], $searchElement)) {
                return $k;
            }
        }

        return -1;
    }

    /**
     * @template U
     *
     * @param callable(null|T, int, self<T>): U $callback
     *
     * @return self<U>
     */
    public function map(callable $callback, ?object $thisArg = null): self
    {
        $callback = self::bindCallback($callback, $thisArg);

        /** @var self<U> $result */
        $result = new self($this->internalLength);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->internalArray)) {
                continue;
            }

            $value = $this->internalArray[$key];

            $result->internalArray[$key] = $callback($value, $key, $this);
        }

        return $result;
    }

    public function pop(): mixed
    {
        if (0 === $this->internalLength) {
            return null;
        }

        --$this->internalLength;

        if (!\array_key_exists($this->internalLength, $this->internalArray)) {
            return null;
        }

        $value = $this->internalArray[$this->internalLength];
        unset($this->internalArray[$this->internalLength]);

        return $value;
    }

    /**
     * @param null|T ...$items
     */
    public function push(mixed ...$items): int
    {
        foreach ($items as $item) {
            $this->internalArray[$this->internalLength] = $item;
            ++$this->internalLength;
        }

        return $this->internalLength;
    }

    /**
     * @template U
     *
     * @param callable((null|T)|U, null|T, int, self<T>): U $callback
     * @param U                                             $initialValue
     *
     * @return (null|T)|U
     */
    public function reduce(callable $callback, mixed $initialValue = null): mixed
    {
        $len = $this->internalLength;
        $numArgs = \func_num_args();
        $accumulator = null;

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = 0;
        } else {
            $found = false;
            for ($i = 0; $i < $len; ++$i) {
                if (\array_key_exists($i, $this->internalArray)) {
                    $accumulator = $this->internalArray[$i];
                    $found = true;
                    ++$i;

                    break;
                }
            }

            if (!$found) {
                throw new \TypeError('Reduce of empty array with no initial value ');
            }
        }

        for (; $i < $len; ++$i) {
            if (\array_key_exists($i, $this->internalArray)) {
                $accumulator = $callback($accumulator, $this->internalArray[$i], $i, $this);
            }
        }

        return $accumulator;
    }

    /**
     * @template U
     *
     * @param callable((null|T)|U, null|T, int, self<T>): U $callback
     * @param U                                             $initialValue
     *
     * @return (null|T)|U
     */
    public function reduceRight(callable $callback, mixed $initialValue = null): mixed
    {
        $len = $this->internalLength;
        $numArgs = \func_num_args();
        $accumulator = null;

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = $len - 1;
        } else {
            $found = false;
            for ($i = $len - 1; $i >= 0; --$i) {
                if (\array_key_exists($i, $this->internalArray)) {
                    $accumulator = $this->internalArray[$i];
                    $found = true;
                    --$i;

                    break;
                }
            }

            if (!$found) {
                throw new \TypeError('Reduce of empty array with no initial value ');
            }
        }

        for (; $i >= 0; --$i) {
            if (\array_key_exists($i, $this->internalArray)) {
                $accumulator = $callback($accumulator, $this->internalArray[$i], $i, $this);
            }
        }

        return $accumulator;
    }

    /**
     * @return $this
     */
    public function reverse(): static
    {
        $reversed = [];
        foreach ($this->internalArray as $key => $value) {
            $reversed[$this->internalLength - 1 - $key] = $value;
        }

        ksort($reversed);

        /** @var array<int, null|T> $reversed */
        $this->internalArray = $reversed;

        return $this;
    }

    public function shift(): mixed
    {
        if (0 === $this->internalLength) {
            return null;
        }

        $value = $this->internalArray[0] ?? null;
        $newData = [];

        foreach ($this->internalArray as $key => $item) {
            if (0 < $key) {
                $newData[$key - 1] = $item;
            }
        }

        $this->internalArray = $newData;
        --$this->internalLength;

        return $value;
    }

    /**
     * @return self<T>
     */
    public function slice(int $start = 0, ?int $end = null): self
    {
        $len = $this->internalLength;

        if (null === $end) {
            $end = $len;
        } elseif ($end < 0) {
            $end = max(0, $len + $end);
        }

        if ($start < 0) {
            $start = max(0, $len + $start);
        }

        if ($start > $len) {
            $start = $len;
        }

        if ($end > $len) {
            $end = $len;
        }

        if ($start >= $end) {
            return new self();
        }

        /** @var self<T> $new */
        $new = new self($end - $start);

        for ($key = $start; $key < $end; ++$key) {
            if (\array_key_exists($key, $this->internalArray)) {
                $new->internalArray[$key - $start] = $this->internalArray[$key];
            }
        }

        return $new;
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function some(callable $callback, ?object $thisArg = null): bool
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->internalLength;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->internalArray)) {
                continue;
            }

            $value = $this->internalArray[$key];

            if ($callback($value, $key, $this)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param null|(callable(null|T, null|T): int) $callback
     *
     * @return $this
     */
    public function sort(?callable $callback = null): static
    {
        $this->internalArray = self::sortValues($this->internalArray, $callback);

        return $this;
    }

    /**
     * @param T ...$items
     *
     * @return self<T>
     */
    public function splice(int $start, ?int $deleteCount = null, mixed ...$items): self
    {
        $len = $this->internalLength;
        $numArgs = \func_num_args();

        if ($start < 0) {
            $start = max(0, $len + $start);
        }

        if ($start > $len) {
            $start = $len;
        }

        if (2 > $numArgs) {
            $deleteCount = $len - $start;
        } elseif (0 > $deleteCount) {
            $deleteCount = 0;
        } elseif (null === $deleteCount) {
            $deleteCount = 0;
        }

        $deleteCount = min($deleteCount, $len - $start);

        /** @var self<T> $new */
        $new = new self($deleteCount);

        for ($i = 0; $i < $deleteCount; ++$i) {
            if (\array_key_exists($start + $i, $this->internalArray)) {
                $new->internalArray[$i] = $this->internalArray[$start + $i];
            }
        }

        $items = array_values($items);
        $itemCount = \count($items);
        $shift = $itemCount - $deleteCount;
        $newData = [];

        foreach ($this->internalArray as $key => $value) {
            if ($key < $start) {
                $newData[$key] = $value;
            } elseif ($key >= $start + $deleteCount) {
                $newData[$key + $shift] = $value;
            }
        }

        foreach ($items as $i => $item) {
            $newData[$start + $i] = $item;
        }

        ksort($newData);

        /** @var array<int, null|T> $newData */
        $this->internalArray = $newData;
        $this->internalLength = $len - $deleteCount + $itemCount;

        return $new;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    public function toLocaleString(?string $locales = null, ?array $options = null): string
    {
        $values = [];

        for ($key = 0; $key < $this->internalLength; ++$key) {
            $values[] = self::mixedToLocaleString($this->internalArray[$key] ?? null, $locales, $options);
        }

        return implode(self::DEFAULT_DELIMITER, $values);
    }

    /**
     * @return self<T>
     */
    public function toReversed(): self
    {
        /** @var self<T> $result */
        $result = new self($this->internalLength);

        foreach ($this->internalArray as $key => $value) {
            $result->internalArray[$this->internalLength - 1 - $key] = $value;
        }

        return $result;
    }

    /**
     * @param null|(callable(null|T, null|T): int) $callback
     *
     * @return self<T>
     */
    public function toSorted(?callable $callback = null): self
    {
        $sorted = self::sortValues($this->internalArray, $callback);

        /** @var self<T> $result */
        $result = new self($this->internalLength);

        foreach ($sorted as $key => $value) {
            $result->internalArray[$key] = $value;
        }

        return $result;
    }

    /**
     * @param T ...$items
     *
     * @return self<T>
     */
    public function toSpliced(int $start, ?int $deleteCount = null, mixed ...$items): self
    {
        $len = $this->internalLength;

        if ($start < 0) {
            $start = max(0, $len + $start);
        }

        if ($start > $len) {
            $start = $len;
        }

        if (2 > \func_num_args()) {
            $deleteCount = $len - $start;
        } else {
            if (null === $deleteCount) {
                $deleteCount = 0;
            }

            $deleteCount = max(0, min($deleteCount, $len - $start));
        }

        /** @var self<T> $result */
        $result = new self($this->internalLength);
        $result->internalArray = $this->internalArray;
        $result->splice($start, $deleteCount, ...$items);

        return $result;
    }

    public function toString(): string
    {
        return $this->join();
    }

    public function unshift(mixed ...$items): int
    {
        $items = array_values($items);
        $itemCount = \count($items);
        $newData = [];

        foreach ($items as $key => $item) {
            $newData[$key] = $item;
        }

        foreach ($this->internalArray as $key => $value) {
            $newData[$key + $itemCount] = $value;
        }

        $this->internalArray = $newData;
        $this->internalLength += $itemCount;

        return $this->internalLength;
    }

    /**
     * @return \Generator<int, null|T, mixed, void>
     */
    public function values(): \Generator
    {
        for ($key = 0; $key < $this->internalLength; ++$key) {
            yield $this->internalArray[$key] ?? null;
        }
    }

    /**
     * @return list<mixed>
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->values() as $value) {
            $result[] = $value instanceof self ? $value->toArray() : $value;
        }

        return $result;
    }

    /**
     * @return list<mixed>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        foreach ($this->values() as $value) {
            $result[] = $value instanceof \JsonSerializable ? $value->jsonSerialize() : $value;
        }

        return $result;
    }

    public function offsetExists(mixed $offset): bool
    {
        return \is_int($offset) && \array_key_exists($offset, $this->internalArray);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!\is_int($offset)) {
            return null;
        }

        return $this->internalArray[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $this->internalArray[$this->internalLength] = $value;
            ++$this->internalLength;

            return;
        }

        if (!\is_int($offset) || 0 > $offset) {
            return;
        }

        $this->internalArray[$offset] = $value;
        $this->internalLength = max($this->internalLength, $offset + 1);
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!\is_int($offset)) {
            return;
        }

        unset($this->internalArray[$offset]);
    }

    private static function mixedToString(mixed $value): string
    {
        return match (true) {
            null === $value => '',
            \is_bool($value) => $value ? 'true' : 'false',
            \is_int($value) => (string) $value,
            \is_float($value) && is_infinite($value) => $value > 0 ? 'Infinity' : '-Infinity',
            \is_float($value) => \sprintf('%.17g', $value),
            \is_string($value) => $value,
            \is_object($value) && \is_callable([$value, '__toString']) => $value->__toString(),
            is_iterable($value) => implode(
                self::DEFAULT_DELIMITER,
                array_map(
                    static fn (mixed $value) => self::mixedToString($value),
                    iterator_to_array($value, false),
                ),
            ),
            default => '[object Object]',
        };
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
            if (\is_float($value) && is_nan($value)) {
                return false;
            }

            if (\is_float($searchElement) && is_nan($searchElement)) {
                return false;
            }

            return (float) $value === (float) $searchElement;
        }

        return $value === $searchElement;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    private static function mixedToLocaleString(mixed $value, ?string $locales, ?array $options): string
    {
        return match (true) {
            null === $value => '',
            \is_bool($value) => $value ? 'true' : 'false',
            \is_int($value) || \is_float($value) => self::formatNumberToLocale($value, $locales, $options),
            \is_string($value) => $value,
            \is_object($value) && \is_callable([$value, 'toLocaleString']) => $value->toLocaleString(),
            is_iterable($value) => implode(
                self::DEFAULT_DELIMITER,
                array_map(
                    static fn (mixed $value) => self::mixedToLocaleString(
                        $value,
                        $locales,
                        $options,
                    ),
                    iterator_to_array($value, false),
                ),
            ),
            default => '[object Object]',
        };
    }

    /**
     * @param array<int, mixed>                    $values
     * @param null|(callable(null|T, null|T): int) $callback
     *
     * @return array<int, mixed>
     */
    private static function sortValues(array $values, ?callable $callback = null): array
    {
        if (null !== $callback) {
            usort($values, $callback);
        } else {
            usort(
                $values,
                static fn (mixed $a, mixed $b): int => strcmp(
                    self::mixedToString($a),
                    self::mixedToString($b)
                )
            );
        }

        return $values;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    private static function formatNumberToLocale(
        float|int $value,
        ?string $locales,
        ?array $options = null
    ): string {
        $locale = $locales ?? \Locale::getDefault();

        $style = \NumberFormatter::DECIMAL;

        if (null !== $options) {
            $style = match ($options['style'] ?? 'decimal') {
                'percent' => \NumberFormatter::PERCENT,
                'currency' => \NumberFormatter::CURRENCY,
                default => \NumberFormatter::DECIMAL,
            };
        }

        $formatter = new \NumberFormatter($locale, $style);

        if (null !== $options) {
            self::applyNumberFormatterOptions($formatter, $options);
        }

        if (\NumberFormatter::CURRENCY === $style && isset($options['currency'])) {
            $currency = $options['currency'];
            if (!\is_string($currency)) {
                throw new NumberFormatError('Number formatting failed');
            }
            $result = $formatter->formatCurrency($value, $currency);
            if (false === $result) {
                throw new NumberFormatError('Number formatting failed');
            }

            return $result;
        }

        // @phpstan-ignore-next-line return.type (unreachable: Format never returns false in PHP 8.5+ICU 74.2)
        return $formatter->format($value);
    }

    /**
     * @param array<string, mixed> $options
     */
    private static function applyNumberFormatterOptions(\NumberFormatter $formatter, array $options): void
    {
        foreach (
            [
                'minimumFractionDigits',
                'maximumFractionDigits',
                'minimumIntegerDigits',
                'maximumIntegerDigits',
                'minimumSignificantDigits',
                'maximumSignificantDigits',
            ] as $key
        ) {
            if (isset($options[$key])) {
                $attribute = match ($key) {
                    'minimumFractionDigits' => \NumberFormatter::MIN_FRACTION_DIGITS,
                    'maximumFractionDigits' => \NumberFormatter::MAX_FRACTION_DIGITS,
                    'minimumIntegerDigits' => \NumberFormatter::MIN_INTEGER_DIGITS,
                    'maximumIntegerDigits' => \NumberFormatter::MAX_INTEGER_DIGITS,
                    'minimumSignificantDigits' => \NumberFormatter::MIN_SIGNIFICANT_DIGITS,
                    'maximumSignificantDigits' => \NumberFormatter::MAX_SIGNIFICANT_DIGITS,
                };
                $attrValue = $options[$key];
                if (\is_int($attrValue) || \is_float($attrValue)) {
                    $formatter->setAttribute($attribute, $attrValue);
                }
            }
        }

        if (isset($options['useGrouping'])) {
            $grouping = $options['useGrouping'];
            if (\is_bool($grouping)) {
                $formatter->setAttribute(\NumberFormatter::GROUPING_USED, (int) $grouping);
            } elseif (\is_int($grouping)) {
                $formatter->setAttribute(\NumberFormatter::GROUPING_USED, $grouping);
            }
        }
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
}
