<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

final class PageView
{
    public function __construct(
        public string $page,
        public int $duration,
    ) {}
}
