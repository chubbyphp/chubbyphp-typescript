<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

final class Meta implements \JsonSerializable
{
    public int $retries;
    public bool $flagged;

    public function __construct(int $retries, bool $flagged)
    {
        $this->retries = $retries;
        $this->flagged = $flagged;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'retries' => $this->retries,
            'flagged' => $this->flagged,
        ];
    }
}
