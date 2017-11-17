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

use DateTimeInterface;

/**
 * Date range interface.
 */
interface DateRangeInterface
{
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
    public function isStartAt(DateTimeInterface $time): bool;

    /**
     * Tells whether range is ended at specific time.
     *
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isEndAt(DateTimeInterface $time): bool;

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
}
