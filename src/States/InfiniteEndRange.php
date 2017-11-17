<?php

namespace Zee\DateRange\States;

use DateTimeImmutable;
use DateTimeInterface;
use Zee\DateRange\DateRangeException;

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
        return new FiniteRange($this->startTime, $time);
    }

    /**
     * {@inheritdoc}
     */
    public function isStartAt(DateTimeInterface $time): bool
    {
        return $this->startTime->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return $this->startTime <= new DateTimeImmutable();
    }
}
