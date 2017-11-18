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
     * Returns whether the starting time is defined.
     *
     * @return bool
     */
    public function hasStartTime(): bool;

    /**
     * Returns whether the ending time is defined.
     *
     * @return bool
     */
    public function hasEndTime(): bool;

    /**
     * Returns the starting time point.
     *
     * @return DateTimeInterface
     */
    public function getStartTime(): DateTimeInterface;

    /**
     * Returns the ending time point.
     *
     * @return DateTimeInterface
     */
    public function getEndTime(): DateTimeInterface;

    /**
     * Sets new starting time point.
     *
     * @param DateTimeInterface $time
     *
     * @return DateRangeInterface
     */
    public function setStartTime(DateTimeInterface $time): DateRangeInterface;

    /**
     * Sets new ending time point.
     *
     * @param DateTimeInterface $time
     *
     * @return DateRangeInterface
     */
    public function setEndTime(DateTimeInterface $time): DateRangeInterface;

    /**
     * Tells whether range is started at specific time.
     *
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isStartedAt(DateTimeInterface $time): bool;

    /**
     * Tells whether range is ended at specific time.
     *
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isEndedAt(DateTimeInterface $time): bool;

    /**
     * Tells whether range is started at current time.
     *
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * Tells whether range is ended at current time.
     *
     * @return bool
     */
    public function isEnded(): bool;

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
