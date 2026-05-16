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

                /** @var list<null|T> $fill */
                $fill = array_fill(0, $argument, null);
                $this->data = $fill;
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
        }, iterator_to_array($this->values(), false));
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
        }, iterator_to_array($this->values(), false));
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
        $result = new self();
        $result->push(...$this->data);

        foreach ($items as $item) {
            if ($item instanceof self) {
                $result->push(...$item->data);
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
            array_splice(
                $this->data,
                $to,
                $count,
                \array_slice($this->data, $from, $count),
            );
            $this->length = \count($this->data);
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

        $count = $final - $k;
        if (0 < $count) {
            array_splice($this->data, $k, $count, array_fill(0, $count, $value));
            $this->length = max($this->length, \count($this->data));
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

        /** @var list<null|T> $filtered */
        $filtered = array_values(array_filter(
            $this->data,
            fn (mixed $value, int $key): bool => (bool) $callback($value, $key, $this),
            ARRAY_FILTER_USE_BOTH,
        ));

        /** @var self<T> $result */
        $result = new self();

        $result->push(...$filtered);

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
            if (self::strictlyEqual($this->data[$i] ?? null, $searchElement)) {
                return $i;
            }
        }

        return -1;
    }

    public function join(?string $separator = null): string
    {
        return self::mixedToString($this->data, $separator);
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
            if (self::strictlyEqual($this->data[$k] ?? null, $searchElement)) {
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
        $result = new self();

        $len = $this->length;

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

            $result->push($callback($value, $key, $this));
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

        if (0 === $len && 2 > $numArgs) {
            throw new \TypeError('Reduce of empty array with no initial value');
        }

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = 0;
        } else {
            $accumulator = $this->data[0] ?? null;
            $i = 1;
        }

        for (; $i < $len; ++$i) {
            $accumulator = $callback($accumulator, $this->data[$i] ?? null, $i, $this);
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

        if (0 === $len && 2 > $numArgs) {
            throw new \TypeError('Reduce of empty array with no initial value');
        }

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = $len - 1;
        } else {
            $accumulator = $this->data[$len - 1] ?? null;
            $i = $len - 2;
        }

        for (; $i >= 0; --$i) {
            $accumulator = $callback($accumulator, $this->data[$i] ?? null, $i, $this);
        }

        return $accumulator;
    }

    /**
     * @return $this
     */
    public function reverse(): static
    {
        $this->data = array_reverse($this->data);

        return $this;
    }

    public function shift(): mixed
    {
        if (0 === $this->length) {
            return null;
        }

        --$this->length;

        return array_shift($this->data);
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

        /** @var self<T> $new */
        $new = new self();

        if ($start >= $end) {
            return $new;
        }

        /** @var list<null|T> $slice */
        $slice = \array_slice($this->data, $start, $end - $start);

        $new->push(...$slice);

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
        if (null !== $callback) {
            usort($this->data, $callback);
        } else {
            usort(
                $this->data,
                static fn (mixed $a, mixed $b): int => strcmp(
                    self::mixedToString($a),
                    self::mixedToString($b)
                )
            );
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

        /** @var self<T> $new */
        $new = new self();

        /** @var list<null|T> $removed */
        $removed = \array_slice($this->data, $start, $deleteCount);

        array_splice($this->data, $start, $deleteCount, $items);
        $this->length = \count($this->data);

        $new->push(...$removed);

        return $new;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    public function toLocaleString(?string $locales = null, ?array $options = null): string
    {
        return self::mixedToLocaleString($this->data, $locales, $options);
    }

    /**
     * @return self<T>
     */
    public function toReversed(): self
    {
        /** @var self<T> $result */
        $result = new self();

        /** @var list<null|T> $reversed */
        $reversed = array_reverse($this->data);

        $result->push(...$reversed);

        return $result;
    }

    /**
     * @param null|(callable(null|T, null|T): int) $callback
     *
     * @return self<T>
     */
    public function toSorted(?callable $callback = null): self
    {
        /** @var list<null|T> $sorted */
        $sorted = $this->data;

        if (null !== $callback) {
            usort($sorted, $callback);
        } else {
            usort(
                $sorted,
                static fn (mixed $a, mixed $b): int => strcmp(
                    self::mixedToString($a),
                    self::mixedToString($b)
                )
            );
        }

        /** @var self<T> $result */
        $result = new self();

        $result->push(...$sorted);

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

        /** @var list<null|T> $newData */
        $newData = $this->data;

        array_splice($newData, $start, $deleteCount, $items);

        /** @var self<T> $result */
        $result = new self();

        $result->push(...$newData);

        return $result;
    }

    public function toString(): string
    {
        return $this->join();
    }

    public function unshift(mixed ...$items): int
    {
        array_splice($this->data, 0, 0, $items);
        $this->length += \count($items);

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
