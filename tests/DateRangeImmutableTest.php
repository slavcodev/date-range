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

    /**
     * @test
     */
    public function checkImmutableCopyMutableObjectBehaviors()
    {
        $yesterday = new DateTime('-1 day');
        $tomorrow = new DateTime('+1 day');

        $immutable = new DateRangeImmutable($yesterday, $tomorrow);
        $mutable = new DateRange($yesterday, $tomorrow);

        self::assertSame((string) $mutable, (string) $immutable);
        self::assertSame(json_encode($mutable), json_encode($immutable));
        self::assertSame($mutable->__debugInfo(), $immutable->__debugInfo());

        $immutable = unserialize(serialize($immutable));
        $mutable = unserialize(serialize($mutable));

        self::assertEquals($mutable->getBegin(), $immutable->getBegin());
        self::assertEquals($mutable->getEnd(), $immutable->getEnd());
    }

    /**
     * @test
     */
    public function handleInvalidSerializedValue()
    {
        $range = new DateRangeImmutable(new DateTime());

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid range format');

        $range->unserialize('');
    }
}
