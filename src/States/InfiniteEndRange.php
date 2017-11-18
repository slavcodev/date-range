<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class InfiniteEndRange.
 */
final class InfiniteEndRange extends RangeState
{
    /**
     * @var DateTimeInterface
     */
    private $startDate;

    /**
     * @param DateTimeInterface $startDate
     */
    public function __construct(DateTimeInterface $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function hasStartDate(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndDate(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate(): DateTimeInterface
    {
        throw new DateRangeException('Range end is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTimeInterface $start): RangeState
    {
        return new InfiniteEndRange($start);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTimeInterface $end): RangeState
    {
        return new FiniteRange($this->startDate, $end);
    }

    /**
     * {@inheritdoc}
     */
    public function formatEndDate(string $format = 'c'): ?string
    {
        return null;
    }
}
