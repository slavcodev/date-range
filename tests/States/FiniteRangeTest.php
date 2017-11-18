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
 * Class FiniteRangeTest.
 */
final class FiniteRangeTest extends TestCase
{
    /**
     * @var FiniteRange
     */
    private $subject;

    /**
     * @var DateTimeImmutable
     */
    private $yesterday;

    /**
     * @var DateTimeImmutable
     */
    private $tomorrow;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->yesterday = new DateTimeImmutable('-1 day');
        $this->tomorrow = new DateTimeImmutable('+1 day');
        $this->subject = new FiniteRange($this->yesterday, $this->tomorrow);
    }

    /**
     * @test
     */
    public function checkFiniteState()
    {
        self::assertTrue($this->subject->hasStartDate());
        self::assertTrue($this->subject->hasEndDate());
        self::assertInstanceOf(FiniteRange::class, $this->subject->setStartDate(new DateTimeImmutable()));
        self::assertInstanceOf(FiniteRange::class, $this->subject->setEndDate(new DateTimeImmutable()));
        self::assertSame($this->yesterday, $this->subject->getStartDate());
        self::assertSame($this->tomorrow, $this->subject->getEndDate());
        self::assertSame(0, $this->subject->compareStartDate($this->yesterday));
        self::assertSame(0, $this->subject->compareEndDate($this->tomorrow));
        self::assertSame(-1, $this->subject->compareStartDate($this->tomorrow));
        self::assertSame(1, $this->subject->compareEndDate($this->yesterday));
        self::assertSame($this->yesterday->format('c'), $this->subject->formatStartDate());
        self::assertSame($this->tomorrow->format('c'), $this->subject->formatEndDate());
    }

    /**
     * @test
     */
    public function guardRangeSequence()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Invalid end date, must be after start');

        new FiniteRange($this->tomorrow, $this->yesterday);
    }

    /**
     * @test
     */
    public function guardRangeDatesDifference()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Invalid end date, must be after start');

        new FiniteRange($this->tomorrow, $this->tomorrow);
    }
}
