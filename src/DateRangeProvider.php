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

namespace Zee\DateRange;

/**
 * Date range provider.
 *
 * Interface for builders for predefined ranges.
 */
interface DateRangeProvider
{
    public function getDateRange(): DateRangeInterface;
}
