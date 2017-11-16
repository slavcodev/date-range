<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

namespace Zee\DateRange;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Class DateRangeImmutableTest.
 */
class DateRangeImmutableTest extends TestCase
{
    /**
     * @test
     */
    public function checkImmutability()
    {
        $now = new DateTime();
        $yesterday = new DateTime('-1 day');
        $tomorrow = new DateTime('+1 day');
        $soon = new DateTimeImmutable('+1 month');

        $initial = new DateRangeImmutable($yesterday, $tomorrow);

        self::assertSame($yesterday, $initial->getBegin());
        self::assertSame($tomorrow, $initial->getEnd());
        self::assertTrue($initial->isFinite());
        self::assertTrue($initial->isBeginAt($yesterday));
        self::assertTrue($initial->isEndAt($tomorrow));
        self::assertTrue($initial->isStarted());
        self::assertFalse($initial->isEnded());

        $actual = $initial->beginAt($now);

        self::assertNotSame($initial, $actual);
        self::assertSame($now, $actual->getBegin());

        $actual = $initial->endAt($soon);

        self::assertNotSame($initial, $actual);
        self::assertSame($soon, $actual->getEnd());
    }
}
