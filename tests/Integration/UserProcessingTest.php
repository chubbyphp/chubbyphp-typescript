<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Integration;

use Chubbyphp\Tests\Typescript\Stub\Accumulator;
use Chubbyphp\Tests\Typescript\Stub\HistoryEntry;
use Chubbyphp\Tests\Typescript\Stub\Meta;
use Chubbyphp\Tests\Typescript\Stub\User;
use Chubbyphp\Tests\Typescript\Stub\Visit;
use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class UserProcessingTest extends TestCase
{
    public function testUserPipeline(): void
    {
        $users = new Arr(
            new User(1, 'User-1', 42, true, new Arr('new'), new Arr(
                new Visit(5, true),
                new Visit(12, false),
            ), new Meta(0, false)),
            new User(2, 'User-2', 87, true, new Arr('vip'), new Arr(
                new Visit(20, true),
                new Visit(7, true),
            ), new Meta(1, false)),
            new User(3, 'User-3', 15, false, new Arr('trial'), new Arr(
                new Visit(3, false),
                new Visit(9, false),
            ), new Meta(2, false)),
            new User(4, 'User-4', 61, true, new Arr('legacy'), new Arr(
                new Visit(14, true),
                new Visit(6, false),
            ), new Meta(0, false)),
        );

        $result = $users
            ->map(static function (User $user, int $index): User {
                $user->score += 10 - (0 === $index % 2 ? 3 : 7);
                $user->processed = true;
                $user->updatedAt = 1700000000000;

                $user->history ??= new Arr();
                $user->history->push(new HistoryEntry('inline-mutation', $index, $user->score, 500));

                $user->tags = $user->tags
                    ->concat($user->score > 70 ? 'high-score' : 'normal-score')
                    ->map(static fn (string $tag, int $tagIndex): string => "{$tag}-{$tagIndex}")
                ;

                $user->visits = $user->visits->map(static function (Visit $visit, int $visitIndex) use ($user): Visit {
                    $visit->duration += 5 + $visitIndex;
                    $visit->checked = true;
                    $visit->weight = $visit->success
                        ? $visit->duration * 1.5
                        : $visit->duration * 0.5;
                    $visit->label = "{$user->name}-visit-{$visitIndex}";

                    return $visit;
                });

                ++$user->meta->retries;

                if ($user->score < 20) {
                    $user->meta->flagged = true;
                }

                return $user;
            })
            ->filter(static fn (User $user): bool => $user->active)
            ->sort(static fn (User $a, User $b): int => $b->score <=> $a->score ?: strcmp($a->name, $b->name))
            ->reduce(
                static function (Accumulator $acc, User $user): Accumulator {
                    ++$acc->count;
                    $acc->totalScore += $user->score;
                    $acc->maxScore = max($acc->maxScore, $user->score);
                    $acc->topUser = (null === $acc->topUser || $user->score >= $acc->byName->{$acc->topUser}->score)
                        ? $user->name
                        : $acc->topUser;
                    $acc->byName->{$user->name} = $user;
                    $acc->users = $acc->users->concat($user);

                    $user->tags->forEach(static function (string $tag) use ($acc): void {
                        $acc->tagCounts->{$tag} = ($acc->tagCounts->{$tag} ?? 0) + 1;
                    });

                    $user->visits->forEach(static function (Visit $visit) use ($acc): void {
                        ++$acc->totalVisits;
                        $acc->totalDuration += $visit->duration;
                        if ($visit->success) {
                            ++$acc->successes;
                        } else {
                            ++$acc->failures;
                        }
                        $acc->visitLabels->push($visit->label);
                    });

                    return $acc;
                },
                new Accumulator(),
            )
        ;

        self::assertSame([
            'count' => 3,
            'totalScore' => 203,
            'totalVisits' => 6,
            'totalDuration' => 97,
            'successes' => 4,
            'failures' => 2,
            'maxScore' => 90.0,
            'topUser' => 'User-2',
            'byName' => [
                'User-2' => [
                    'id' => 2,
                    'name' => 'User-2',
                    'score' => 90,
                    'active' => true,
                    'tags' => [
                        'vip-0',
                        'high-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 25,
                            'success' => true,
                            'checked' => true,
                            'weight' => 37.5,
                            'label' => 'User-2-visit-0',
                        ],
                        [
                            'duration' => 13,
                            'success' => true,
                            'checked' => true,
                            'weight' => 19.5,
                            'label' => 'User-2-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 2,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 1,
                            'score' => 90,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
                'User-4' => [
                    'id' => 4,
                    'name' => 'User-4',
                    'score' => 64,
                    'active' => true,
                    'tags' => [
                        'legacy-0',
                        'normal-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 19,
                            'success' => true,
                            'checked' => true,
                            'weight' => 28.5,
                            'label' => 'User-4-visit-0',
                        ],
                        [
                            'duration' => 12,
                            'success' => false,
                            'checked' => true,
                            'weight' => 6.0,
                            'label' => 'User-4-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 1,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 3,
                            'score' => 64,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
                'User-1' => [
                    'id' => 1,
                    'name' => 'User-1',
                    'score' => 49,
                    'active' => true,
                    'tags' => [
                        'new-0',
                        'normal-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 10,
                            'success' => true,
                            'checked' => true,
                            'weight' => 15.0,
                            'label' => 'User-1-visit-0',
                        ],
                        [
                            'duration' => 18,
                            'success' => false,
                            'checked' => true,
                            'weight' => 9.0,
                            'label' => 'User-1-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 1,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 0,
                            'score' => 49,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
            ],
            'tagCounts' => [
                'vip-0' => 1,
                'high-score-1' => 1,
                'legacy-0' => 1,
                'normal-score-1' => 2,
                'new-0' => 1,
            ],
            'visitLabels' => [
                'User-2-visit-0',
                'User-2-visit-1',
                'User-4-visit-0',
                'User-4-visit-1',
                'User-1-visit-0',
                'User-1-visit-1',
            ],
            'users' => [
                [
                    'id' => 2,
                    'name' => 'User-2',
                    'score' => 90,
                    'active' => true,
                    'tags' => [
                        'vip-0',
                        'high-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 25,
                            'success' => true,
                            'checked' => true,
                            'weight' => 37.5,
                            'label' => 'User-2-visit-0',
                        ],
                        [
                            'duration' => 13,
                            'success' => true,
                            'checked' => true,
                            'weight' => 19.5,
                            'label' => 'User-2-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 2,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 1,
                            'score' => 90,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
                [
                    'id' => 4,
                    'name' => 'User-4',
                    'score' => 64,
                    'active' => true,
                    'tags' => [
                        'legacy-0',
                        'normal-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 19,
                            'success' => true,
                            'checked' => true,
                            'weight' => 28.5,
                            'label' => 'User-4-visit-0',
                        ],
                        [
                            'duration' => 12,
                            'success' => false,
                            'checked' => true,
                            'weight' => 6.0,
                            'label' => 'User-4-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 1,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 3,
                            'score' => 64,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
                [
                    'id' => 1,
                    'name' => 'User-1',
                    'score' => 49,
                    'active' => true,
                    'tags' => [
                        'new-0',
                        'normal-score-1',
                    ],
                    'visits' => [
                        [
                            'duration' => 10,
                            'success' => true,
                            'checked' => true,
                            'weight' => 15.0,
                            'label' => 'User-1-visit-0',
                        ],
                        [
                            'duration' => 18,
                            'success' => false,
                            'checked' => true,
                            'weight' => 9.0,
                            'label' => 'User-1-visit-1',
                        ],
                    ],
                    'meta' => [
                        'retries' => 1,
                        'flagged' => false,
                    ],
                    'processed' => true,
                    'updatedAt' => 1700000000000,
                    'history' => [
                        [
                            'step' => 'inline-mutation',
                            'index' => 0,
                            'score' => 49,
                            'randomSeedLikeValue' => 500,
                        ],
                    ],
                ],
            ],
        ], $result->jsonSerialize());
    }
}
