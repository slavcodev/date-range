<?php

namespace Zee\DateRange\States;

use DateTimeImmutable;
use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class FiniteRange.
 */
final class FiniteRange extends UndefinedRange
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
    public function __toString(): string
    {
        return sprintf('%s/%s', $this->startTime->format('c'), $this->endTime->format('c'));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return ['startTime' => $this->startTime->format('c'), 'endTime' => $this->endTime->format('c')];
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

    /**
     * {@inheritdoc}
     */
    public function isStartedAt(DateTimeInterface $time): bool
    {
        return $this->startTime->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isEndedAt(DateTimeInterface $time): bool
    {
        return $this->endTime->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return $this->startTime <= new DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->endTime <= new DateTimeImmutable();
    }
}
