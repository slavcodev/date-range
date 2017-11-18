<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class InfiniteStartRange.
 */
final class InfiniteStartRange extends UndefinedRange
{
    /**
     * @var DateTimeInterface
     */
    private $endTime;

    /**
     * @param DateTimeInterface $endTime
     */
    public function __construct(DateTimeInterface $endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return sprintf('-/%s', $this->endTime->format('c'));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return ['startTime' => null, 'endTime' => $this->endTime->format('c')];
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
        return new InfiniteStartRange($time);
    }

    /**
     * {@inheritdoc}
     */
    public function compareEndTime(DateTimeInterface $time): int
    {
        return $this->endTime->getTimestamp() <=> $time->getTimestamp();
    }
}
