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

        $sign = '';

        if ($value < 0) {
            $sign = '-';
            $value = -$value;
        }

        // find the shortest round-trip representation in scientific notation
        $repr = \sprintf('%.16e', $value);
        for ($precision = 0; $precision < 16; ++$precision) {
            $candidate = \sprintf('%.'.$precision.'e', $value);
            if ((float) $candidate === $value) {
                $repr = $candidate;

                break;
            }
        }

        [$mantissa, $exponent] = explode('e', $repr);

        $digits = str_replace('.', '', $mantissa);

        // $value === 0.{$digits} * 10 ** $pointPosition
        $pointPosition = (int) $exponent + 1;
        $digitCount = \strlen($digits);

        // fixed notation between 1e-6 and 1e21, exponential notation beyond
        if (-6 < $pointPosition && $pointPosition <= 21) {
            if ($digitCount <= $pointPosition) {
                return $sign.$digits.str_repeat('0', $pointPosition - $digitCount);
            }

            if (0 < $pointPosition) {
                return $sign.substr($digits, 0, $pointPosition).'.'.substr($digits, $pointPosition);
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
