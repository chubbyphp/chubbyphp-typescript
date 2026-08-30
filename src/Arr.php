<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

/**
 * @template T
 *
 * @implements \ArrayAccess<array-key, null|T>
 * @implements \IteratorAggregate<int, null|T>
 *
 * @property int $length
 */
final class Arr implements \ArrayAccess, \Countable, \IteratorAggregate, \JsonSerializable, \Stringable
{
    private const INVALID_LENGTH = 'Invalid array length: %s';
    private const DEFAULT_DELIMITER = ',';
    private const MIN_LENGTH = 0;
    private const MAX_LENGTH = (2 ** 32) - 1;

    /**
     * @var array<int, null|T>
     */
    private array $internalArray = [];

    /**
     * @var array<string, mixed>
     */
    private array $internalProperties = [];

    /**
     * @var non-negative-int
     */
    private int $internalLength = 0;

    /**
     * @param null|T ...$arguments
     */
    public function __construct(mixed ...$arguments)
    {
        if (1 === \count($arguments)) {
            $argument = $arguments[0];

            if (\is_float($argument)) {
                if (self::isIntAsFloat($argument)) {
                    $argument = (int) $argument;
                } else {
                    throw new RangeError(\sprintf(self::INVALID_LENGTH, FloatToString::floatToString($argument)));
                }
            }

            if (\is_int($argument)) {
                $length = self::validateLength($argument);

                $this->internalLength = $length;

                return;
            }
        }

        /** @var list<null|T> $arguments */
        $this->internalArray = $arguments;
        $this->internalLength = \count($arguments);
    }

    public function __isset(string $name): bool
    {
        return 'length' === $name;
    }

    public function __get(string $name): mixed
    {
        if ('length' === $name) {
            return $this->internalLength;
        }

        trigger_error('Undefined property: Arr::$'.$name, E_USER_WARNING);

        return null;
    }

