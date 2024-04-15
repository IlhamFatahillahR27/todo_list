<?php

namespace App\Helpers;

use App\Models\Group;
use App\Models\Temp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Broadcast;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\App;

class Helper
{
    public function __construct()
    {
    }

    public static function dateTimeFormat($date, $format = 'd F Y H:i:s')
    {
        if (is_null($date)) {
            return '-';
        }

        return Carbon::parse($date)->format($format);
    }

    public static function numberFormat($number = 0, $decimals = 0)
    {
        return 'Rp' . number_format($number, $decimals, ',', '.');
    }

    public static function completeGroup(): Group
    {
        $group = Group::where('for_complete', 1)->first();
        return $group;
    }

    public static function onGoingGroup(): Group
    {
        $group = Group::where('for_complete', 0)->where('is_default', 1)->first();
        return $group;
    }

    public static function convertMoneyToNumber($value)
    {
        return (int)str_replace(['.', 'Rp'], '', $value);
    }

}
