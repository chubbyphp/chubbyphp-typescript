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

        $sign = $value < 0 ? '-' : '';
        $value = abs($value);

        $raw = var_export($value, true);

        // Integers represented as floats, e.g. 1.0 -> "1.0".
        if (str_ends_with($raw, '.0')) {
            return $sign.substr($raw, 0, -2);
        }

        // var_export already emits the correct JS fixed notation for values
        // in the fixed range, such as "0.1" or "123.456".
        if (!str_contains($raw, 'E')) {
            return $sign.$raw;
        }

        [$mantissa, $exponent] = explode('E', $raw);

        $mantissa = rtrim(rtrim($mantissa, '0'), '.');
        $digits = str_replace('.', '', $mantissa);

        // $value === 0.{$digits} * 10 ** $pointPosition
        $pointPosition = (int) $exponent + 1;
        $digitCount = \strlen($digits);

        // fixed notation between 1e-6 and 1e21, exponential notation beyond
        if (-6 < $pointPosition && $pointPosition <= 21) {
            if ($digitCount <= $pointPosition) {
                return $sign.$digits.str_repeat('0', $pointPosition - $digitCount);
            }

            return $sign.'0.'.str_repeat('0', -$pointPosition).$digits;
        }

        $e = $pointPosition - 1;
        $exponentPart = 'e'.(0 <= $e ? '+' : '-').abs($e);

        if (1 === $digitCount) {
            return $sign.$digits.$exponentPart;
        }

        return $sign.$digits[0].'.'.substr($digits, 1).$exponentPart;
    }
}
