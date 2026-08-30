<?php

declare(strict_types=1);

namespace Chubbyphp\Typescript;

final class FloatToString
{
    /**
     * Converts a float to a string following the ECMAScript Number::toString
     * algorithm (shortest round-trip representation).
     */
    public static function floatToString(float $value): string
    {
        if (is_nan($value)) {
            return 'NaN';
        }

        if (is_infinite($value)) {
            return INF === $value ? 'Infinity' : '-Infinity';
        }

        // abs() also normalizes -0.0 to 0.0, so zero never gets a sign
        $absolute = abs($value);

        return ($absolute === $value ? '' : '-').self::formatAbsolute($absolute);
    }

    private static function formatAbsolute(float $value): string
    {
        $raw = var_export($value, true);

        // Integers represented as floats, e.g. 1.0 -> "1.0".
        if (str_ends_with($raw, '.0')) {
            return substr($raw, 0, -2);
        }

        // var_export already emits the correct JS fixed notation for values
        // in the fixed range, such as "0.1" or "123.456".
        if (!str_contains($raw, 'E')) {
            return $raw;
        }

        // var_export always emits a signed exponent, e.g. "1.5E+25" or "1.0E-7"
        [$mantissa, $exponent] = explode('E', $raw);

        // $value === {$digits[0]}.{$digits[1:]} * 10 ** $exponent
        $digits = str_replace('.', '', rtrim($mantissa, '0'));

        return str_starts_with($exponent, '-')
            ? self::formatSmall($digits, (int) $exponent)
            : self::formatLarge($digits, (int) $exponent);
    }

    /**
     * Fixed notation down to 1e-6, exponential notation below.
     */
    private static function formatSmall(string $digits, int $exponent): string
    {
        return -7 < $exponent
            ? '0.'.str_repeat('0', -$exponent - 1).$digits
            : self::exponentialNotation($digits, $exponent);
    }

    /**
     * Fixed notation up to 1e21 (exclusive), exponential notation beyond.
     */
    private static function formatLarge(string $digits, int $exponent): string
    {
        return $exponent < 21
            ? $digits.str_repeat('0', $exponent + 1 - \strlen($digits))
            : self::exponentialNotation($digits, $exponent);
    }

    private static function exponentialNotation(string $digits, int $e): string
    {
        $exponentPart = \sprintf('e%+d', $e);

        if (1 === \strlen($digits)) {
            return $digits.$exponentPart;
        }

        return $digits[0].'.'.substr($digits, 1).$exponentPart;
    }
}
