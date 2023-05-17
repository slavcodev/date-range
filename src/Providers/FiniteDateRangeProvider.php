<?php
/**
 * This file is part of Zee Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/zee/
 */

declare(strict_types=1);

namespace Zee\DateRange\Providers;

use DateTimeInterface;
use Zee\DateRange\DateRange;
use Zee\DateRange\DateRangeInterface;
use Zee\DateRange\DateRangeProvider;

/**
 * Finite date range provider.
 */
final readonly class FiniteDateRangeProvider implements DateRangeProvider
{
    public function __construct(
        private DateTimeInterface $startDate,
        private DateTimeInterface $endDate,
    ) {
    }

    public function getDateRange(): DateRangeInterface
    {
        return new DateRange($this->startDate, $this->endDate);
    }
}
