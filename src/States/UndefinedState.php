<?php

declare(strict_types=1);

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\InvalidDateRangeDateRangeException;

/**
 * State of the undefined range.
 *
 * @internal
 *
 * @psalm-internal Zee\DateRange
 */
final class UndefinedState extends RangeState
{
    public function getStartDate(): never
    {
        throw new InvalidDateRangeDateRangeException('Range start is undefined');
    }

    public function getEndDate(): never
    {
        throw new InvalidDateRangeDateRangeException('Range end is undefined');
    }

    public function withStartDate(DateTimeInterface $start): RangeState
    {
        return new InfiniteEndState($start);
    }

    public function withEndDate(DateTimeInterface $end): RangeState
    {
        return new InfiniteStartState($end);
    }

    public function formatStartDate(string $format = 'c'): null|string
    {
        return null;
    }

    public function formatEndDate(string $format = 'c'): null|string
    {
        return null;
    }
}
