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
    public function hasStartTime(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasEndTime(): bool
    {
        return false;
    }

    /**
     * @return DateTimeInterface
     */
    abstract public function getStartTime(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    abstract public function getEndTime(): DateTimeInterface;

    /**
     * @param DateTimeInterface $time
     *
     * @return RangeState
     */
    abstract public function setStartTime(DateTimeInterface $time): RangeState;

    /**
     * @param DateTimeInterface $time
     *
     * @return RangeState
     */
    abstract public function setEndTime(DateTimeInterface $time): RangeState;

    /**
     * Compares start time with specific time.
     *
     * Returns 0 if times are equals, negative if start time is less than given time,
     * and positive if start time is greater.
     *
     * @param DateTimeInterface $time
     *
     * @return int
     */
    public function compareStartTime(DateTimeInterface $time): int
    {
        return $this->getStartTime()->getTimestamp() <=> $time->getTimestamp();
    }

    /**
     * Compares end time with specific time.
     *
     * Returns 0 if times are equals, negative if end time is less than given time
     * and positive if end time is greater.
     *
     * @param DateTimeInterface $time
     *
     * @return int
     */
    public function compareEndTime(DateTimeInterface $time): int
    {
        return $this->getEndTime()->getTimestamp() <=> $time->getTimestamp();
    }

    /**
     * @param string $format
     *
     * @return null|string
     */
    public function formatStartTime(string $format = 'c'): ?string
    {
        return $this->getStartTime()->format($format);
    }

    /**
     * @param string $format
     *
     * @return null|string
     */
    public function formatEndTime(string $format = 'c'): ?string
    {
        return $this->getEndTime()->format($format);
    }
}
