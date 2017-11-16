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
     * @return DateTimeInterface
     */
    public function getBegin(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function getEnd(): DateTimeInterface;

    /**
     * @return bool
     */
    public function isFinite(): bool;

    /**
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isBeginAt(DateTimeInterface $time): bool;

    /**
     * @param DateTimeInterface $time
     *
     * @return bool
     */
    public function isEndAt(DateTimeInterface $time): bool;

    /**
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * @return bool
     */
    public function isEnded(): bool;

    /**
     * @param DateTimeInterface $time
     *
     * @return DateRangeInterface
     */
    public function beginAt(DateTimeInterface $time): DateRangeInterface;

    /**
     * @param DateTimeInterface $time
     *
     * @return DateRangeInterface
     */
    public function endAt(DateTimeInterface $time): DateRangeInterface;
}
