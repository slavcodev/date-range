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

use DomainException;
use Throwable;

/**
 * Date range exception.
 */
final class InvalidDateRangeDateRangeException extends DomainException implements DateRangeException
{
    public function __construct(string $message = 'Invalid data range', null|Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
