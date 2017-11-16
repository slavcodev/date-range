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
        $range = new DateRange(new DateTime());

        self::assertFalse($range->isFinite());
        self::assertTrue($range->isStarted());
        self::assertFalse($range->isEnded());
    }

    /**
     * @test
     */
    public function initFiniteRange()
    {
        $soon = new DateTimeImmutable('+1 day');
        $nextMonth = new DateTimeImmutable('+1 month');
        $range = new DateRange($soon, $nextMonth);

        self::assertFalse($range->isStarted());
        self::assertTrue($range->isFinite());
        self::assertFalse($range->isEnded());
        self::assertTrue($range->isEndAt($nextMonth));
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
        $range = new DateRange($yesterday, $justNow);

        self::assertTrue($range->isStarted());
        self::assertTrue($range->isFinite());
        self::assertTrue($range->isEnded());
        self::assertSame($yesterday, $range->getBegin());
        self::assertSame($justNow, $range->getEnd());

        return $range;
    }

    /**
     * @test
     */
    public function useBackdatingBegin()
    {
        $justNow = new DateTimeImmutable('-1 second');
        $range = new DateRange($justNow);

        self::assertTrue($range->isStarted());
        self::assertFalse($range->isEnded());
        self::assertSame($justNow, $range->getBegin());
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
        $range = new DateRange($soon);

        self::assertFalse($range->isStarted());
        self::assertFalse($range->isEnded());
        self::assertTrue($range->isbeginAt($soon));

        return $range;
    }

    /**
     * @test
     * @depends useFutureBegin
     *
     * @param DateRange $initial
     */
    public function changeBegin(DateRange $initial)
    {
        $range = $initial->beginAt($initial->getBegin());

        self::assertSame($initial->getBegin(), $range->getBegin());

        $nextMonth = new DateTimeImmutable('+1 month');
        $range = $initial->beginAt($nextMonth);

        self::assertFalse($range->isStarted());
        self::assertFalse($range->isEnded());
        self::assertSame($nextMonth, $range->getBegin());
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

    /**
     * @test
     * @dataProvider provideDateRanges
     *
     * @param DateRange $initial
     */
    public function serializeRange(DateRange $initial)
    {
        $actual = unserialize(serialize($initial));

        if ($actual instanceof DateRange) {
            self::assertTrue($actual->isBeginAt($initial->getBegin()));

            if ($initial->isFinite()) {
                self::assertTrue($actual->isEndAt($initial->getEnd()));
            }
        } else {
            self::fail('Cannot serialize/deserialize date range');
        }
    }

    /**
     * @test
     */
    public function handleInvalidSerializedValue()
    {
        $range = new DateRange(new DateTime());

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid range format');

        $range->unserialize('');
    }

    /**
     * @test
     * @dataProvider provideDateRanges
     *
     * @param DateRange $range
     */
    public function jsonEncodeRange(DateRange $range)
    {
        $expected = json_encode((string) $range);
        $actual = json_encode($range);

        self::assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideDateRanges(): array
    {
        $now = new DateTimeImmutable();
        $soon = new DateTimeImmutable('+1 day');

        return [
            [new DateRange($now)],
            [new DateRange($now, $soon)],
        ];
    }
}
