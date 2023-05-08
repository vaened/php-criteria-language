<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Dates;

use DateTimeImmutable;

use function preg_replace;

final class Day extends Dateable
{
    public function __construct(string $yearString)
    {
        parent::__construct(
            new DateTimeImmutable(
                preg_replace('/^(\d{4})(\d{2})(\d{2})$/', '$1-$2-$3', $yearString)
            )
        );
    }

    public function end(): DateTimeImmutable
    {
        return $this->endOfDayDatetime();
    }
}
