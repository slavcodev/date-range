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

#[CoversClass(FiniteState::class)]
final class FiniteRangeTest extends TestCase
{
    #[Test]
    public function checkFiniteState(): void
    {
        $subject = new FiniteState($this->yesterday(), $this->tomorrow());
        $this->assertTrue($subject->hasStartDate());
        $this->assertTrue($subject->hasEndDate());
        $this->assertInstanceOf(FiniteState::class, $subject->withStartDate($this->today()));
        $this->assertInstanceOf(FiniteState::class, $subject->withEndDate($this->today()));
        $this->assertSame($this->yesterday(), $subject->getStartDate());
        $this->assertSame($this->tomorrow(), $subject->getEndDate());
        $this->assertSame(0, $subject->compareStartDate($this->yesterday()));
        $this->assertSame(0, $subject->compareEndDate($this->tomorrow()));
        $this->assertSame(-1, $subject->compareStartDate($this->tomorrow()));
        $this->assertSame(1, $subject->compareEndDate($this->yesterday()));
        $this->assertSame($this->yesterday()->format('c'), $subject->formatStartDate());
        $this->assertSame($this->tomorrow()->format('c'), $subject->formatEndDate());
    }

    #[Test]
    public function guardRangeSequence(): void
    {
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Invalid end date, must be after start');

        new FiniteState($this->tomorrow(), $this->yesterday());
    }

    #[Test]
    public function guardRangeDatesDifference(): void
    {
        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Invalid end date, must be after start');

        new FiniteState($this->tomorrow(), $this->tomorrow());
    }
}
