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

namespace Zee\DateRange\States;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Zee\DateRange\InvalidDateRangeDateRangeException;
use Zee\DateRange\TestCase;

#[CoversClass(InfiniteStartState::class)]
final class InfiniteStartRangeTest extends TestCase
{
    #[Test]
    public function checkFiniteState(): void
    {
        $subject = new InfiniteStartState($this->tomorrow());
        $this->assertFalse($subject->hasStartDate());
        $this->assertTrue($subject->hasEndDate());
        $this->assertInstanceOf(FiniteState::class, $subject->withStartDate($this->today()));
        $this->assertInstanceOf(InfiniteStartState::class, $subject->withEndDate($this->today()));
        $this->assertSame($this->tomorrow(), $subject->getEndDate());
        $this->assertSame(0, $subject->compareEndDate($this->tomorrow()));
        $this->assertSame(1, $subject->compareEndDate($this->yesterday()));
        $this->assertSame($this->tomorrow()->format('c'), $subject->formatEndDate());
        $this->assertNull($subject->formatStartDate());
    }

    #[Test]
    public function unavailableStart(): void
    {
        $subject = new InfiniteStartState($this->tomorrow());
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $subject->getStartDate();
    }

    #[Test]
    public function cannotCompareStartDate(): void
    {
        $subject = new InfiniteStartState($this->tomorrow());
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $subject->compareStartDate($this->today());
    }
}
