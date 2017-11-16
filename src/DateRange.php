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

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Date range implementation.
 */
final class DateRange implements DateRangeInterface
{
    /**
     * @var DateTimeInterface
     */
    private $begin;

    /**
     * @var DateTimeInterface
     */
    private $end;

    /**
     * @param DateTimeInterface $begin
     * @param DateTimeInterface $end
     */
    public function __construct(DateTimeInterface $begin, DateTimeInterface $end = null)
    {
        $this->guardDateSequence($begin, $end);

        $this->begin = $begin;
        $this->end = $end;
    }

    /**
     * {@inheritdoc}
     */
    public function getBegin(): DateTimeInterface
    {
        return $this->begin;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd(): DateTimeInterface
    {
        return $this->end;
    }

    /**
     * {@inheritdoc}
     */
    public function isFinite(): bool
    {
        return $this->end instanceof DateTimeInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function isBeginAt(DateTimeInterface $time): bool
    {
        return $this->begin->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isEndAt(DateTimeInterface $time): bool
    {
        return $this->end->getTimestamp() === $time->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(): bool
    {
        return $this->begin <= new DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnded(): bool
    {
        return $this->isFinite() && $this->end <= new DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function beginAt(DateTimeInterface $time): DateRangeInterface
    {
        $this->guardDateSequence($time, $this->end);

        $this->begin = $time;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function endAt(DateTimeInterface $time): DateRangeInterface
    {
        $this->guardDateSequence($this->begin, $time);

        $this->end = $time;

        return $this;
    }

    /**
     * @param DateTimeInterface $begin
     * @param DateTimeInterface|null $end
     */
    private function guardDateSequence(DateTimeInterface $begin, DateTimeInterface $end = null)
    {
        if ($end && $end <= $begin) {
            throw new DateRangeException('Invalid end, must be after begin');
        }
    }
}
