<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Dates;

use DateTimeImmutable;

abstract class Dateable
{
    public function __construct(private readonly DateTimeImmutable $datetime)
    {
    }

    abstract public function end(): DateTimeImmutable;

    public function start(): DateTimeImmutable
    {
        return $this->datetime();
    }

    public function datetime(): DateTimeImmutable
    {
        return $this->datetime;
    }

    protected function endOfDayDatetime(): DateTimeImmutable
    {
        return $this->datetime->setTime(23, 59, 59, 999999);
    }

    protected function endOfMonthDatetime(): DateTimeImmutable
    {
        return $this->datetime->setDate($this->year(), $this->month(), $this->daysInMonth())
            ->setTime(23, 59, 59, 999999);
    }

    protected function endOfYearDatetime(): DateTimeImmutable
    {
        return $this->datetime->setDate($this->year(), 12, 31)
            ->setTime(23, 59, 59, 999999);
    }

    private function year(): int
    {
        return (int)$this->datetime->format('Y');
    }

    private function month(): int
    {
        return (int)$this->datetime->format('m');
    }

    private function day(): int
    {
        return (int)$this->datetime->format('d');
    }

    private function daysInMonth(): int
    {
        return (int)$this->datetime->format('t');
    }
}