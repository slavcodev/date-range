<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use JsonSerializable;

/**
 * Interface RangeState.
 */
interface RangeState extends JsonSerializable
{
    /**
     * Returns string representation of range.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array;

    /**
     * @return bool
     */
    public function hasStartTime(): bool;

    /**
     * @return bool
     */
    public function hasEndTime(): bool;

    /**
     * @return DateTimeInterface
     */
    public function getStartTime(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function getEndTime(): DateTimeInterface;

    /**
     * @param DateTimeInterface $time
     *
     * @return RangeState
     */
    public function setStartTime(DateTimeInterface $time): RangeState;

    /**
     * @param DateTimeInterface $time
     *
     * @return RangeState
     */
    public function setEndTime(DateTimeInterface $time): RangeState;

    /**
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isStartedAt(DateTimeInterface $time): bool;

    /**
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isEndedAt(DateTimeInterface $time): bool;

    /**
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * @return bool
     */
    public function isEnded(): bool;
}
