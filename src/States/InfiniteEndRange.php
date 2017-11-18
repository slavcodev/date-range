<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class InfiniteEndRange.
 */
final class InfiniteEndRange extends RangeState
{
    /**
     * @var DateTimeInterface
     */
    private $startTime;

    /**
     * @param DateTimeInterface $startTime
     */
    public function __construct(DateTimeInterface $startTime)
    {
        $this->startTime = $startTime;
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
        return false;
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
        throw new DateRangeException('Range end is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartTime(DateTimeInterface $time): RangeState
    {
        return new InfiniteEndRange($time);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTime(DateTimeInterface $time): RangeState
    {
        return new FiniteRange($this->startTime, $time);
    }

    /**
     * {@inheritdoc}
     */
    public function formatEndTime(string $format = 'c'): ?string
    {
        return null;
    }
}
