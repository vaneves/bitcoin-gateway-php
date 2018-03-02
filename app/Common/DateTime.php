<?php

namespace App\Common;

use Carbon\Carbon;

class DateTime
{
    private $date;

    private function __construct() {}

    public function __toString()
    {
        return $this->date->toDateTimeString();
    }

    public function getDate()
    {
        return $this->date;
    }

    public static function now()
    {
        $instance = new self();
        $instance->date = new Carbon();
        return $instance;
    }

    public static function fromFormat($format, $date)
    {
        $instance = new self();
        $instance->date = Carbon::createFromFormat($format, $date);
        return $instance;
    }

    public function toDate()
    {
        return $this->date->toDateString();
    }

    public function toTime()
    {
        return $this->date->toTimeString();
    }

    public function toDateTime()
    {
        return $this->date->toDateTimeString();
    }

    public function toStart()
    {
        return $this->date->toDateString() .' 00:00:00';
    }

    public function toEnd()
    {
        return $this->date->toDateString() .' 23:59:59';
    }

    public function subDays($days)
    {
        $this->date->subDays($days);
        return $this;
    }
}