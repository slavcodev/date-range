<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class UndefinedRange.
 */
class UndefinedRange implements RangeState
{
    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return '-/-';
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return ['startTime' => null, 'endTime' => null];
    }

    /**
     * {@inheritdoc}
     */
    public function hasStartTime(): bool
    {
        return false;
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
        throw new DateRangeException('Date range is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime(): DateTimeInterface
    {
        throw new DateRangeException('Date range is undefined');
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
    public function isStartedAt(DateTimeInterface $time): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isEndedAt(DateTimeInterface $time): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return false;
    }
}
