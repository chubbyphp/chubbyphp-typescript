<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Integration;

use Chubbyphp\Tests\Typescript\Stub\PageView;
use Chubbyphp\Tests\Typescript\Stub\Session;
use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class MapProcessingTest extends TestCase
{
    /**
     * TypeScript example:
     *
     * type PageView = { page: string; duration: number };
     * type Session = { userId: number; pageViews: PageView[] };
     *
     * const sessions: Session[] = [
     *   { userId: 1, pageViews: [{ page: 'home', duration: 10 }, { page: 'pricing', duration: 30 }] },
     *   { userId: 2, pageViews: [{ page: 'home', duration: 5 }, { page: 'docs', duration: 60 }] },
     *   { userId: 1, pageViews: [{ page: 'checkout', duration: 20 }] },
     * ];
     *
     * const pageStats = new Map<string, { count: number; totalDuration: number }>();
     * const userStats = new Map<number, { visitCount: number; totalDuration: number }>();
     *
     * sessions.forEach(session => {
     *   let user = userStats.get(session.userId);
     *   if (!user) {
     *     user = { visitCount: 0, totalDuration: 0 };
     *     userStats.set(session.userId, user);
     *   }
     *
     *   session.pageViews.forEach(view => {
     *     user.visitCount += 1;
     *     user.totalDuration += view.duration;
     *
     *     let page = pageStats.get(view.page);
     *     if (!page) {
     *       page = { count: 0, totalDuration: 0 };
     *       pageStats.set(view.page, page);
     *     }
     *     page.count += 1;
     *     page.totalDuration += view.duration;
     *   });
     * });
     *
     * const averageDurations = new Map<string, number>();
     * pageStats.forEach((stats, page) => {
     *   averageDurations.set(page, stats.totalDuration / stats.count);
     * });
     *
     * const sortedPages = Array.from(pageStats.entries())
     *   .sort((a, b) => b[1].totalDuration - a[1].totalDuration)
     *   .map(([page]) => page);
     */
    public function testSessionAnalyticsPipeline(): void
    {
        $sessions = new Arr(
            new Session(1, new Arr(
                new PageView('home', 10),
                new PageView('pricing', 30),
            )),
            new Session(2, new Arr(
                new PageView('home', 5),
                new PageView('docs', 60),
            )),
            new Session(1, new Arr(
                new PageView('checkout', 20),
            )),
        );

        /** @var Map<string, \stdClass> $pageStats */
        $pageStats = new Map();

        /** @var Map<int, \stdClass> $userStats */
        $userStats = new Map();

        foreach ($sessions->values() as $session) {
            $user = $userStats->get($session->userId);

            if (null === $user) {
                $user = (object) ['visitCount' => 0, 'totalDuration' => 0];
                $userStats->set($session->userId, $user);
            }

            foreach ($session->pageViews->values() as $view) {
                ++$user->visitCount;
                $user->totalDuration += $view->duration;

                $page = $pageStats->get($view->page);

                if (null === $page) {
                    $page = (object) ['count' => 0, 'totalDuration' => 0];
                    $pageStats->set($view->page, $page);
                }

                ++$page->count;
                $page->totalDuration += $view->duration;
            }
        }

        /** @var Map<string, float> $averageDurations */
        $averageDurations = new Map();

        $pageStats->forEach(static function (\stdClass $stats, string $page) use ($averageDurations): void {
            $averageDurations->set($page, (float) ($stats->totalDuration / $stats->count));
        });

        $sortedPages = Arr::from($pageStats->entries())
            ->sort(static fn (array $a, array $b): int => $b[1]->totalDuration <=> $a[1]->totalDuration)
            ->map(static fn (array $entry): string => $entry[0])
            ->values()
        ;

        self::assertSame(2, $userStats->size);
        self::assertSame(4, $pageStats->size);

        self::assertSame(3, $userStats->get(1)->visitCount);
        self::assertSame(60, $userStats->get(1)->totalDuration);
        self::assertSame(2, $userStats->get(2)->visitCount);
        self::assertSame(65, $userStats->get(2)->totalDuration);

        self::assertSame(2, $pageStats->get('home')->count);
        self::assertSame(15, $pageStats->get('home')->totalDuration);
        self::assertSame(1, $pageStats->get('pricing')->count);
        self::assertSame(30, $pageStats->get('pricing')->totalDuration);
        self::assertSame(1, $pageStats->get('docs')->count);
        self::assertSame(60, $pageStats->get('docs')->totalDuration);
        self::assertSame(1, $pageStats->get('checkout')->count);
        self::assertSame(20, $pageStats->get('checkout')->totalDuration);

        self::assertSame(7.5, $averageDurations->get('home'));
        self::assertSame(30.0, $averageDurations->get('pricing'));
        self::assertSame(60.0, $averageDurations->get('docs'));
        self::assertSame(20.0, $averageDurations->get('checkout'));

        self::assertSame(['docs', 'pricing', 'checkout', 'home'], iterator_to_array($sortedPages));
    }
}
