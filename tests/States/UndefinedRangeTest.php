<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

namespace Zee\DateRange\States;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Zee\DateRange\DateRangeException;

/**
 * Class UndefinedRangeTest.
 */
final class UndefinedRangeTest extends TestCase
{
    /**
     * @var UndefinedRange
     */
    private $subject;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->subject = new UndefinedRange();
    }

    /**
     * @test
     */
    public function checkUndefinedState()
    {
        self::assertFalse($this->subject->hasStartDate());
        self::assertFalse($this->subject->hasEndDate());
        self::assertInstanceOf(InfiniteEndRange::class, $this->subject->setStartDate(new DateTimeImmutable()));
        self::assertInstanceOf(InfiniteStartRange::class, $this->subject->setEndDate(new DateTimeImmutable()));
        self::assertNull($this->subject->formatStartDate());
        self::assertNull($this->subject->formatEndDate());
    }

    /**
     * @test
     */
    public function unavailableStart()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $this->subject->getStartDate();
    }

    /**
     * @test
     */
    public function unavailableEnd()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $this->subject->getEndDate();
    }

    /**
     * @test
     */
    public function cannotCompareStartDate()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $this->subject->compareStartDate(new DateTimeImmutable());
    }

    /**
     * @test
     */
    public function cannotCompareEndDate()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $this->subject->compareEndDate(new DateTimeImmutable());
    }
}
