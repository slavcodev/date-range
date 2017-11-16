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
 * Immutable implementation of date range.
 *
 * This class behaves the same as `{@see DateRange}`
 * except it never modifies itself but returns a new object instead.
 */
final class DateRangeImmutable implements DateRangeInterface
{
    /**
     * @var DateRange
     */
    private $storage;

    /**
     * @param DateTimeInterface $begin
     * @param DateTimeInterface $end
     */
    public function __construct(DateTimeInterface $begin, DateTimeInterface $end = null)
    {
        $this->storage = new DateRange($begin, $end);
    }

    /**
     * Clones internal storage.
     */
    public function __clone()
    {
        $this->storage = clone $this->storage;
    }

    /**
     * {@inheritdoc}
     */
    public function getBegin(): DateTimeInterface
    {
        return $this->storage->getBegin();
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd(): DateTimeInterface
    {
        return $this->storage->getEnd();
    }

    /**
     * {@inheritdoc}
     */
    public function isFinite(): bool
    {
        return $this->storage->isFinite();
    }

    /**
     * {@inheritdoc}
     */
    public function isBeginAt(DateTimeInterface $time): bool
    {
        return $this->storage->isBeginAt($time);
    }

    /**
     * {@inheritdoc}
     */
    public function isEndAt(DateTimeInterface $time): bool
    {
        return $this->storage->isEndAt($time);
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return $this->storage->isStarted();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->storage->isEnded();
    }

    /**
     * {@inheritdoc}
     */
    public function beginAt(DateTimeInterface $time): DateRangeInterface
    {
        $clone = clone $this;
        $clone->storage->beginAt($time);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function endAt(DateTimeInterface $time): DateRangeInterface
    {
        $clone = clone $this;
        $clone->storage->endAt($time);

        return $clone;
    }
}
