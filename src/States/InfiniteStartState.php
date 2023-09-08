<?php

declare(strict_types=1);

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\InvalidDateRangeDateRangeException;

/**
 * State of the range with infinite start.
 *
 * @internal
 *
 * @psalm-internal Zee\DateRange
 */
final class InfiniteStartState extends RangeState
{
    public function __construct(
        private readonly DateTimeInterface $endDate,
    ) {}

    public function hasEndDate(): bool
    {
        return true;
    }

    public function getStartDate(): never
    {
        throw new InvalidDateRangeDateRangeException('Range start is undefined');
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    public function withStartDate(DateTimeInterface $start): RangeState
    {
        return new FiniteState($start, $this->endDate);
    }

    public function withEndDate(DateTimeInterface $end): RangeState
    {
        return new self($end);
    }

    public function formatStartDate(string $format = 'c'): ?string
    {
        return null;
    }
}
