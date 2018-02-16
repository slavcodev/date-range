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
use DateTimeInterface;
use Traversable;

/**
 * Date range interface.
 */
interface DateRangeInterface
{
    /**
     * Returns string representation of range.
     *
     * {@inheritdoc}
     */
    public function __toString(): string;

    /**
     * Returns whether the starting date is defined.
     *
     * @return bool
     */
    public function hasStartDate(): bool;

    /**
     * Returns whether the ending date is defined.
     *
     * @return bool
     */
    public function hasEndDate(): bool;

    /**
     * Returns the starting date point.
     *
     * @return DateTimeInterface
     */
    public function getStartDate(): DateTimeInterface;

    /**
     * Returns the ending date point.
     *
     * @return DateTimeInterface
     */
    public function getEndDate(): DateTimeInterface;

    /**
     * Sets new starting date point.
     *
     * @param DateTimeInterface $start
     *
     * @return DateRangeInterface
     */
    public function setStartDate(DateTimeInterface $start): DateRangeInterface;

    /**
     * Sets new ending date point.
     *
     * @param DateTimeInterface $end
     *
     * @return DateRangeInterface
     */
    public function setEndDate(DateTimeInterface $end): DateRangeInterface;

    /**
     * Returns whether the starting and ending date is defined.
     *
     * @return bool
     */
    public function isFinite(): bool;

    /**
     * Tells whether range is started at specific date.
     *
     * @param DateTimeInterface $date
     *
     * @return bool
     */
    public function isStartedOn(DateTimeInterface $date): bool;

    /**
     * Tells whether range is ended at specific date.
     *
     * @param DateTimeInterface $date
     *
     * @return bool
     */
    public function isEndedOn(DateTimeInterface $date): bool;

    /**
     * Tells whether range is started at current date.
     *
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * Tells whether range is ended at current date.
     *
     * @return bool
     */
    public function isEnded(): bool;

    /**
     * Returns the range duration in seconds.
     *
     * @return int
     */
    public function getTimestampInterval(): int;

    /**
     * Returns the range interval.
     *
     * @return DateInterval
     */
    public function getDateInterval(): DateInterval;

    /**
     * Returns date period according to a given interval.
     *
     * Allows iteration over the range.
     *
     * @param DateInterval $interval
     * @param int $option
     *
     * @return DatePeriod|DateTimeInterface[]
     */
    public function getDatePeriod(DateInterval $interval, int $option = 0): DatePeriod;

    /**
     * Splits range into smaller ranges according to a given interval.
     *
     * All resulting ranges (except first and last) starts on same date as previously ends.
     * The first starts on same date as parent range, last ends on same date as parent range.
     *
     * Keep in mind that the last range may be equal or lesser than the given interval.
     *
     * @param DateInterval $interval
     *
     * @return Traversable
     */
    public function split(DateInterval $interval): Traversable;
}
