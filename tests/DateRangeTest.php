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

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Class DateRangeTest.
 */
final class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function rangeIsCastingToString()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');

        self::assertSame('-/-', (string) new DateRange());
        self::assertSame("{$yesterday->format('c')}/-", (string) new DateRange($yesterday));
        self::assertSame("-/{$tomorrow->format('c')}", (string) new DateRange(null, $tomorrow));
        self::assertSame("{$yesterday->format('c')}/{$tomorrow->format('c')}", (string) new DateRange($yesterday, $tomorrow));
    }

    /**
     * @test
     */
    public function rangeIsJsonSerializable()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');

        self::assertSame(
            json_encode(['startDate' => null, 'endDate' => null]),
            json_encode(new DateRange())
        );
        self::assertSame(
            json_encode(['startDate' => $yesterday->format('c'), 'endDate' => null]),
            json_encode(new DateRange($yesterday))
        );
        self::assertSame(
            json_encode(['startDate' => null, 'endDate' => $tomorrow->format('c')]),
            json_encode(new DateRange(null, $tomorrow))
        );
        self::assertSame(
            json_encode(['startDate' => $yesterday->format('c'), 'endDate' => $tomorrow->format('c')]),
            json_encode(new DateRange($yesterday, $tomorrow))
        );
    }

    /**
     * @test
     */
    public function checkRange()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $range = new DateRange($yesterday, $tomorrow);
        
        self::assertTrue($range->hasStartDate());
        self::assertTrue($range->hasEndDate());
        self::assertSame($yesterday, $range->getStartDate());
        self::assertSame($tomorrow, $range->getEndDate());
        self::assertNotSame($range, $range->setStartDate(new DateTimeImmutable()));
        self::assertNotSame($range, $range->setEndDate(new DateTimeImmutable()));
        self::assertTrue($range->isFinite());
        self::assertTrue($range->isStarted());
        self::assertFalse($range->isEnded());
        self::assertTrue($range->isStartedOn($yesterday));
        self::assertTrue($range->isEndedOn($tomorrow));
    }

    /**
     * @test
     */
    public function startedTillEndOnInfiniteStart()
    {
        $tomorrow = new DateTimeImmutable('+1 day');
        $yesterday = new DateTimeImmutable('-1 day');

        $range = new DateRange(null, $tomorrow);

        self::assertTrue($range->isStarted());

        $range = new DateRange(null, $yesterday);

        self::assertFalse($range->isStarted());
    }

    /**
     * @test
     */
    public function dumpRange()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $range = new DateRange($yesterday, $tomorrow);
        $dump = print_r($range, true);

        self::assertNotContains('state', $dump);
    }

    /**
     * @test
     */
    public function getTimestampInterval()
    {
        $now = new DateTimeImmutable();
        $oneHourRange = new DateRange($now, $now->add(new DateInterval('PT1H')));
        $oneDayRange = new DateRange($now, $now->add(new DateInterval('P1D')));

        self::assertSame(3600, $oneHourRange->getTimestampInterval());
        self::assertSame(86400, $oneDayRange->getTimestampInterval());
    }

    /**
     * @test
     */
    public function getDateInterval()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $range = new DateRange($yesterday, $tomorrow);
        $interval = $range->getDateInterval();

        self::assertSame(2, $interval->days);
    }

    /**
     * @test
     */
    public function getDatePeriod()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $range = new DateRange($yesterday, $tomorrow);
        $interval = new DateInterval('P1D');
        $period = $range->getDatePeriod($interval);

        self::assertSame($range->getStartDate()->getTimestamp(), $period->getStartDate()->getTimestamp());
        self::assertSame($range->getEndDate()->getTimestamp(), $period->getEndDate()->getTimestamp());
        self::assertSame(2, iterator_count($period));
    }

    /**
     * @test
     */
    public function splitRange()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $range = new DateRange($yesterday, $tomorrow);
        $interval = new DateInterval('P1D');

        $ranges = $range->split($interval);

        self::assertSame(2, iterator_count($ranges));

        foreach ($range->split($interval) as $range) {
            self::assertInstanceOf(DateRange::class, $range);
        }
    }
}
