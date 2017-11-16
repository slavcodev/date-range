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
use DomainException;
use PHPUnit\Framework\TestCase;

/**
 * Class NullDateRangeTest.
 */
class NullDateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function checkNullObject()
    {
        $null = new NullDateRange();

        self::assertFalse($null->isFinite());
        self::assertFalse($null->isBeginAt(new DateTime()));
        self::assertFalse($null->isEndAt(new DateTime()));
        self::assertFalse($null->isStarted());
        self::assertFalse($null->isEnded());
    }

    /**
     * @test
     */
    public function cannotChangeRangeBegin()
    {
        $null = new NullDateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Date range is undefined');

        $null->beginAt(new DateTime());
    }

    /**
     * @test
     */
    public function cannotChangeRangeEnd()
    {
        $null = new NullDateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Date range is undefined');

        $null->endAt(new DateTime());
    }

    /**
     * @test
     */
    public function cannotReadRangeBegin()
    {
        $null = new NullDateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Date range is undefined');

        $null->getBegin();
    }

    /**
     * @test
     */
    public function cannotReadRangeEnd()
    {
        $null = new NullDateRange();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Date range is undefined');

        $null->getEnd();
    }
}
