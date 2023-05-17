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

#[CoversClass(UndefinedState::class)]
final class UndefinedRangeTest extends TestCase
{
    #[Test]
    public function checkUndefinedState(): void
    {
        $subject = new UndefinedState();
        $this->assertFalse($subject->hasStartDate());
        $this->assertFalse($subject->hasEndDate());
        $this->assertInstanceOf(InfiniteEndState::class, $subject->withStartDate($this->today()));
        $this->assertInstanceOf(InfiniteStartState::class, $subject->withEndDate($this->today()));
        $this->assertNull($subject->formatStartDate());
        $this->assertNull($subject->formatEndDate());
    }

    #[Test]
    public function unavailableStart(): void
    {
        $subject = new UndefinedState();

        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $subject->getStartDate();
    }

    #[Test]
    public function unavailableEnd(): void
    {
        $subject = new UndefinedState();

        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $subject->getEndDate();
    }

    #[Test]
    public function cannotCompareStartDate(): void
    {
        $subject = new UndefinedState();

        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range start is undefined');

        $subject->compareStartDate($this->today());
    }

    #[Test]
    public function cannotCompareEndDate(): void
    {
        $subject = new UndefinedState();

        $this->expectException(InvalidDateRangeDateRangeException::class);
        $this->expectExceptionMessage('Range end is undefined');

        $subject->compareEndDate($this->today());
    }
}
