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

        self::assertFalse($actual->hasStartTime());
        self::assertFalse($actual->hasEndTime());
        self::assertFalse($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedAt($now));
        self::assertFalse($actual->isEndedAt($now));
        self::assertSame('-/-', (string) $actual);
        self::assertSame(
            json_encode(['startTime' => null, 'endTime' => null]),
            json_encode($actual)
        );

        $changed = $actual->setStartTime($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartTime());

        $changed = $actual->setEndTime($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getEndTime());
    }

    /**
     * @test
     */
    public function undefinedRangeHasNoStartTime()
    {
        $actual = new DateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->getStartTime();
    }

    /**
     * @test
     */
    public function undefinedRangeHasNoEndTime()
    {
        $actual = new DateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->getEndTime();
    }

    /**
     * @test
     */
    public function cannotCompareUndefinedStart()
    {
        $actual = new UndefinedRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->compareStartTime(new DateTimeImmutable());
    }

    /**
     * @test
     */
    public function cannotCompareUndefinedEnd()
    {
        $actual = new UndefinedRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->compareEndTime(new DateTimeImmutable());
    }

    /**
     * @test
     */
    public function infiniteEndRange()
    {
        $now = new DateTimeImmutable();
        $tomorrow = new DateTimeImmutable('+1 day');
        $actual = new DateRange($now);

        self::assertTrue($actual->hasStartTime());
        self::assertFalse($actual->hasEndTime());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertTrue($actual->isStartedAt($now));
        self::assertFalse($actual->isStartedAt($tomorrow));
        self::assertFalse($actual->isEndedAt($now));
        self::assertSame("{$now->format('c')}/-", (string) $actual);
        self::assertSame(
            json_encode(['startTime' => $now->format('c'), 'endTime' => null]),
            json_encode($actual)
        );

        $changed = $actual->setStartTime($tomorrow);

        self::assertNotSame($actual, $changed);
        self::assertSame($tomorrow, $changed->getStartTime());

        $changed = $actual->setEndTime($tomorrow);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartTime());
        self::assertSame($tomorrow, $changed->getEndTime());
    }

    /**
     * @test
     */
    public function infiniteEndRangeHasNoEndTime()
    {
        $now = new DateTimeImmutable();
        $actual = new DateRange($now);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $actual->getEndTime();
    }

    /**
     * @test
     */
    public function infiniteStartRange()
    {
        $now = new DateTimeImmutable();
        $yesterday = new DateTimeImmutable('-1 day');
        $actual = new DateRange(null, $now);

        self::assertFalse($actual->hasStartTime());
        self::assertTrue($actual->hasEndTime());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedAt($now));
        self::assertTrue($actual->isEndedAt($now));
        self::assertFalse($actual->isEndedAt($yesterday));
        self::assertSame("-/{$now->format('c')}", (string) $actual);
        self::assertSame(
            json_encode(['startTime' => null, 'endTime' => $now->format('c')]),
            json_encode($actual)
        );

        $changed = $actual->setEndTime($yesterday);

        self::assertNotSame($actual, $changed);
        self::assertSame($yesterday, $changed->getEndTime());
        self::assertTrue($changed->isEnded());

        $changed = $actual->setStartTime($yesterday);

        self::assertNotSame($actual, $changed);
        self::assertSame($yesterday, $changed->getStartTime());
        self::assertSame($now, $changed->getEndTime());
    }

    /**
     * @test
     */
    public function infiniteStartRangeHasNoStartTime()
    {
        $now = new DateTimeImmutable();
        $actual = new DateRange(null, $now);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $actual->getStartTime();
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

        self::assertTrue($actual->hasStartTime());
        self::assertTrue($actual->hasEndTime());
        self::assertTrue($actual->isStarted());
        self::assertFalse($actual->isEnded());
        self::assertFalse($actual->isStartedAt($now));
        self::assertTrue($actual->isStartedAt($yesterday));
        self::assertFalse($actual->isEndedAt($now));
        self::assertTrue($actual->isEndedAt($tomorrow));
        self::assertSame("{$yesterday->format('c')}/{$tomorrow->format('c')}", (string) $actual);
        self::assertSame(
            json_encode(['startTime' => $yesterday->format('c'), 'endTime' => $tomorrow->format('c')]),
            json_encode($actual)
        );

        $changed = $actual->setEndTime($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getEndTime());
        self::assertSame($yesterday, $changed->getStartTime());

        $changed = $actual->setStartTime($now);

        self::assertNotSame($actual, $changed);
        self::assertSame($now, $changed->getStartTime());
        self::assertSame($tomorrow, $changed->getEndTime());
    }

    /**
     * @test
     */
    public function setEndOnStart()
    {
        $cet = new DateTimeImmutable('now', new DateTimeZone('CET'));
        $est = new DateTimeImmutable('now', new DateTimeZone('EST'));

        self::assertSame($cet->getTimestamp(), $est->getTimestamp());

        $this->expectExceptionMessage('Invalid end time, must be after start');

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
        $this->expectExceptionMessage('Invalid end time, must be after start');

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
}
