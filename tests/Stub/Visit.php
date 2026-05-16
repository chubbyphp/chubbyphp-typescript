<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

final class Visit implements \JsonSerializable
{
    public int $duration;
    public bool $success;
    public bool $checked = false;
    public float $weight = 0.0;
    public string $label = '';

    public function __construct(int $duration, bool $success)
    {
        $this->duration = $duration;
        $this->success = $success;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'duration' => $this->duration,
            'success' => $this->success,
            'checked' => $this->checked,
            'weight' => $this->weight,
            'label' => $this->label,
        ];
    }
}
