<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

declare(strict_types=1);

namespace Zee\DateRange;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;
use Traversable;
use Zee\DateRange\States\RangeState;
use Zee\DateRange\States\UndefinedState;

use function sprintf;

/**
 * Implementation of date range value object.
 */
final class DateRange implements DateRangeInterface, JsonSerializable
{
    private RangeState $state;

    public function __construct(
        null|DateTimeInterface $startDate = null,
        null|DateTimeInterface $endDate = null,
    ) {
        $state = new UndefinedState();

        if (isset($startDate)) {
            $state = $state->withStartDate($startDate);
        }

        if (isset($endDate)) {
            $state = $state->withEndDate($endDate);
        }

        $this->state = $state;
    }

    /**
     * Returns string representation of range.
     *
     * @psalm-suppress RiskyTruthyFalsyComparison
     */
    public function __toString(): string
    {
        return sprintf(
            '%s/%s',
            $this->state->formatStartDate('c') ?: '-',
            $this->state->formatEndDate('c') ?: '-'
        );
    }

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
     */
    public function jsonSerialize(): array
    {
        return [
            'startDate' => $this->state->formatStartDate(),
            'endDate' => $this->state->formatEndDate(),
        ];
    }

    public function hasStartDate(): bool
    {
        return $this->state->hasStartDate();
    }

    public function hasEndDate(): bool
    {
        return $this->state->hasEndDate();
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->state->getStartDate();
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->state->getEndDate();
    }

    public function setStartDate(DateTimeInterface $start): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->withStartDate($start);

        return $clone;
    }

    public function setEndDate(DateTimeInterface $end): DateRangeInterface
    {
        $clone = clone $this;
        $clone->state = $clone->state->withEndDate($end);

        return $clone;
    }

    public function isFinite(): bool
    {
        return $this->hasStartDate() && $this->hasEndDate();
    }

    public function isStartedOn(DateTimeInterface $date): bool
    {
        return $this->hasStartDate() && $this->state->compareStartDate($date) === 0;
    }

    public function isEndedOn(DateTimeInterface $date): bool
    {
        return $this->hasEndDate() && $this->state->compareEndDate($date) === 0;
    }

    public function isStarted(): bool
    {
        if ($this->hasStartDate()) {
            return $this->state->compareStartDate(new DateTimeImmutable()) <= 0;
        }

        return ! $this->isEnded();
    }

    public function isEnded(): bool
    {
        return $this->hasEndDate() && $this->state->compareEndDate(new DateTimeImmutable()) < 0;
    }

    public function getTimestampInterval(): int
    {
        return $this->getEndDate()->getTimestamp() - $this->getStartDate()->getTimestamp();
    }

    public function getDateInterval(): DateInterval
    {
        return $this->getStartDate()->diff($this->getEndDate());
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
     */
    public function getDatePeriod(DateInterval $interval, int $option = 0): DatePeriod
    {
        return new DatePeriod($this->getStartDate(), $interval, $this->getEndDate(), $option);
    }

    public function split(DateInterval $interval): Traversable
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();
        $period = $this->getDatePeriod($interval, DatePeriod::EXCLUDE_START_DATE);

        foreach ($period as $date) {
            yield new self($startDate, $date);
            $startDate = $date;
        }

        yield new self($startDate, $endDate);
    }
}
