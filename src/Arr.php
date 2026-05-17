<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

/**
 * @template T
 *
 * @implements \ArrayAccess<array-key, null|T>
 */
final class Arr implements \ArrayAccess, \JsonSerializable, \Stringable
{
    private const RANGE_ERROR_INVALID_LENGTH = 'Invalid array length';

    public int $length = 0;

    /**
     * @var array<int, null|T>
     */
    private array $data = [];

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

                $this->length = $argument;

                return;
            }

            if (\is_float($argument)) {
                throw new RangeError(self::RANGE_ERROR_INVALID_LENGTH);
            }
        }

        /** @var list<null|T> $arguments */
        $this->data = $arguments;
        $this->length = \count($arguments);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return list<mixed>
     */
    public function jsonSerialize(): array
    {
        return array_map(static function (mixed $value): mixed {
            if ($value instanceof \JsonSerializable) {
                return $value->jsonSerialize();
            }

            return $value;
        }, iterator_to_array($this->values()));
    }

    /**
     * @return list<mixed>
     */
    public function toArray(): array
    {
        return array_map(static function (mixed $value): mixed {
            if ($value instanceof self) {
                return $value->toArray();
            }

            return $value;
        }, iterator_to_array($this->values()));
    }

    /**
     * @return null|T
     */
    public function at(int $index): mixed
    {
        if (0 > $index) {
            $index = $this->length + $index;
        }

        return $this->data[$index] ?? null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return \is_int($offset) && \array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!\is_int($offset)) {
            return null;
        }

        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $this->data[$this->length] = $value;
            ++$this->length;

            return;
        }

        if (!\is_int($offset) || 0 > $offset) {
            return;
        }

        $this->data[$offset] = $value;
        $this->length = max($this->length, $offset + 1);
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!\is_int($offset)) {
            return;
        }

        unset($this->data[$offset]);
    }

    /**
     * @return self<T>
     */
    public function concat(mixed ...$items): self
    {
        /** @var self<T> $result */
        $result = new self($this->length);
        $result->data = $this->data;

        foreach ($items as $item) {
            if ($item instanceof self) {
                $offset = $result->length;
                foreach ($item->data as $key => $value) {
                    $result->data[$offset + $key] = $value;
                }
                $result->length += $item->length;
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
        $len = $this->length;

        $to = $target < 0 ? max($len + $target, 0) : min($target, $len);
        $from = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        $count = min($final - $from, $len - $to);

        if (0 < $count) {
            $copied = [];
            for ($i = 0; $i < $count; ++$i) {
                $fromKey = $from + $i;
                if (\array_key_exists($fromKey, $this->data)) {
                    $copied[$i] = $this->data[$fromKey];
                }
            }

            for ($i = 0; $i < $count; ++$i) {
                $toKey = $to + $i;
                if (\array_key_exists($i, $copied)) {
                    $this->data[$toKey] = $copied[$i];
                } else {
                    unset($this->data[$toKey]);
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
        for ($key = 0; $key < $this->length; ++$key) {
            yield [$key, $this->data[$key] ?? null];
        }
    }

    /**
     * @param callable(null|T, int, self<T>): bool $callback
     */
    public function every(callable $callback, ?object $thisArg = null): bool
    {
        $callback = self::bindCallback($callback, $thisArg);

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

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
        $len = $this->length;

        $k = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        for (; $k < $final; ++$k) {
            $this->data[$k] = $value;
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

        $len = $this->length;
        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];
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

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->data[$key] ?? null;

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

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->data[$key] ?? null;

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

        for ($k = $this->length - 1; 0 <= $k; --$k) {
            $value = $this->data[$k] ?? null;

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

        for ($k = $this->length - 1; 0 <= $k; --$k) {
            if ($callback($this->data[$k] ?? null, $k, $this)) {
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

        foreach ($this->data as $value) {
            if ($value instanceof self && 0 < $depth) {
                foreach ($value->flat($depth - 1)->data as $flattenedValue) {
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

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

            $callback($value, $key, $this);
        }
    }

    public function includes(mixed $searchElement = null, int $fromIndex = 0): bool
    {
        $len = $this->length;

        $k = $fromIndex < 0 ? max($len + $fromIndex, 0) : $fromIndex;

        for (; $k < $len; ++$k) {
            $value = $this->data[$k] ?? null;

            if (self::sameValueZero($value, $searchElement)) {
                return true;
            }
        }

        return false;
    }

    public function indexOf(mixed $searchElement = null, int $fromIndex = 0): int
    {
        $k = $fromIndex < 0 ? max($this->length + $fromIndex, 0) : $fromIndex;

        for ($i = $k; $i < $this->length; ++$i) {
            if (\array_key_exists($i, $this->data) && self::strictlyEqual($this->data[$i], $searchElement)) {
                return $i;
            }
        }

        return -1;
    }

    public function join(?string $separator = null): string
    {
        $values = [];

        for ($key = 0; $key < $this->length; ++$key) {
            $values[] = self::mixedToString($this->data[$key] ?? null);
        }

        return implode($separator ?? ',', $values);
    }

    /**
     * @return \Generator<int, int, mixed, void>
     */
    public function keys(): \Generator
    {
        if (0 === $this->length) {
            return;
        }

        yield from range(0, $this->length - 1);
    }

    public function lastIndexOf(mixed $searchElement = null, ?int $fromIndex = null): int
    {
        $len = $this->length;

        if (0 === $len) {
            return -1;
        }

        $n = $fromIndex ?? $len - 1;
        $k = $n >= 0 ? min($n, $len - 1) : $len + $n;

        for (; $k >= 0; --$k) {
            if (\array_key_exists($k, $this->data) && self::strictlyEqual($this->data[$k], $searchElement)) {
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
        $result = new self($this->length);

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

            $result->data[$key] = $callback($value, $key, $this);
        }

        return $result;
    }

    public function pop(): mixed
    {
        if (0 === $this->length) {
            return null;
        }

        --$this->length;

        if (!\array_key_exists($this->length, $this->data)) {
            return null;
        }

        $value = $this->data[$this->length];
        unset($this->data[$this->length]);

        return $value;
    }

    /**
     * @param null|T ...$items
     */
    public function push(mixed ...$items): int
    {
        foreach ($items as $item) {
            $this->data[$this->length] = $item;
            ++$this->length;
        }

        return $this->length;
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
        $len = $this->length;
        $numArgs = \func_num_args();
        $accumulator = null;

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = 0;
        } else {
            $found = false;
            for ($i = 0; $i < $len; ++$i) {
                if (\array_key_exists($i, $this->data)) {
                    $accumulator = $this->data[$i];
                    $found = true;
                    ++$i;

                    break;
                }
            }

            if (!$found) {
                throw new \TypeError('Reduce of empty array with no initial value');
            }
        }

        for (; $i < $len; ++$i) {
            if (\array_key_exists($i, $this->data)) {
                $accumulator = $callback($accumulator, $this->data[$i], $i, $this);
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
        $len = $this->length;
        $numArgs = \func_num_args();
        $accumulator = null;

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = $len - 1;
        } else {
            $found = false;
            for ($i = $len - 1; $i >= 0; --$i) {
                if (\array_key_exists($i, $this->data)) {
                    $accumulator = $this->data[$i];
                    $found = true;
                    --$i;

                    break;
                }
            }

            if (!$found) {
                throw new \TypeError('Reduce of empty array with no initial value');
            }
        }

        for (; $i >= 0; --$i) {
            if (\array_key_exists($i, $this->data)) {
                $accumulator = $callback($accumulator, $this->data[$i], $i, $this);
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
        foreach ($this->data as $key => $value) {
            $reversed[$this->length - 1 - $key] = $value;
        }

        ksort($reversed);

        /** @var array<int, null|T> $reversed */
        $this->data = $reversed;

        return $this;
    }

    public function shift(): mixed
    {
        if (0 === $this->length) {
            return null;
        }

        $value = $this->data[0] ?? null;
        $newData = [];

        foreach ($this->data as $key => $item) {
            if (0 < $key) {
                $newData[$key - 1] = $item;
            }
        }

        $this->data = $newData;
        --$this->length;

        return $value;
    }

    /**
     * @return self<T>
     */
    public function slice(int $start = 0, ?int $end = null): self
    {
        $len = $this->length;

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
            if (\array_key_exists($key, $this->data)) {
                $new->data[$key - $start] = $this->data[$key];
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

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

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
        $sorted = array_values($this->data);
        self::sortValues($sorted, $callback);

        $this->data = [];
        foreach ($sorted as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @param T ...$items
     *
     * @return self<T>
     */
    public function splice(int $start, ?int $deleteCount = null, mixed ...$items): self
    {
        $len = $this->length;
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
            if (\array_key_exists($start + $i, $this->data)) {
                $new->data[$i] = $this->data[$start + $i];
            }
        }

        $items = array_values($items);
        $itemCount = \count($items);
        $shift = $itemCount - $deleteCount;
        $newData = [];

        foreach ($this->data as $key => $value) {
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
        $this->data = $newData;
        $this->length = $len - $deleteCount + $itemCount;

        return $new;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    public function toLocaleString(?string $locales = null, ?array $options = null): string
    {
        $values = [];

        for ($key = 0; $key < $this->length; ++$key) {
            $values[] = self::mixedToLocaleString($this->data[$key] ?? null, $locales, $options);
        }

        return implode(',', $values);
    }

    /**
     * @return self<T>
     */
    public function toReversed(): self
    {
        /** @var self<T> $result */
        $result = new self($this->length);

        foreach ($this->data as $key => $value) {
            $result->data[$this->length - 1 - $key] = $value;
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
        $sorted = array_values($this->data);
        self::sortValues($sorted, $callback);

        /** @var self<T> $result */
        $result = new self($this->length);

        foreach ($sorted as $key => $value) {
            $result->data[$key] = $value;
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
        $len = $this->length;

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
        $result = new self($this->length);
        $result->data = $this->data;
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

        foreach ($this->data as $key => $value) {
            $newData[$key + $itemCount] = $value;
        }

        $this->data = $newData;
        $this->length += $itemCount;

        return $this->length;
    }

    /**
     * @return \Generator<int, null|T, mixed, void>
     */
    public function values(): \Generator
    {
        for ($key = 0; $key < $this->length; ++$key) {
            yield $this->data[$key] ?? null;
        }
    }

    private static function mixedToString(mixed $value, ?string $separator = null): string
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
                $separator ?? ',',
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
    private static function mixedToLocaleString(mixed $value, ?string $locales, ?array $options, ?string $separator = null): string
    {
        return match (true) {
            null === $value => '',
            \is_bool($value) => $value ? 'true' : 'false',
            \is_int($value) || \is_float($value) => self::formatNumberToLocale($value, $locales, $options),
            \is_string($value) => $value,
            \is_object($value) && \is_callable([$value, 'toLocaleString']) => $value->toLocaleString(),
            is_iterable($value) => implode(
                $separator ?? ',',
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
     */
    private static function sortValues(array &$values, ?callable $callback = null): void
    {
        if (null !== $callback) {
            usort($values, $callback);

            return;
        }

        usort(
            $values,
            static fn (mixed $a, mixed $b): int => strcmp(
                self::mixedToString($a),
                self::mixedToString($b)
            )
        );
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
