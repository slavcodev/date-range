<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class UndefinedRange.
 */
final class UndefinedRange extends RangeState
{
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
        return new InfiniteStartRange($time);
    }

    /**
     * {@inheritdoc}
     */
    public function formatStartTime(string $format = 'c'): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function formatEndTime(string $format = 'c'): ?string
    {
        return null;
    }
}
