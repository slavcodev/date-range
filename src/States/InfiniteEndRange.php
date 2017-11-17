<?php

namespace Zee\DateRange\States;

use DateTimeInterface;

/**
 * Class InfiniteEndRange.
 */
final class InfiniteEndRange extends UndefinedRange
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
    public function __toString(): string
    {
        return sprintf('%s/-', $this->startTime->format('c'));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return ['startTime' => $this->startTime->format('c'), 'endTime' => null];
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
    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
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
    public function compareStartTime(DateTimeInterface $time): int
    {
        return $this->startTime->getTimestamp() <=> $time->getTimestamp();
    }
}
