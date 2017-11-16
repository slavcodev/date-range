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
use DomainException;
use PHPUnit\Framework\TestCase;

/**
 * Class DateRangeTest.
 */
class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function initInfiniteRange()
    {
        $period = new DateRange(new DateTime());

        self::assertFalse($period->isFinite());
        self::assertTrue($period->isStarted());
        self::assertFalse($period->isEnded());
    }

    /**
     * @test
     */
    public function initFiniteRange()
    {
        $soon = new DateTimeImmutable('+1 day');
        $nextMonth = new DateTimeImmutable('+1 month');
        $period = new DateRange($soon, $nextMonth);

        self::assertFalse($period->isStarted());
        self::assertTrue($period->isFinite());
        self::assertFalse($period->isEnded());
        self::assertTrue($period->isEndAt($nextMonth));
    }

    /**
     * @test
     *
     * @return DateRange
     */
    public function initEndedRange() : DateRange
    {
        $justNow = new DateTimeImmutable('-1 second');
        $yesterday = new DateTimeImmutable('-1 day');
        $period = new DateRange($yesterday, $justNow);

        self::assertTrue($period->isStarted());
        self::assertTrue($period->isFinite());
        self::assertTrue($period->isEnded());
        self::assertSame($yesterday, $period->getBegin());
        self::assertSame($justNow, $period->getEnd());

        return $period;
    }

    /**
     * @test
     */
    public function useBackdatingBegin()
    {
        $justNow = new DateTimeImmutable('-1 second');
        $period = new DateRange($justNow);

        self::assertTrue($period->isStarted());
        self::assertFalse($period->isEnded());
        self::assertSame($justNow, $period->getBegin());
    }

    /**
     * @test
     */
    public function setEndOnBegin()
    {
        $soon = new DateTimeImmutable('+1 day');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid end, must be after begin');

        new DateRange($soon, $soon);
    }

    /**
     * @test
     */
    public function setEndBeforeBegin()
    {
        $soon = new DateTimeImmutable('+1 day');
        $nextMonth = new DateTimeImmutable('+1 month');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid end, must be after begin');

        new DateRange($nextMonth, $soon);
    }

    /**
     * @test
     *
     * @return DateRange
     */
    public function useFutureBegin() : DateRange
    {
        $soon = new DateTimeImmutable('+1 day');
        $period = new DateRange($soon);

        self::assertFalse($period->isStarted());
        self::assertFalse($period->isEnded());
        self::assertTrue($period->isbeginAt($soon));

        return $period;
    }

    /**
     * @test
     * @depends useFutureBegin
     *
     * @param DateRange $initial
     */
    public function changeBegin(DateRange $initial)
    {
        $period = $initial->beginAt($initial->getBegin());

        self::assertSame($initial->getBegin(), $period->getBegin());

        $nextMonth = new DateTimeImmutable('+1 month');
        $period = $initial->beginAt($nextMonth);

        self::assertFalse($period->isStarted());
        self::assertFalse($period->isEnded());
        self::assertSame($nextMonth, $period->getBegin());
    }

    /**
     * @test
     * @depends initEndedRange
     *
     * @param DateRange $initial
     */
    public function changeEnd(DateRange $initial)
    {
        $justNow = $initial->getEnd();
        $period = $initial->endAt($justNow);

        self::assertEquals($justNow, $period->getEnd());

        $nextMonth = new DateTimeImmutable('+1 month');
        $period = $initial->endAt($nextMonth);

        self::assertTrue($period->isStarted());
        self::assertFalse($period->isEnded());
        self::assertSame($nextMonth, $period->getEnd());
    }
}
