<?php

namespace Zee\DateRange\States;

use DateTimeInterface;
use Zee\DateRange\DateRangeException;

/**
 * Class InfiniteStartRange.
 */
final class InfiniteStartRange extends RangeState
{
    /**
     * @var DateTimeInterface
     */
    private $endDate;

    /**
     * @param DateTimeInterface $endDate
     */
    public function __construct(DateTimeInterface $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndDate(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate(): DateTimeInterface
    {
        throw new DateRangeException('Range start is undefined');
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTimeInterface $start): RangeState
    {
        return new FiniteRange($start, $this->endDate);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTimeInterface $end): RangeState
    {
        return new InfiniteStartRange($end);
    }

    /**
     * {@inheritdoc}
     */
    public function formatStartDate(string $format = 'c'): ?string
    {
        return null;
    }
}
