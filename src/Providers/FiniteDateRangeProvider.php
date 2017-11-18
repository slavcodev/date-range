<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

namespace Zee\DateRange\Providers;

use DateTimeInterface;
use Zee\DateRange\DateRange;
use Zee\DateRange\DateRangeInterface;
use Zee\DateRange\DateRangeProvider;

/**
 * Finite date range provider.
 */
final class FiniteDateRangeProvider implements DateRangeProvider
{
    /**
     * @var DateTimeInterface
     */
    private $startDate;

    /**
     * @var DateTimeInterface
     */
    private $endDate;

    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     */
    public function __construct(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateRange(): DateRangeInterface
    {
        return new DateRange($this->startDate, $this->endDate);
    }
}
