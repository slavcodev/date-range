<?php

declare(strict_types=1);

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\InvalidDateRangeDateRangeException;

/**
 * State of the range with infinite end.
 *
 * @internal
 *
 * @psalm-internal Zee\DateRange
 */
final class InfiniteEndState extends RangeState
{
    public function __construct(
        private readonly DateTimeInterface $startDate,
    ) {}

    public function hasStartDate(): bool
    {
        return true;
    }

    public function hasEndDate(): bool
    {
        return false;
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): never
    {
        throw new InvalidDateRangeDateRangeException('Range end is undefined');
    }

    public function withStartDate(DateTimeInterface $start): RangeState
    {
        return new self($start);
    }

    public function withEndDate(DateTimeInterface $end): RangeState
    {
        return new FiniteState($this->startDate, $end);
    }

    public function formatEndDate(string $format = 'c'): null|string
    {
        return null;
    }
}
