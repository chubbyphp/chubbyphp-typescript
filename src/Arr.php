<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

/**
 * @template T
 */
final class Arr implements \Stringable
{
    /** @var list<T> */
    private array $data;

    public function __construct(mixed ...$arguments)
    {
        if ([] === $arguments) {
            $this->data = [];

            return;
        }

        if (1 === \count($arguments)) {
            $argument = $arguments[0];

            if (\is_int($argument)) {
                if (0 > $argument) {
                    throw new RangeError('Invalid array length');
                }

                if ((2 ** 32) - 1 < $argument) {
                    throw new RangeError('Invalid array length');
                }

                $this->data = [];

                for ($i = 0; $i < $arguments[0]; ++$i) {
                    $this->data[] = null;
                }

                return;
            }

            if (\is_float($argument)) {
                throw new RangeError('Invalid array length');
            }
        }

        foreach ($arguments as $argument) {
            $this->data[] = $argument;
        }
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return null|T
     */
    public function at(int $index): mixed
    {
        if (0 > $index) {
            $index = \count($this->data) + $index;
        }

        return $this->data[$index] ?? null;
    }

    /**
     * @return self<T>
     */
    public function concat(mixed ...$items): self
    {
        $result = new self(...$this->data);

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
        $len = \count($this->data);

        $to = $target < 0 ? max($len + $target, 0) : min($target, $len);
        $from = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        $count = min($final - $from, $len - $to);

        if (0 < $count) {
            array_splice($this->data, $to, $count, \array_slice($this->data, $from, $count));
        }

        return $this;
    }

    /**
     * @return \Generator<int, array{int, T}, mixed, void>
     */
    public function entries(): \Generator
    {
        foreach ($this->data as $key => $value) {
            yield $key => [$key, $value];
        }
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     */
    public function every(callable $callback, mixed $thisArg = null): bool
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $len = \count($this->data);

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
     * @param T $value
     *
     * @return self<T>
     */
    public function fill(mixed $value, int $start = 0, ?int $end = null): self
    {
        $len = \count($this->data);

        $k = $start < 0 ? max($len + $start, 0) : min($start, $len);
        $relativeEnd = $end ?? $len;
        $final = $relativeEnd < 0 ? max($len + $relativeEnd, 0) : min($relativeEnd, $len);

        for (; $k < $final; ++$k) {
            $this->data[$k] = $value;
        }

        return $this;
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     *
     * @return self<T>
     */
    public function filter(callable $callback, mixed $thisArg = null): self
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $result = new self();

        $len = \count($this->data);

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

            if ($callback($value, $key, $this)) {
                $result->data[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     *
     * @return null|T
     */
    public function find(callable $callback, mixed $thisArg = null): mixed
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $len = \count($this->data);

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->data[$key] ?? null;

            if ($callback($value, $key, $this)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     */
    public function findIndex(callable $callback, mixed $thisArg = null): int
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $len = \count($this->data);

        for ($key = 0; $key < $len; ++$key) {
            $value = $this->data[$key] ?? null;

            if ($callback($value, $key, $this)) {
                return $key;
            }
        }

        return -1;
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     *
     * @return null|T
     */
    public function findLast(callable $callback, mixed $thisArg = null): mixed
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        for ($k = \count($this->data) - 1; 0 <= $k; --$k) {
            if ($callback($this->data[$k], $k, $this)) {
                return $this->data[$k];
            }
        }

        return null;
    }

    /**
     * @param callable(T, int, self<T>): bool $callback
     */
    public function findLastIndex(callable $callback, mixed $thisArg = null): int
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        for ($k = \count($this->data) - 1; 0 <= $k; --$k) {
            if ($callback($this->data[$k], $k, $this)) {
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
        $result = new self();

        foreach ($this->data as $value) {
            if ($value instanceof self && 0 < $depth) {
                $flattened = $value->flat($depth - 1);

                foreach ($flattened->data as $v) {
                    $result->data[] = $v;
                }
            } else {
                $result->data[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param callable(T, int, self<T>): mixed $callback
     *
     * @return self<T>
     */
    public function flatMap(callable $callback, mixed $thisArg = null): self
    {
        return $this->map($callback, $thisArg)->flat(1);
    }

    /**
     * @param callable(T, int, self<T>): void $callback
     */
    public function forEach(callable $callback, mixed $thisArg = null): void
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $len = \count($this->data);

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
        $len = \count($this->data);

        $k = $fromIndex < 0 ? max($len + $fromIndex, 0) : $fromIndex;

        for (; $k < $len; ++$k) {
            $value = $this->data[$k];

            if ($value === $searchElement) {
                return true;
            }

            // JavaScript numbers do not distinguish int/float the way PHP does.
            if (
                (\is_int($searchElement) || \is_float($searchElement))
                && (\is_int($value) || \is_float($value))
                && !(\is_float($searchElement) && is_nan($searchElement))
                && !(\is_float($value) && is_nan($value))
                && (float) $value === (float) $searchElement
            ) {
                return true;
            }

            // SameValueZero: NaN is equal to NaN (unlike PHP's ===)
            if (\is_float($searchElement) && is_nan($searchElement) && \is_float($value) && is_nan($value)) {
                return true;
            }
        }

        return false;
    }

    public function indexOf(mixed $searchElement = null, int $fromIndex = 0): int
    {
        $len = \count($this->data);

        $k = $fromIndex < 0 ? max($len + $fromIndex, 0) : $fromIndex;

        for (; $k < $len; ++$k) {
            if ($this->data[$k] === $searchElement) {
                return $k;
            }
        }

        return -1;
    }

    public function join(?string $separator = null): string
    {
        $parts = [];

        foreach ($this->data as $value) {
            if (null === $value) {
                $parts[] = '';
            } elseif (\is_bool($value)) {
                $parts[] = $value ? 'true' : 'false';
            } elseif (\is_float($value) && is_nan($value)) {
                $parts[] = 'NaN';
            } elseif (\is_float($value) && is_infinite($value)) {
                $parts[] = $value > 0 ? 'Infinity' : '-Infinity';
            } elseif (\is_array($value)) {
                $parts[] = implode(',', $value);
            } elseif (\is_object($value) && !$value instanceof \Stringable) {
                $parts[] = '[object Object]';
            } else {
                $parts[] = (string) $value;
            }
        }

        return implode($separator ?? ',', $parts);
    }

    /**
     * @return \Generator<int, int, mixed, void>
     */
    public function keys(): \Generator
    {
        foreach ($this->data as $key => $_) {
            yield $key;
        }
    }

    public function lastIndexOf(mixed $searchElement = null, ?int $fromIndex = null): int
    {
        $len = \count($this->data);

        if (0 === $len) {
            return -1;
        }

        $n = $fromIndex ?? $len - 1;
        $k = $n >= 0 ? min($n, $len - 1) : $len + $n;

        for (; $k >= 0; --$k) {
            if ($this->data[$k] === $searchElement) {
                return $k;
            }
        }

        return -1;
    }

    /**
     * @template U
     *
     * @param callable(T, int, self<T>): U $callback
     *
     * @return self<U>
     */
    public function map(callable $callback, mixed $thisArg = null): self
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $result = new self();

        $len = \count($this->data);

        for ($key = 0; $key < $len; ++$key) {
            if (!\array_key_exists($key, $this->data)) {
                continue;
            }

            $value = $this->data[$key];

            $result->data[] = $callback($value, $key, $this);
        }

        return $result;
    }

    public function pop(): mixed
    {
        return array_pop($this->data);
    }

    /**
     * @param T ...$items
     */
    public function push(mixed ...$items): int
    {
        foreach ($items as $item) {
            $this->data[] = $item;
        }

        return \count($this->data);
    }

    /**
     * @template U
     *
     * @param callable(T|U, T, int, self<T>): U $callback
     * @param U                                 $initialValue
     *
     * @return T|U
     */
    public function reduce(callable $callback, mixed $initialValue = null): mixed
    {
        $len = \count($this->data);
        $numArgs = \func_num_args();

        if (0 === $len && 2 > $numArgs) {
            throw new \TypeError('Reduce of empty array with no initial value');
        }

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = 0;
        } else {
            $accumulator = $this->data[0];
            $i = 1;
        }

        for (; $i < $len; ++$i) {
            $accumulator = $callback($accumulator, $this->data[$i], $i, $this);
        }

        return $accumulator;
    }

    /**
     * @template U
     *
     * @param callable(T|U, T, int, self<T>): U $callback
     * @param U                                 $initialValue
     *
     * @return T|U
     */
    public function reduceRight(callable $callback, mixed $initialValue = null): mixed
    {
        $len = \count($this->data);
        $numArgs = \func_num_args();

        if (0 === $len && 2 > $numArgs) {
            throw new \TypeError('Reduce of empty array with no initial value');
        }

        if (2 <= $numArgs) {
            $accumulator = $initialValue;
            $i = $len - 1;
        } else {
            $accumulator = $this->data[$len - 1];
            $i = $len - 2;
        }

        for (; $i >= 0; --$i) {
            $accumulator = $callback($accumulator, $this->data[$i], $i, $this);
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
        $result = $this->data[0] ?? null;
        $this->data = \array_slice($this->data, 1);

        return $result;
    }

    /**
     * @return self<T>
     */
    public function slice(int $start = 0, ?int $end = null): self
    {
        $len = \count($this->data);

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

        $new = new self();
        $new->data = \array_slice($this->data, $start, $end - $start);

        return $new;
    }

    public function some(callable $callback, mixed $thisArg = null): bool
    {
        if (null !== $thisArg && $callback instanceof \Closure) {
            $callback = self::bindCallback($callback, $thisArg);
        }

        $len = \count($this->data);

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
     * @param null|(callable(T, T): int) $callback
     *
     * @return $this
     */
    public function sort(?callable $callback = null): static
    {
        if (null !== $callback) {
            usort($this->data, $callback);
        } else {
            usort($this->data, static fn (mixed $a, mixed $b): int => strcmp((string) $a, (string) $b));
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
        $len = \count($this->data);
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

        $removed = \array_slice($this->data, $start, $deleteCount);

        array_splice($this->data, $start, $deleteCount, $items);

        $result = new self();
        $result->data = $removed;

        return $result;
    }

    /**
     * @param null|array<string, mixed> $options
     */
    public function toLocaleString(?string $locales = null, ?array $options = null): string
    {
        $strings = [];

        foreach ($this->data as $value) {
            if (null === $value) {
                $strings[] = '';
            } elseif (\is_int($value) || \is_float($value)) {
                $strings[] = self::formatNumberToLocale($value, $locales, $options);
            } elseif (\is_object($value) && method_exists($value, 'toLocaleString')) {
                $strings[] = (string) $value->toLocaleString();
            } else {
                $strings[] = (string) $value;
            }
        }

        return implode(',', $strings);
    }

    /**
     * @return self<T>
     */
    public function toReversed(): self
    {
        $new = new self();
        $new->data = array_reverse($this->data);

        return $new;
    }

    /**
     * @param null|(callable(T, T): int) $callback
     *
     * @return self<T>
     */
    public function toSorted(?callable $callback = null): self
    {
        $new = new self();
        $new->data = $this->data;

        if (null !== $callback) {
            usort($new->data, $callback);
        } else {
            usort($new->data, static fn (mixed $a, mixed $b): int => strcmp((string) $a, (string) $b));
        }

        return $new;
    }

    /**
     * @param T ...$items
     *
     * @return self<T>
     */
    public function toSpliced(int $start, ?int $deleteCount = null, mixed ...$items): self
    {
        $len = \count($this->data);

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

        $newData = $this->data;

        array_splice($newData, $start, $deleteCount, $items);

        $result = new self();
        $result->data = $newData;

        return $result;
    }

    public function toString(): string
    {
        return $this->join();
    }

    public function unshift(mixed ...$items): int
    {
        array_splice($this->data, 0, 0, $items);

        return \count($this->data);
    }

    /**
     * @return \Generator<T, mixed, mixed, void>
     */
    public function values(): \Generator
    {
        foreach ($this->data as $value) {
            yield $value;
        }
    }

    /**
     * @param null|array<string, mixed> $options
     */
    private static function formatNumberToLocale(float|int $value, ?string $locales, ?array $options = null): string
    {
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
                    $formatter->setAttribute($attribute, $options[$key]);
                }
            }

            if (isset($options['useGrouping'])) {
                $formatter->setAttribute(\NumberFormatter::GROUPING_USED, (int) $options['useGrouping']);
            }
        }

        if (\NumberFormatter::CURRENCY === $style && isset($options['currency'])) {
            return $formatter->formatCurrency($value, $options['currency']);
        }

        return $formatter->format($value);
    }

    /**
     * @param callable(T, int, self<T>): mixed $callback
     *
     * @return callable(T, int, self<T>): mixed
     */
    private static function bindCallback(callable $callback, mixed $thisArg): callable
    {
        if (null !== $thisArg && $callback instanceof \Closure && !(new \ReflectionFunction($callback))->isStatic()) {
            $bound = $callback->bindTo($thisArg);

            if (null !== $bound) {
                $callback = $bound;
            }
        }

        return $callback;
    }
}
