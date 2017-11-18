<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class FiniteRange.
 */
final class FiniteRange extends RangeState
{
    /**
     * @var DateTimeInterface
     */
    private $startTime;

    /**
     * @var DateTimeInterface
     */
    private $endTime;

    /**
     * @param DateTimeInterface $startTime
     * @param DateTimeInterface $endTime
     */
    public function __construct(DateTimeInterface $startTime, DateTimeInterface $endTime)
    {
        if ($endTime <= $startTime) {
            throw new DateRangeException('Invalid end time, must be after start');
        }

        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * {@inheritdoc}
     */
    public function hasStartTime(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndTime(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime(): DateTimeInterface
    {
        return $this->endTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartTime(DateTimeInterface $time): RangeState
    {
        return new FiniteRange($time, $this->endTime);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTime(DateTimeInterface $time): RangeState
    {
        return new FiniteRange($this->startTime, $time);
    }
}
