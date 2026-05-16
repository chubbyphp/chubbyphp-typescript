<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

use Chubbyphp\Typescript\Arr;

final class Dummy
{
    public int $threshold = 10;
    public int $limit = 3;
    public int $target = 2;
    public int $multiplier = 2;
    public string $suffix = '!';

    /** @var list<int> */
    public array $visited = [];

    /**
     * @return callable(int, int, Arr<int>): bool
     */
    public function thresholdCallback(): callable
    {
        return fn (int $value): bool => $value < $this->threshold;
    }

    /**
     * @return callable(int, int, Arr<int>): bool
     */
    public function limitCallback(): callable
    {
        return fn (int $value): bool => $value < $this->limit;
    }

    /**
     * @return callable(mixed, int, Arr<mixed>): bool
     */
    public function targetCallback(): callable
    {
        return fn (mixed $value): bool => $value === $this->target;
    }

    /**
     * @return callable(int, int, Arr<int>): int
     */
    public function multiplierCallback(): callable
    {
        return fn (int $value): int => $value * $this->multiplier;
    }

    /**
     * @return callable(string, int, Arr<string>): Arr<string>
     */
    public function suffixCallback(): callable
    {
        return function (string $value): Arr {
            /** @var Arr<string> $result */
            $result = new Arr();
            $result->push($value.$this->suffix);

            return $result;
        };
    }

    /**
     * @return callable(int, int, Arr<int>): void
     */
    public function visitedCallback(): callable
    {
        return function (int $value): void {
            $this->visited[] = $value;
        };
    }
}
