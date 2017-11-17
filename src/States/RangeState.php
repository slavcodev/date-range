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
     * Compares start time with specific time.
     *
     * Returns 0 if times are equals, negative if start time is less than given time,
     * and positive if start time is greater.
     *
     * @param DateTimeInterface $time
     *
     * @return int
     */
    public function compareStartTime(DateTimeInterface $time): int;

    /**
     * Compares end time with specific time.
     *
     * Returns 0 if times are equals, negative if end time is less than given time
     * and positive if end time is greater.
     *
     * @param DateTimeInterface $time
     *
     * @return int
     */
    public function compareEndTime(DateTimeInterface $time): int;
}
