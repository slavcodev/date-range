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
use DateTimeZone;
use DomainException;
use PHPUnit\Framework\TestCase;
use Zee\DateRange\States\UndefinedRange;

/**
 * Class DateRangeTest.
 */
class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function undefinedRange()
    {
        $now = new DateTimeImmutable();
        $actual = new DateRange();

        self::assertFalse($actual->hasStartDate());
        self::assertFalse($actual->hasEndDate());
        self::assertFalse($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedOn($now));
        self::assertFalse($actual->isEndedOn($now));
        self::assertSame('-/-', (string) $actual);
        self::assertSame(
            json_encode(['startDate' => null, 'endDate' => null]),
            json_encode($actual)
        );

        $changed = $actual->setStartDate($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartDate());

        $changed = $actual->setEndDate($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getEndDate());
    }

    /**
     * @test
     */
    public function undefinedRangeHasNostartDate()
    {
        $actual = new DateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->getStartDate();
    }

    /**
     * @test
     */
    public function undefinedRangeHasNoendDate()
    {
        $actual = new DateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->getEndDate();
    }

    /**
     * @test
     */
    public function cannotCompareUndefinedStart()
    {
        $actual = new UndefinedRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->compareStartDate(new DateTimeImmutable());
    }

    /**
     * @test
     */
    public function cannotCompareUndefinedEnd()
    {
        $actual = new UndefinedRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->compareEndDate(new DateTimeImmutable());
    }

    /**
     * @test
     */
    public function infiniteEndRange()
    {
        $now = new DateTimeImmutable();
        $tomorrow = new DateTimeImmutable('+1 day');
        $actual = new DateRange($now);

        self::assertTrue($actual->hasStartDate());
        self::assertFalse($actual->hasEndDate());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertTrue($actual->isStartedOn($now));
        self::assertFalse($actual->isStartedOn($tomorrow));
        self::assertFalse($actual->isEndedOn($now));
        self::assertSame("{$now->format('c')}/-", (string) $actual);
        self::assertSame(
            json_encode(['startDate' => $now->format('c'), 'endDate' => null]),
            json_encode($actual)
        );

        $changed = $actual->setStartDate($tomorrow);

        self::assertNotSame($actual, $changed);
        self::assertSame($tomorrow, $changed->getStartDate());

        $changed = $actual->setEndDate($tomorrow);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartDate());
        self::assertSame($tomorrow, $changed->getEndDate());
    }

    /**
     * @test
     */
    public function infiniteEndRangeHasNoendDate()
    {
        $now = new DateTimeImmutable();
        $actual = new DateRange($now);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->getEndDate();
    }

    /**
     * @test
     */
    public function infiniteStartRange()
    {
        $now = new DateTimeImmutable();
        $yesterday = new DateTimeImmutable('-1 day');
        $actual = new DateRange(null, $now);

        self::assertFalse($actual->hasStartDate());
        self::assertTrue($actual->hasEndDate());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedOn($now));
        self::assertTrue($actual->isEndedOn($now));
        self::assertFalse($actual->isEndedOn($yesterday));
        self::assertSame("-/{$now->format('c')}", (string) $actual);
        self::assertSame(
            json_encode(['startDate' => null, 'endDate' => $now->format('c')]),
            json_encode($actual)
        );

        $changed = $actual->setEndDate($yesterday);

        self::assertNotSame($actual, $changed);
        self::assertSame($yesterday, $changed->getEndDate());
        self::assertTrue($changed->isEnded());

        $changed = $actual->setStartDate($yesterday);

        self::assertNotSame($actual, $changed);
        self::assertSame($yesterday, $changed->getStartDate());
        self::assertSame($now, $changed->getEndDate());
    }

    /**
     * @test
     */
    public function infiniteStartRangeHasNostartDate()
    {
        $now = new DateTimeImmutable();
        $actual = new DateRange(null, $now);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->getStartDate();
    }

    /**
     * @test
     */
    public function finiteRange()
    {
        $now = new DateTimeImmutable();
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $actual = new DateRange($yesterday, $tomorrow);

        self::assertTrue($actual->hasStartDate());
        self::assertTrue($actual->hasEndDate());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedOn($now));
        self::assertTrue($actual->isStartedOn($yesterday));
        self::assertFalse($actual->isEndedOn($now));
        self::assertTrue($actual->isEndedOn($tomorrow));
        self::assertSame("{$yesterday->format('c')}/{$tomorrow->format('c')}", (string) $actual);
        self::assertSame(
            json_encode(['startDate' => $yesterday->format('c'), 'endDate' => $tomorrow->format('c')]),
            json_encode($actual)
        );

        $changed = $actual->setEndDate($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getEndDate());
        self::assertSame($yesterday, $changed->getStartDate());

        $changed = $actual->setStartDate($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartDate());
        self::assertSame($tomorrow, $changed->getEndDate());
    }

    /**
     * @test
     */
    public function setEndOnStart()
    {
        $cet = new DateTimeImmutable('now', new DateTimeZone('CET'));
        $est = new DateTimeImmutable('now', new DateTimeZone('EST'));

        self::assertSame($cet->getTimestamp(), $est->getTimestamp());

        $this->expectExceptionMessage('Invalid end date, must be after start');

        new DateRange($cet, $cet);
    }

    /**
     * @test
     */
    public function setEndBeforeStart()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid end date, must be after start');

        new DateRange($tomorrow, $yesterday);
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
