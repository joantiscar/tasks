<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 22/11/18
 * Time: 20:14
 */

namespace App\Traits;


use Carbon\Carbon;

trait FormattedDates

{
    public function getCreatedAttributeFormatted()
    {
        // Carbon
        return optional($this->created_at)->format('h:i:sA d-m-Y');
    }
    public function getCreatedTimeStampFormatted()
    {

        return optional($this->created_at)->timestamp;
    }
    public function getCreatedAttributeHuman()
    {
        // Carbon
        Carbon::setLocale(config('app.locale'));
        return optional($this->created_at)->diffForHumans(Carbon::now());
    }
    public function getUpdatedAttributeFormatted()
    {
        // Carbon
        return optional($this->updated_at)->format('h:i:sA d-m-Y');
    }
    public function getUpdatedTimeStampFormatted()
    {

        return optional($this->updated_at)->timestamp;
    }
    public function getUpdatedAttributeHuman()
    {
        // Carbon
        Carbon::setLocale(config('app.locale'));
        return optional($this->updated_at)->diffForHumans(Carbon::now());
    }
}