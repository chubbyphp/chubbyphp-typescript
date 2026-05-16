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
    public Arr $visitLabels;
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
            'byName' => $this->byName,
            'tagCounts' => $this->tagCounts,
            'visitLabels' => $this->visitLabels,
            'users' => $this->users,
        ];
    }
}
