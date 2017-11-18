<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class InfiniteStartRange.
 */
final class InfiniteStartRange extends RangeState
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
    public function hasEndTime(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime(): DateTimeInterface
    {
        throw new DateRangeException('Range start is undefined');
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
    public function formatStartTime(string $format = 'c'): ?string
    {
        return null;
    }
}
