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
 * Class InfiniteStartRangeTest.
 */
final class InfiniteStartRangeTest extends TestCase
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
        $this->subject = new InfiniteStartRange($this->tomorrow);
    }

    /**
     * @test
     */
    public function checkFiniteState()
    {
        self::assertFalse($this->subject->hasStartDate());
        self::assertTrue($this->subject->hasEndDate());
        self::assertInstanceOf(FiniteRange::class, $this->subject->setStartDate(new DateTimeImmutable()));
        self::assertInstanceOf(InfiniteStartRange::class, $this->subject->setEndDate(new DateTimeImmutable()));
        self::assertSame($this->tomorrow, $this->subject->getEndDate());
        self::assertSame(0, $this->subject->compareEndDate($this->tomorrow));
        self::assertSame(1, $this->subject->compareEndDate($this->yesterday));
        self::assertSame($this->tomorrow->format('c'), $this->subject->formatEndDate());
        self::assertNull($this->subject->formatStartDate());
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
    public function cannotCompareStartDate()
    {
        $this->expectException(DateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $this->subject->compareStartDate(new DateTimeImmutable());
    }
}
