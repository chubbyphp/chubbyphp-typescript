<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

use Chubbyphp\Typescript\Arr;

final class Accumulator implements \JsonSerializable
{
    public int $count = 0;
    public int $totalScore = 0;
    public int $totalVisits = 0;
    public int $totalDuration = 0;
    public int $successes = 0;
    public int $failures = 0;
    public float $maxScore = -PHP_FLOAT_MAX;
    public ?string $topUser = null;
    public object $byName;
    public object $tagCounts;

    /** @var Arr<string> */
    public Arr $visitLabels;

    /** @var Arr<User> */
    public Arr $users;

    public function __construct()
    {
        $this->byName = (object) [];
        $this->tagCounts = (object) [];
        $this->visitLabels = new Arr();
        $this->users = new Arr();
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count,
            'totalScore' => $this->totalScore,
            'totalVisits' => $this->totalVisits,
            'totalDuration' => $this->totalDuration,
            'successes' => $this->successes,
            'failures' => $this->failures,
            'maxScore' => $this->maxScore,
            'topUser' => $this->topUser,
            'byName' => array_map(static function ($value) {
                if ($value instanceof \JsonSerializable) {
                    return $value->jsonSerialize();
                }

                return $value;
            }, (array) $this->byName),
            'tagCounts' => array_map(static function ($value) {
                if ($value instanceof \JsonSerializable) {
                    return $value->jsonSerialize();
                }

                return $value;
            }, (array) $this->tagCounts),

            'visitLabels' => $this->visitLabels->jsonSerialize(),
            'users' => $this->users->jsonSerialize(),
        ];
    }
}
