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
use PHPUnit\Framework\TestCase;
use Zee\DateRange\Providers\FiniteDateRangeProvider;

/**
 * Class DateRangeProviderTest.
 */
final class DateRangeProviderTest extends TestCase
{
    /**
     * @test
     */
    public function usingBuilder()
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $calculator = function (FiniteDateRangeProvider $dateRangeProvider) {
            $range = $dateRangeProvider->getDateRange();
            $interval = $range->getDateInterval();

            return $interval->days;
        };

        $dateRangeProvider = new FiniteDateRangeProvider($yesterday, $tomorrow);
        $result = $calculator($dateRangeProvider);

        self::assertSame(2, $result);
    }
}
