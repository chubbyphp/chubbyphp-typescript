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

        if (0.0 === $value) {
            return '0';
        }

        return ($value < 0 ? '-' : '').self::formatAbsolute(abs($value));
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

        [$mantissa, $exponent] = explode('E', $raw);

        $digits = str_replace('.', '', rtrim(rtrim($mantissa, '0'), '.'));

        // $value === 0.{$digits} * 10 ** $pointPosition
        $pointPosition = (int) $exponent + 1;

        // fixed notation between 1e-6 and 1e21, exponential notation beyond
        if (-6 < $pointPosition && $pointPosition <= 21) {
            return self::fixedNotation($digits, $pointPosition);
        }

        return self::exponentialNotation($digits, $pointPosition - 1);
    }

    private static function fixedNotation(string $digits, int $pointPosition): string
    {
        $digitCount = \strlen($digits);

        if ($digitCount <= $pointPosition) {
            return $digits.str_repeat('0', $pointPosition - $digitCount);
        }

        return '0.'.str_repeat('0', -$pointPosition).$digits;
    }

    private static function exponentialNotation(string $digits, int $e): string
    {
        $exponentPart = 'e'.(0 <= $e ? '+' : '-').abs($e);

        if (1 === \strlen($digits)) {
            return $digits.$exponentPart;
        }

        return $digits[0].'.'.substr($digits, 1).$exponentPart;
    }
}
