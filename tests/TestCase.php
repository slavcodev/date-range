<?php

declare(strict_types=1);

namespace Zee\DateRange;

use DateTimeImmutable;
use PHPUnit\Framework;

abstract class TestCase extends Framework\TestCase
{
    private null|DateTimeImmutable $yesterday = null;
    private null|DateTimeImmutable $today = null;
    private null|DateTimeImmutable $tomorrow = null;

    final protected function yesterday(): DateTimeImmutable
    {
        return $this->yesterday ??= new DateTimeImmutable('-1 day');
    }

    final protected function tomorrow(): DateTimeImmutable
    {
        return $this->tomorrow ??= new DateTimeImmutable('+1 day');
    }

    final protected function today(): DateTimeImmutable
    {
        return $this->today ??= new DateTimeImmutable('now');
    }
}
