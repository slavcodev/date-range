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
use Traversable;
use Zee\DateRange\States\RangeState;
use Zee\DateRange\States\UndefinedState;

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
     * @param DateTimeInterface|null $startDate
     * @param DateTimeInterface|null $endDate
     */
    public function __construct(DateTimeInterface $startDate = null, DateTimeInterface $endDate = null)
    {
        $state = new UndefinedState();

        if (isset($startDate)) {
            $state = $state->setStartDate($startDate);
        }

        if (isset($endDate)) {
            $state = $state->setEndDate($endDate);
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
        return sprintf(
            '%s/%s',
            $this->state->formatStartDate('c') ?: '-',
            $this->state->formatEndDate('c') ?: '-'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __debugInfo()
    {
        return [
            'startDate' => $this->state->hasStartDate()
                ? $this->state->getStartDate()
                : null,
            'endDate' => $this->state->hasEndDate()
                ? $this->state->getEndDate()
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
        return [
            'startDate' => $this->state->formatStartDate(),
            'endDate' => $this->state->formatEndDate(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function hasStartDate(): bool
    {
        return $this->state->hasStartDate();
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndDate(): bool
    {
        return $this->state->hasEndDate();
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate(): DateTimeInterface
    {
        return $this->state->getStartDate();
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate(): DateTimeInterface
    {
        return $this->state->getEndDate();
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTimeInterface $start): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->setStartDate($start);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTimeInterface $end): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->setEndDate($end);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function isFinite(): bool
    {
        return $this->hasStartDate() && $this->hasEndDate();
    }

    /**
     * {@inheritdoc}
     */
    public function isStartedOn(DateTimeInterface $date): bool
    {
        return $this->hasStartDate() && $this->state->compareStartDate($date) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isEndedOn(DateTimeInterface $date): bool
    {
        return $this->hasEndDate() && $this->state->compareEndDate($date) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        if ($this->hasStartDate()) {
            return $this->state->compareStartDate(new DateTimeImmutable()) <= 0;
        } else {
            return !$this->isEnded();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->hasEndDate() && $this->state->compareEndDate(new DateTimeImmutable()) < 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateInterval(): DateInterval
    {
        return $this->getStartDate()->diff($this->getEndDate());
    }

    /**
     * {@inheritdoc}
     */
    public function getDatePeriod(DateInterval $interval, int $option = 0): DatePeriod
    {
        return new DatePeriod($this->getStartDate(), $interval, $this->getEndDate(), $option);
    }

    /**
     * {@inheritdoc}
     */
    public function split(DateInterval $interval): Traversable
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();
        $period = $this->getDatePeriod($interval, DatePeriod::EXCLUDE_START_DATE);

        foreach ($period as $date) {
            yield new DateRange($startDate, $date);
            $startDate = $date;
        }

        yield new DateRange($startDate, $endDate);
    }
}
