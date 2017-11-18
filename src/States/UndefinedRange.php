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
        return new InfiniteEndRange($start);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTimeInterface $end): RangeState
    {
        return new InfiniteStartRange($end);
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
