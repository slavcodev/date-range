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
 * Class InfiniteEndRangeTest.
 */
final class InfiniteEndRangeTest extends TestCase
{
    /**
     * @var FiniteState
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
        $this->subject = new InfiniteEndState($this->yesterday);
    }

    /**
     * @test
     */
    public function checkFiniteState()
    {
        self::assertTrue($this->subject->hasStartDate());
        self::assertFalse($this->subject->hasEndDate());
        self::assertInstanceOf(InfiniteEndState::class, $this->subject->setStartDate(new DateTimeImmutable()));
        self::assertInstanceOf(FiniteState::class, $this->subject->setEndDate(new DateTimeImmutable()));
        self::assertSame($this->yesterday, $this->subject->getStartDate());
        self::assertSame(0, $this->subject->compareStartDate($this->yesterday));
        self::assertSame(-1, $this->subject->compareStartDate($this->tomorrow));
        self::assertSame($this->yesterday->format('c'), $this->subject->formatStartDate());
        self::assertNull($this->subject->formatEndDate());
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
    public function cannotCompareEndDate()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $this->subject->compareEndDate(new DateTimeImmutable());
    }
}
