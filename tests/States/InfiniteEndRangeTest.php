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

#[CoversClass(InfiniteEndState::class)]
final class InfiniteEndRangeTest extends TestCase
{
    #[Test]
    public function checkFiniteState(): void
    {
        $subject = new InfiniteEndState($this->yesterday());
        $this->assertTrue($subject->hasStartDate());
        $this->assertFalse($subject->hasEndDate());
        $this->assertInstanceOf(InfiniteEndState::class, $subject->withStartDate($this->today()));
        $this->assertInstanceOf(FiniteState::class, $subject->withEndDate($this->today()));
        $this->assertSame($this->yesterday(), $subject->getStartDate());
        $this->assertSame(0, $subject->compareStartDate($this->yesterday()));
        $this->assertSame(-1, $subject->compareStartDate($this->tomorrow()));
        $this->assertSame($this->yesterday()->format('c'), $subject->formatStartDate());
        $this->assertNull($subject->formatEndDate());
    }

    #[Test]
    public function unavailableEnd(): void
    {
        $subject = new InfiniteEndState($this->yesterday());
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $subject->getEndDate();
    }

    #[Test]
    public function cannotCompareEndDate(): void
    {
        $subject = new InfiniteEndState($this->yesterday());
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $subject->compareEndDate($this->today());
    }
}
