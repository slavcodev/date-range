<?php

namespace Zee\DateRange\States;

use DateTimeImmutable;
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
    public function hasStartTime(): bool
    {
        return false;
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
        throw new DateRangeException('Date range is undefined');
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
    public function isEndAt(DateTimeInterface $time): bool
    {
        return $this->endTime->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->endTime <= new DateTimeImmutable();
    }
}
