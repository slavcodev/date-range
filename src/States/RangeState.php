<?php

namespace Zee\DateRange\States;

use DateTimeInterface;

/**
 * Interface RangeState.
 */
abstract class RangeState
{
    /**
     * @return bool
     */
    public function hasStartDate(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasEndDate(): bool
    {
        return false;
    }

    /**
     * @return DateTimeInterface
     */
    abstract public function getStartDate(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    abstract public function getEndDate(): DateTimeInterface;

    /**
     * @param DateTimeInterface $start
     *
     * @return RangeState
     */
    abstract public function setStartDate(DateTimeInterface $start): RangeState;

    /**
     * @param DateTimeInterface $end
     *
     * @return RangeState
     */
    abstract public function setEndDate(DateTimeInterface $end): RangeState;

    /**
     * Compares start date with specific date.
     *
     * Returns 0 if dates are equals, negative if start date is less than given date,
     * and positive if start date is greater.
     *
     * @param DateTimeInterface $date
     *
     * @return int
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
     *
     * @param DateTimeInterface $date
     *
     * @return int
     */
    public function compareEndDate(DateTimeInterface $date): int
    {
        return $this->getEndDate()->getTimestamp() <=> $date->getTimestamp();
    }

    /**
     * @param string $format
     *
     * @return null|string
     */
    public function formatStartDate(string $format = 'c'): ?string
    {
        return $this->getStartDate()->format($format);
    }

    /**
     * @param string $format
     *
     * @return null|string
     */
    public function formatEndDate(string $format = 'c'): ?string
    {
        return $this->getEndDate()->format($format);
    }
}
