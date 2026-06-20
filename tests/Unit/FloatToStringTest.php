<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\FloatToString;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\Typescript\FloatToString
 *
 * @internal
 */
final class FloatToStringTest extends TestCase
{
    #[DataProvider('provideFloatToStringCases')]
    public function testFloatToString(float $value, string $expected): void
    {
        self::assertSame($expected, FloatToString::floatToString($value));
    }

    /**
     * @return iterable<string, array{0: float, 1: string}>
     */
    public static function provideFloatToStringCases(): iterable
    {
        yield 'nan' => [NAN, 'NaN'];

        yield 'positiveInfinity' => [INF, 'Infinity'];

        yield 'negativeInfinity' => [-INF, '-Infinity'];

        yield 'positiveZero' => [0.0, '0'];

        yield 'negativeZero' => [-0.0, '0'];

        yield 'one' => [1.0, '1'];

        yield 'negativeOne' => [-1.0, '-1'];

        yield 'onePointFive' => [1.5, '1.5'];

        yield 'negativeOnePointFive' => [-1.5, '-1.5'];

        yield 'ten' => [10.0, '10'];

        yield 'negativeTen' => [-10.0, '-10'];

        yield 'oneHundred' => [100.0, '100'];

        yield 'oneTenth' => [0.1, '0.1'];

        yield 'oneFifth' => [0.2, '0.2'];

        yield 'threeTenths' => [0.3, '0.3'];

        yield 'sumOfTenths' => [0.1 + 0.2, '0.30000000000000004'];

        yield 'pi' => [3.141592653589793, '3.141592653589793'];

        yield 'euler' => [2.718281828459045, '2.718281828459045'];

        yield 'oneEminus6' => [1.0E-6, '0.000001'];

        yield 'oneEminus7' => [1.0E-7, '1e-7'];

        yield 'oneEplus20' => [1.0E+20, '100000000000000000000'];

        yield 'oneEplus21' => [1.0E+21, '1e+21'];

        yield 'maxValue' => [1.7976931348623157E+308, '1.7976931348623157e+308'];

        yield 'negativeMaxValue' => [-1.7976931348623157E+308, '-1.7976931348623157e+308'];

        yield 'minValue' => [5.0E-324, '5e-324'];

        yield 'negativeMinValue' => [-5.0E-324, '-5e-324'];

        yield 'smallestNormal' => [2.2250738585072014E-308, '2.2250738585072014e-308'];

        yield 'negativeSmallestNormal' => [-2.2250738585072014E-308, '-2.2250738585072014e-308'];

        yield 'oneEplus308' => [1.0E+308, '1e+308'];

        yield 'oneEplus307' => [1.0E+307, '1e+307'];

        yield 'oneEminus308' => [1.0E-308, '1e-308'];

        yield 'oneEminus309' => [1.0E-309, '1e-309'];

        yield 'integer123456789' => [123456789.0, '123456789'];

        yield 'negativeInteger123456789' => [-123456789.0, '-123456789'];

        yield 'largeInteger' => [1.2345678901234568E+17, '123456789012345680'];

        yield 'decimal12345678901' => [1.2345678901234567, '1.2345678901234567'];

        yield 'decimalAlmostTwo' => [1.9999999999999998, '1.9999999999999998'];

        yield 'decimalOnePlusEpsilon' => [1.0000000000000002, '1.0000000000000002'];

        yield 'decimalJustBelowOne' => [0.9999999999999999, '0.9999999999999999'];

        yield 'smallDecimalFixed' => [1.23456789E-6, '0.00000123456789'];

        yield 'smallDecimalExp' => [1.23456789E-7, '1.23456789e-7'];

        yield 'phi' => [1.618033988749895, '1.618033988749895'];

        yield 'sqrt2' => [1.4142135623730951, '1.4142135623730951'];

        yield 'largeWithFraction' => [9.999999999999999E+20, '999999999999999900000'];

        yield 'billionBillion' => [1.0E+18, '1000000000000000000'];

        yield 'tenTo19' => [1.0E+19, '10000000000000000000'];

        yield 'twoTo53' => [9007199254740992.0, '9007199254740992'];

        yield 'negativeTwoTo53' => [-9007199254740992.0, '-9007199254740992'];

        yield 'zeroPointZeroZeroZeroOne' => [0.0001, '0.0001'];

        yield 'oneMillionth' => [1.0E-6, '0.000001'];

        yield 'tenMillionth' => [1.0E-7, '1e-7'];

        yield 'hundredMillionth' => [1.0E-8, '1e-8'];

        yield 'half' => [0.5, '0.5'];

        yield 'quarter' => [0.25, '0.25'];

        yield 'threeQuarters' => [0.75, '0.75'];

        yield 'twoThirds' => [2.0 / 3.0, '0.6666666666666666'];

        yield 'oneNinth' => [1.0 / 9.0, '0.1111111111111111'];

        yield 'oneEplus22' => [1.0E+22, '1e+22'];

        yield 'oneEplus30' => [1.0E+30, '1e+30'];

        yield 'oneEminus10' => [1.0E-10, '1e-10'];

        yield 'oneEminus20' => [1.0E-20, '1e-20'];

        yield 'oneEminus30' => [1.0E-30, '1e-30'];

        yield 'oneEplus100' => [1.0E+100, '1e+100'];

        yield 'oneEminus100' => [1.0E-100, '1e-100'];

        yield 'oneEplus200' => [1.0E+200, '1e+200'];

        yield 'oneEminus200' => [1.0E-200, '1e-200'];

        yield 'oneEplus300' => [1.0E+300, '1e+300'];

        yield 'oneEminus300' => [1.0E-300, '1e-300'];

        yield 'decimalMultiDigitExp' => [1.23456789E+21, '1.23456789e+21'];

        yield 'smallMultiDigitExp' => [1.23456789E-21, '1.23456789e-21'];

        yield 'largeBoundary999e20' => [9.999999999999999E+20, '999999999999999900000'];

        yield 'phpIntMaxAsFloat' => [(float) PHP_INT_MAX, '9223372036854776000'];

        yield 'phpIntMinAsFloat' => [(float) PHP_INT_MIN, '-9223372036854776000'];

        yield 'maxSafeInteger' => [9007199254740991.0, '9007199254740991'];

        yield 'minSafeInteger' => [-9007199254740991.0, '-9007199254740991'];

        yield 'negativeOneTenth' => [-0.1, '-0.1'];

        yield 'negativeOneEminus6' => [-1.0E-6, '-0.000001'];

        yield 'negativeOneEminus7' => [-1.0E-7, '-1e-7'];

        yield 'negativeOneEplus20' => [-1.0E+20, '-100000000000000000000'];

        yield 'negativeOneEplus21' => [-1.0E+21, '-1e+21'];

        yield 'negativeLargeWithFraction' => [-9.999999999999999E+20, '-999999999999999900000'];

        yield 'negativeDecimalMultiDigitExp' => [-1.23456789E+21, '-1.23456789e+21'];

        yield 'oneThird' => [1.0 / 3.0, '0.3333333333333333'];

        yield 'oneSeventh' => [1.0 / 7.0, '0.14285714285714285'];

        yield 'oneEleventh' => [1.0 / 11.0, '0.09090909090909091'];
    }
}
