<?php

namespace App\Transformers;

class DailyRosterTransformer
{
    /**
     * @param $data
     * @return mixed|string[]
     */
    public static function trnaform($data): mixed
    {
       return (!$data) ? ["status" => "You are free today"] : $data;
    }

}
