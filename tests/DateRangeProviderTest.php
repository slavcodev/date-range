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

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Zee\DateRange\Providers\FiniteDateRangeProvider;

#[CoversClass(FiniteDateRangeProvider::class)]
final class DateRangeProviderTest extends TestCase
{
    #[Test]
    public function usingBuilder(): void
    {
        $yesterday = new DateTimeImmutable('-1 day');
        $tomorrow = new DateTimeImmutable('+1 day');
        $calculator = static fn (FiniteDateRangeProvider $dateRangeProvider): int => (int) $dateRangeProvider->getDateRange()->getDateInterval()->days;

        $dateRangeProvider = new FiniteDateRangeProvider($yesterday, $tomorrow);
        $result = $calculator($dateRangeProvider);

        $this->assertSame(2, $result);
    }
}
