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
 * Null-object date range.
 */
final class NullDateRange implements DateRangeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBegin(): DateTimeInterface
    {
        throw new DateRangeException('Date range is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd(): DateTimeInterface
    {
        throw new DateRangeException('Date range is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function isFinite(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isBeginAt(DateTimeInterface $time): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isEndAt(DateTimeInterface $time): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function beginAt(DateTimeInterface $time): DateRangeInterface
    {
        throw new DateRangeException('Date range is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function endAt(DateTimeInterface $time): DateRangeInterface
    {
        throw new DateRangeException('Date range is undefined');
    }
}
