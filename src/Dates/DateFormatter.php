<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Dates;

use function strlen;

final class DateFormatter
{
    public static function createFrom(string $dateString): Dateable
    {
        return match (strlen($dateString)) {
            4 => new Year($dateString),
            6 => new Month($dateString),
            8 => new Day($dateString),
        };
    }
}
