<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * State of the undefined range.
 */
final class UndefinedState extends RangeState
{
    /**
     * {@inheritdoc}
     */
    public function getStartDate(): DateTimeInterface
    {
        throw new DateRangeException('Range start is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate(): DateTimeInterface
    {
        throw new DateRangeException('Range end is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTimeInterface $start): RangeState
    {
        return new InfiniteEndState($start);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTimeInterface $end): RangeState
    {
        return new InfiniteStartState($end);
    }

    /**
     * {@inheritdoc}
     */
    public function formatStartDate(string $format = 'c'): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function formatEndDate(string $format = 'c'): ?string
    {
        return null;
    }
}
