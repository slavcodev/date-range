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

use DomainException;
use Throwable;

/**
 * Date range exception.
 */
final class DateRangeException extends DomainException implements Exception
{
    /**
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Invalid data range', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
