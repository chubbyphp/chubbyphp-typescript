<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Stub;

use Chubbyphp\Typescript\Arr;

final class Session
{
    /**
     * @param Arr<PageView> $pageViews
     */
    public function __construct(
        public int $userId,
        public Arr $pageViews,
    ) {}
}
