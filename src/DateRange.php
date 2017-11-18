<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

namespace Zee\DateRange;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;
use Zee\DateRange\States\RangeState;
use Zee\DateRange\States\UndefinedRange;

/**
 * Implementation of date range value object.
 */
final class DateRange implements DateRangeInterface, JsonSerializable
{
    /**
     * @var RangeState
     */
    private $state;

    /**
     * @param DateTimeInterface|null $startTime
     * @param DateTimeInterface|null $endTime
     */
    public function __construct(DateTimeInterface $startTime = null, DateTimeInterface $endTime = null)
    {
        $state = new UndefinedRange();

        if (isset($startTime)) {
            $state = $state->setStartTime($startTime);
        }

        if (isset($endTime)) {
            $state = $state->setEndTime($endTime);
        }

        $this->state = $state;
    }

    /**
     * Returns string representation of range.
     *
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return (string) $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function __debugInfo()
    {
        return [
            'startTime' => $this->state->hasStartTime()
                ? $this->state->getStartTime()
                : null,
            'endTime' => $this->state->hasEndTime()
                ? $this->state->getEndTime()
                : null,
        ];
    }

    /**
     * Returns value ready to be encoded as JSON.
     *
     * The ISO-8601 range format is used for times.
     *
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->state->jsonSerialize();
    }

    /**
     * {@inheritdoc}
     */
    public function hasStartTime(): bool
    {
        return $this->state->hasStartTime();
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndTime(): bool
    {
        return $this->state->hasEndTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime(): DateTimeInterface
    {
        return $this->state->getStartTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime(): DateTimeInterface
    {
        return $this->state->getEndTime();
    }

    /**
     * {@inheritdoc}
     */
    public function setStartTime(DateTimeInterface $time): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->setStartTime($time);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTime(DateTimeInterface $time): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->setEndTime($time);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function isStartedAt(DateTimeInterface $time): bool
    {
        return $this->hasStartTime() && $this->state->compareStartTime($time) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isEndedAt(DateTimeInterface $time): bool
    {
        return $this->hasEndTime() && $this->state->compareEndTime($time) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        if ($this->hasStartTime()) {
            return $this->state->compareStartTime(new DateTimeImmutable()) <= 0;
        } else {
            return $this->hasEndTime();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->hasEndTime() && $this->state->compareEndTime(new DateTimeImmutable()) < 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateInterval(): DateInterval
    {
        return $this->getStartTime()->diff($this->getEndTime());
    }

    /**
     * {@inheritdoc}
     */
    public function getDatePeriod(DateInterval $interval, int $option = 0): DatePeriod
    {
        return new DatePeriod($this->getStartTime(), $interval, $this->getEndTime(), $option);
    }
}
