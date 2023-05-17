<?php

declare(strict_types=1);

namespace Zee\DateRange\States;

use DateTimeInterface;

/**
 * Date range abstract state.
 *
 * @internal
 *
 * @psalm-internal Zee\DateRange
 */
abstract class RangeState
{
    public function hasStartDate(): bool
    {
        return false;
    }

    public function hasEndDate(): bool
    {
        return false;
    }

    abstract public function getStartDate(): DateTimeInterface;

    abstract public function getEndDate(): DateTimeInterface;

    abstract public function withStartDate(DateTimeInterface $start): self;

    abstract public function withEndDate(DateTimeInterface $end): self;

    /**
     * Compares start date with specific date.
     *
     * Returns 0 if dates are equals, negative if start date is less than given date,
     * and positive if start date is greater.
     */
    public function compareStartDate(DateTimeInterface $date): int
    {
        return $this->getStartDate()->getTimestamp() <=> $date->getTimestamp();
    }

    /**
     * Compares end date with specific date.
     *
     * Returns 0 if dates are equals, negative if end date is less than given date
     * and positive if end date is greater.
     */
    public function compareEndDate(DateTimeInterface $date): int
    {
        return $this->getEndDate()->getTimestamp() <=> $date->getTimestamp();
    }

    public function formatStartDate(string $format = 'c'): null|string
    {
        return $this->getStartDate()->format($format);
    }

    public function formatEndDate(string $format = 'c'): null|string
    {
        return $this->getEndDate()->format($format);
    }
}