    public function __set(string $name, mixed $value): void
    {
        if ('length' !== $name) {
            trigger_error('Undefined property: Arr::$'.$name, E_USER_WARNING);

            return;
        }

        $length = self::validateLength(self::coerceLengthToInt($value));

        $this->truncate($length);
        $this->internalLength = $length;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function offsetExists(mixed $offset): bool
    {
        $offset = self::normalizeOffset($offset);

        if (\is_int($offset)) {
            return \array_key_exists($offset, $this->internalArray);
        }

        return \array_key_exists($offset, $this->internalProperties);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $offset = self::normalizeOffset($offset);

        if (\is_int($offset)) {
            return $this->internalArray[$offset] ?? null;
        }

        return $this->internalProperties[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $offset = $this->internalLength;
        }

        $offset = self::normalizeOffset($offset);

        if (\is_int($offset)) {
            $this->internalArray[$offset] = $value;
            $this->internalLength = max($this->internalLength, $offset + 1);
        } else {
            $this->internalProperties[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        $offset = self::normalizeOffset($offset);

        if (\is_int($offset)) {
            unset($this->internalArray[$offset]);
        } else {
            unset($this->internalProperties[$offset]);
        }
    }

    /**
     * @return non-negative-int
     */
    public function count(): int
    {
        return $this->internalLength;
    }

    /**
     * @return \Generator<int, null|T, mixed, void>
     */
    public function getIterator(): \Generator
    {
        yield from $this->values();
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
     * @phpstan-assert-if-true self<mixed> $value
     */
    public static function isArray(mixed $value): bool
    {
        return $value instanceof self;
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
    public function at(int $i): mixed
    {
        if (0 > $i) {
            $i = $this->internalLength + $i;
        }

        return $this->internalArray[$i] ?? null;
    }

    /**
     * @param null|T ...$items
     *
     * @return self<T>
     */
    public function concat(mixed ...$items): self
    {
        /** @var self<T> $result */
        $result = new self($this->internalLength);
        $result->internalArray = $this->internalArray;

        foreach ($items as $item) {
            if ($item instanceof self) {
                for ($i = 0; $i < $item->internalLength; ++$i) {
                    if (\array_key_exists($i, $item->internalArray)) {
                        $result->internalArray[$result->internalLength] = $item->internalArray[$i];
                    }
                    ++$result->internalLength;
                }
            } else {
                $result->push($item);
            }
        }

        return $result;
    }

    /**
     * @return self<T>
     */
    public function copyWithin(int $target, int $start = 0, ?int $end = null): self
    {
        $len = $this->internalLength;

        $to = self::relativeIndex($target, $len);
        $from = self::relativeIndex($start, $len);
        $final = self::relativeIndex($end ?? $len, $len);

        $count = min($final - $from, $len - $to);

        $copied = $this->slice($from, $from + $count)->internalArray;

        for ($i = 0; $i < $count; ++$i) {
            $toKey = $to + $i;
            if (\array_key_exists($i, $copied)) {
                $this->internalArray[$toKey] = $copied[$i];
            } else {
                unset($this->internalArray[$toKey]);
            }
        }

        return $this;
    }

    /**
     * @return \Generator<int, array{int, null|T}, mixed, void>
     */
    public function entries(): \Generator
    {
        for ($i = 0; $i < $this->internalLength; ++$i) {
            yield [$i, $this->internalArray[$i] ?? null];
        }
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function every(callable $callback, ?object $thisArg = null): bool
    {
        $callback = self::bindCallback($callback, $thisArg);

        foreach ($this->presentEntries() as $i => $value) {
            if (!$callback($value, $i, $this)) {
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

        $final = self::relativeIndex($end ?? $len, $len);

        for ($i = self::relativeIndex($start, $len); $i < $final; ++$i) {
            $this->internalArray[$i] = $value;
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

        foreach ($this->presentEntries() as $i => $value) {
            if ($callback($value, $i, $this)) {
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

        // unlike most iteration methods, find() does not skip holes
        for ($i = 0; $i < $len; ++$i) {
            $value = $this->internalArray[$i] ?? null;

            if ($callback($value, $i, $this)) {
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

        // unlike most iteration methods, findIndex() does not skip holes
        for ($i = 0; $i < $len; ++$i) {
            if ($callback($this->internalArray[$i] ?? null, $i, $this)) {
                return $i;
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

        // unlike most iteration methods, findLast() does not skip holes
        for ($i = $this->internalLength - 1; 0 <= $i; --$i) {
            $value = $this->internalArray[$i] ?? null;

            if ($callback($value, $i, $this)) {
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

        // unlike most iteration methods, findLastIndex() does not skip holes
        for ($i = $this->internalLength - 1; 0 <= $i; --$i) {
            if ($callback($this->internalArray[$i] ?? null, $i, $this)) {
                return $i;
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

        foreach ($this->presentEntries() as $value) {
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

        foreach ($this->presentEntries() as $i => $value) {
            $callback($value, $i, $this);
        }
    }

    public function includes(mixed $searchElement = null, int $fromIndex = 0): bool
    {
        $len = $this->internalLength;

        for ($i = self::relativeIndex($fromIndex, $len); $i < $len; ++$i) {
            $value = $this->internalArray[$i] ?? null;

            if (self::sameValueZero($value, $searchElement)) {
                return true;
            }
        }

        return false;
    }

    public function indexOf(mixed $searchElement = null, int $fromIndex = 0): int
    {
        foreach ($this->presentEntries(self::relativeIndex($fromIndex, $this->internalLength)) as $i => $value) {
            if (self::strictlyEqual($value, $searchElement)) {
                return $i;
            }
        }

        return -1;
    }

    public function join(?string $separator = null): string
    {
        $values = [];

        for ($i = 0; $i < $this->internalLength; ++$i) {
            $values[] = self::mixedToString($this->internalArray[$i] ?? null);
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

        $start = $fromIndex ?? $len;
        if ($start < 0) {
            $start += $len;
        }

        foreach ($this->presentEntriesReversed($start) as $i => $value) {
            if (self::strictlyEqual($value, $searchElement)) {
                return $i;
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

        foreach ($this->presentEntries() as $i => $value) {
            $result->internalArray[$i] = $callback($value, $i, $this);
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
        return $this->reduceEntries($this->presentEntries(), $callback, 2 <= \func_num_args(), $initialValue);
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
        return $this->reduceEntries($this->presentEntriesReversed($this->internalLength), $callback, 2 <= \func_num_args(), $initialValue);
    }

    /**
     * @return $this
     */
    public function reverse(): static
    {
        // key order of internalArray is irrelevant; all reads are index-based
        $reversed = [];
        foreach ($this->internalArray as $i => $value) {
            $reversed[$this->internalLength - 1 - $i] = $value;
        }

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

        foreach ($this->internalArray as $i => $item) {
            if (0 < $i) {
                $newData[$i - 1] = $item;
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

        $start = self::relativeIndex($start, $len);
        $end = self::relativeIndex($end ?? $len, $len);

        /** @var self<T> $new */
        $new = new self(max(0, $end - $start));

        for ($i = $start; $i < $end; ++$i) {
            if (\array_key_exists($i, $this->internalArray)) {
                $new->internalArray[$i - $start] = $this->internalArray[$i];
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

        foreach ($this->presentEntries() as $i => $value) {
            if ($callback($value, $i, $this)) {
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
        // collect values in index order (not internal key order) so the
        // stable sort preserves index order for equal elements, like JS
        $values = [...$this->presentEntries()];

        $this->internalArray = self::sortValues($values, $callback);

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

        $start = self::relativeIndex($start, $len);

        $deleteCount = match (true) {
            2 > $numArgs => $len - $start,
            default => min(max(0, $deleteCount ?? 0), $len - $start),
        };

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

        foreach ($this->internalArray as $i => $value) {
            if ($i < $start) {
                $newData[$i] = $value;
            } elseif ($i >= $start + $deleteCount) {
                $newData[$i + $shift] = $value;
            }
        }

        foreach ($items as $i => $item) {
            $newData[$start + $i] = $item;
        }

        /** @var array<int, null|T> $newData */
        $this->internalArray = $newData;
        $this->internalLength = max(0, $len - $deleteCount + $itemCount);

        return $new;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    public function toLocaleString(?string $locales = null, ?array $options = null): string
    {
        $values = [];

        for ($i = 0; $i < $this->internalLength; ++$i) {
            $values[] = self::mixedToLocaleString(
                $this->internalArray[$i] ?? null,
                $locales,
                $options,
            );
        }

        return implode(self::DEFAULT_DELIMITER, $values);
    }

    /**
     * @return self<T>
     */
    public function toReversed(): self
    {
        $len = $this->internalLength;

        /** @var self<T> $result */
        $result = new self($len);

        // the result is always dense: holes become explicit nulls
        for ($i = 0; $i < $len; ++$i) {
            $result->internalArray[$len - 1 - $i] = $this->internalArray[$i] ?? null;
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
        $len = $this->internalLength;

        // the result is always dense: holes become explicit nulls and are
        // sorted to the end together with the other nulls
        $values = [];
        for ($i = 0; $i < $len; ++$i) {
            $values[$i] = $this->internalArray[$i] ?? null;
        }

        $sorted = self::sortValues($values, $callback);

        /** @var self<T> $result */
        $result = new self($len);

        foreach ($sorted as $i => $value) {
            $result->internalArray[$i] = $value;
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

        /** @var self<T> $result */
        $result = new self($len);

        // the result is always dense: holes become explicit nulls
        for ($i = 0; $i < $len; ++$i) {
            $result->internalArray[$i] = $this->internalArray[$i] ?? null;
        }

        // splice() applies the same start/deleteCount normalization
        if (2 > \func_num_args()) {
            $result->splice($start);
        } else {
            $result->splice($start, $deleteCount, ...$items);
        }

        return $result;
    }

    public function toString(): string
    {
        return $this->join();
    }

    /**
     * @param T ...$items
     */
    public function unshift(mixed ...$items): int
    {
        $items = array_values($items);
        $itemCount = \count($items);
        $newData = [];

        foreach ($items as $i => $item) {
            $newData[$i] = $item;
        }

        foreach ($this->internalArray as $i => $value) {
            $newData[$i + $itemCount] = $value;
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
        for ($i = 0; $i < $this->internalLength; ++$i) {
            yield $this->internalArray[$i] ?? null;
        }
    }

    /**
     * @param T $value
     *
     * @return self<T>
     */
    public function with(int $index, mixed $value): self
    {
        $len = $this->internalLength;

        if ($index < 0) {
            $index = $len + $index;
        }

        if ($index < 0 || $index >= $len) {
            throw new RangeError('Invalid index: '.$index);
        }

        /** @var self<T> $result */
        $result = new self($this->internalLength);

        for ($i = 0; $i < $len; ++$i) {
            $result->internalArray[$i] = ($i === $index) ? $value : ($this->internalArray[$i] ?? null);
        }

        return $result;
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
     * @phpstan-assert-if-true positive-int $offset
     */
    private static function isValidIntegerOffset(int $offset): bool
    {
        return $offset >= self::MIN_LENGTH && $offset < self::MAX_LENGTH;
    }

    /**
     * @phpstan-assert-if-true positive-int $length
     */
    private static function isValidLength(int $length): bool
    {
        return $length >= self::MIN_LENGTH && $length <= self::MAX_LENGTH;
    }

    /**
     * @return non-negative-int
     */
    private static function validateLength(int $length): int
    {
        if (!self::isValidLength($length)) {
            throw new RangeError(\sprintf(self::INVALID_LENGTH, $length));
        }

        return $length;
    }

    private static function mixedToString(mixed $value): string
    {
        return match (true) {
            null === $value => '',
            \is_bool($value) => $value ? 'true' : 'false',
            \is_int($value) => (string) $value,
            \is_float($value) => FloatToString::floatToString($value),
            \is_string($value) => $value,
            $value instanceof \BackedEnum => self::mixedToString($value->value),
            $value instanceof \UnitEnum => $value->name,
            is_iterable($value) => implode(
                self::DEFAULT_DELIMITER,
                array_map(
                    static fn (mixed $value) => self::mixedToString($value),
                    iterator_to_array($value, false),
                ),
            ),
            \is_object($value) && \is_callable([$value, '__toString']) => $value->__toString(),
            \is_object($value) => 'object',
            \is_resource($value) => 'resource',
            default => 'unknown',
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
            // NAN === NAN is false in PHP too, no special casing needed
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
            $value instanceof \BackedEnum => self::mixedToLocaleString($value->value, $locales, $options),
            $value instanceof \UnitEnum => $value->name,
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
            \is_object($value) && \is_callable([$value, 'toLocaleString']) => $value->toLocaleString(),
            \is_object($value) => 'object',
            \is_resource($value) => 'resource',
            default => 'unknown',
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
        // JavaScript moves `undefined` (here: explicit null) values to the end
        // without passing them to the comparator. Holes are appended after that
        // by the caller dropping the trailing indexes.
        $nullCount = 0;
        $defined = [];
        foreach ($values as $value) {
            if (null === $value) {
                ++$nullCount;
            } else {
                $defined[] = $value;
            }
        }

        if (null !== $callback) {
            usort($defined, $callback);
        } else {
            usort(
                $defined,
                static fn (mixed $a, mixed $b): int => strcmp(
                    self::mixedToString($a),
                    self::mixedToString($b)
                )
            );
        }

        $values = $defined;
        for ($i = 0; $i < $nullCount; ++$i) {
            $values[] = null;
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

    private static function normalizeOffset(mixed $offset): int|string
    {
        // all in-range int strings round-trip through float; non-round-trip
        // int strings are far out of range and stay string properties either way
        if (\is_string($offset) && self::isFloatAsString($offset)) {
            $offset = (float) $offset;
        }

        if (\is_float($offset)) {
            $offset = self::normalizeFloatOffset($offset);
        }

        if (\is_int($offset)) {
            return self::isValidIntegerOffset($offset) ? $offset : (string) $offset;
        }

        return \is_string($offset) ? $offset : self::stringifyOffset($offset);
    }

    private static function normalizeFloatOffset(float $offset): float|int|string
    {
        if (self::isIntAsFloat($offset)) {
            return (int) $offset;
        }

        // (string) NAN would trigger a coercion warning in stringifyOffset
        return is_nan($offset) ? 'NAN' : $offset;
    }

    private static function stringifyOffset(mixed $offset): string
    {
        return match (true) {
            \is_bool($offset) => $offset ? 'true' : 'false',
            null === $offset => 'null',
            \is_scalar($offset), $offset instanceof \Stringable => (string) $offset,
            default => throw new InvalidOffsetError('Cannot convert offset to string'),
        };
    }

    private static function coerceLengthToInt(mixed $value): int
    {
        if (\is_bool($value) || null === $value) {
            return (int) $value;
        }

        if (\is_string($value) && self::isIntAsString($value)) {
            return (int) $value;
        }

        if (!\is_int($value)) {
            throw new RangeError('Length needs to be an integer');
        }

        return $value;
    }

    private function truncate(int $length): void
    {
        foreach ($this->internalArray as $i => $_) {
            if ($i >= $length) {
                unset($this->internalArray[$i]);
            }
        }
    }

    /**
     * Yields the present (non-hole) entries in index order; the length is
     * captured up front while presence is checked live, like the JS iteration
     * semantics for callbacks that mutate the array.
     *
     * @return \Generator<int, null|T, mixed, void>
     */
    private function presentEntries(int $start = 0): \Generator
    {
        $len = $this->internalLength;

        for ($i = $start; $i < $len; ++$i) {
            if (\array_key_exists($i, $this->internalArray)) {
                yield $i => $this->internalArray[$i];
            }
        }
    }

    /**
     * Like presentEntries but from min($start, length - 1) down to 0.
     *
     * @return \Generator<int, null|T, mixed, void>
     */
    private function presentEntriesReversed(int $start): \Generator
    {
        for ($i = min($start, $this->internalLength - 1); $i >= 0; --$i) {
            if (\array_key_exists($i, $this->internalArray)) {
                yield $i => $this->internalArray[$i];
            }
        }
    }

    /**
     * @template U
     *
     * @param iterable<int, null|T>                         $entries
     * @param callable((null|T)|U, null|T, int, self<T>): U $callback
     * @param U                                             $accumulator
     *
     * @return (null|T)|U
     */
    private function reduceEntries(iterable $entries, callable $callback, bool $hasInitialValue, mixed $accumulator): mixed
    {
        foreach ($entries as $i => $value) {
            if ($hasInitialValue) {
                $accumulator = $callback($accumulator, $value, $i, $this);
            } else {
                $accumulator = $value;
                $hasInitialValue = true;
            }
        }

        if (!$hasInitialValue) {
            throw new \TypeError('Reduce of empty array with no initial value');
        }

        return $accumulator;
    }

    /**
     * Resolves a possibly negative relative index to an absolute one clamped to [0, $len].
     */
    private static function relativeIndex(int $relative, int $len): int
    {
        return $relative < 0 ? max($len + $relative, 0) : min($relative, $len);
    }

    private static function isFloatAsString(string $string): bool
    {
        return (string) (float) $string === $string;
    }

    private static function isIntAsString(string $string): bool
    {
        return (string) (int) $string === $string;
    }

    private static function isIntAsFloat(float $float): bool
    {
        // (float) PHP_INT_MAX rounds up to 2**63, which is NOT castable to int;
        // the strict < keeps the (int) cast below warning-free. NAN/INF fail both
        // comparisons, -INF fails the first one.
        return $float >= PHP_INT_MIN
            && $float < PHP_INT_MAX
            && (float) (int) $float === $float;
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
