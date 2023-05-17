<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

declare(strict_types=1);

namespace Zee\DateRange;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

use function iterator_count;
use function json_encode;
use function print_r;

#[CoversClass(DateRange::class)]
final class DateRangeTest extends TestCase
{
    #[Test]
    public function rangeIsCastingToString(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();

        $this->assertSame('-/-', (string) new DateRange());
        $this->assertSame("{$yesterday->format('c')}/-", (string) new DateRange($yesterday));
        $this->assertSame("-/{$tomorrow->format('c')}", (string) new DateRange(null, $tomorrow));
        $this->assertSame("{$yesterday->format('c')}/{$tomorrow->format('c')}", (string) new DateRange($yesterday, $tomorrow));
    }

    #[Test]
    public function rangeIsJsonSerializable(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();

        $this->assertSame(
            json_encode(['startDate' => null, 'endDate' => null]),
            json_encode(new DateRange())
        );
        $this->assertSame(
            json_encode(['startDate' => $yesterday->format('c'), 'endDate' => null]),
            json_encode(new DateRange($yesterday))
        );
        $this->assertSame(
            json_encode(['startDate' => null, 'endDate' => $tomorrow->format('c')]),
            json_encode(new DateRange(null, $tomorrow))
        );
        $this->assertSame(
            json_encode(['startDate' => $yesterday->format('c'), 'endDate' => $tomorrow->format('c')]),
            json_encode(new DateRange($yesterday, $tomorrow))
        );
    }

    #[Test]
    public function checkRange(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();
        $range = new DateRange($yesterday, $tomorrow);

        $this->assertTrue($range->hasStartDate());
        $this->assertTrue($range->hasEndDate());
        $this->assertSame($yesterday, $range->getStartDate());
        $this->assertSame($tomorrow, $range->getEndDate());
        $this->assertNotSame($range, $range->setStartDate(new DateTimeImmutable()));
        $this->assertNotSame($range, $range->setEndDate(new DateTimeImmutable()));
        $this->assertTrue($range->isFinite());
        $this->assertTrue($range->isStarted());
        $this->assertFalse($range->isEnded());
        $this->assertTrue($range->isStartedOn($yesterday));
        $this->assertTrue($range->isEndedOn($tomorrow));
    }

    #[Test]
    public function startedTillEndOnInfiniteStart(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();

        $range = new DateRange(null, $tomorrow);

        $this->assertTrue($range->isStarted());

        $range = new DateRange(null, $yesterday);

        $this->assertFalse($range->isStarted());
    }

    #[Test]
    public function dumpRange(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();
        $range = new DateRange($yesterday, $tomorrow);
        $dump = print_r($range, true);

        $this->assertStringNotContainsString('state', $dump);
    }

    #[Test]
    public function getTimestampInterval(): void
    {
        $now = $this->today();
        $oneHourRange = new DateRange($now, $now->add(new DateInterval('PT1H')));
        $oneDayRange = new DateRange($now, $now->add(new DateInterval('P1D')));

        $this->assertSame(3600, $oneHourRange->getTimestampInterval());
        $this->assertSame(86400, $oneDayRange->getTimestampInterval());
    }

    #[Test]
    public function getDateInterval(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();
        $range = new DateRange($yesterday, $tomorrow);
        $interval = $range->getDateInterval();

        $this->assertSame(2, $interval->days);
    }

    #[Test]
    public function getDatePeriod(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();
        $range = new DateRange($yesterday, $tomorrow);
        $interval = new DateInterval('P1D');
        $period = $range->getDatePeriod($interval);

        $this->assertSame($range->getStartDate()->getTimestamp(), $period->getStartDate()->getTimestamp());
        $this->assertSame($range->getEndDate()->getTimestamp(), $period->getEndDate()?->getTimestamp());
        $this->assertSame(2, iterator_count($period));
    }

    #[Test]
    public function splitRange(): void
    {
        $yesterday = $this->yesterday();
        $tomorrow = $this->tomorrow();
        $range = new DateRange($yesterday, $tomorrow);
        $interval = new DateInterval('P1D');

        $ranges = $range->split($interval);

        $this->assertSame(2, iterator_count($ranges));

        foreach ($range->split($interval) as $range) {
            $this->assertInstanceOf(DateRange::class, $range);
        }
    }
}
