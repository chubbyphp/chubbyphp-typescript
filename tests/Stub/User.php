<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

use Chubbyphp\Typescript\Arr;

final class User implements \JsonSerializable
{
    public int $id;
    public string $name;
    public int $score;
    public bool $active;
    public Arr $tags;
    public Arr $visits;
    public Meta $meta;
    public bool $processed = false;
    public int $updatedAt = 0;
    public Arr $history;

    public function __construct(int $id, string $name, int $score, bool $active, Arr $tags, Arr $visits, Meta $meta)
    {
        $this->id = $id;
        $this->name = $name;
        $this->score = $score;
        $this->active = $active;
        $this->tags = $tags;
        $this->visits = $visits;
        $this->meta = $meta;
        $this->history = new Arr();
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'score' => $this->score,
            'active' => $this->active,
            'tags' => $this->tags,
            'visits' => $this->visits,
            'meta' => $this->meta,
            'processed' => $this->processed,
            'updatedAt' => $this->updatedAt,
            'history' => $this->history,
        ];
    }
}
