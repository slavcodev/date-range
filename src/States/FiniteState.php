<?php

declare(strict_types=1);

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\InvalidDateRangeDateRangeException;

/**
 * State of the finite range.
 *
 * @internal
 *
 * @psalm-internal Zee\DateRange
 */
final class FiniteState extends RangeState
{
    public function __construct(
        private readonly DateTimeInterface $startDate,
        private readonly DateTimeInterface $endDate,
    ) {
        if ($endDate <= $startDate) {
            throw new InvalidDateRangeDateRangeException('Invalid end date, must be after start');
        }
    }

    public function hasStartDate(): bool
    {
        return true;
    }

    public function hasEndDate(): bool
    {
        return true;
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    public function withStartDate(DateTimeInterface $start): RangeState
    {
        return new self($start, $this->endDate);
    }

    public function withEndDate(DateTimeInterface $end): RangeState
    {
        return new self($this->startDate, $end);
    }
}
