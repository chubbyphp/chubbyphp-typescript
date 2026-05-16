<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

final class HistoryEntry implements \JsonSerializable
{
    public string $step;
    public int $index;
    public int $score;
    public int $randomSeedLikeValue;

    public function __construct(string $step, int $index, int $score, int $randomSeedLikeValue)
    {
        $this->step = $step;
        $this->index = $index;
        $this->score = $score;
        $this->randomSeedLikeValue = $randomSeedLikeValue;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'step' => $this->step,
            'index' => $this->index,
            'score' => $this->score,
            'randomSeedLikeValue' => $this->randomSeedLikeValue,
        ];
    }
}
