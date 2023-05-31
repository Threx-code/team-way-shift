<?php

namespace App\Helpers;

use JsonException;

class Helper
{
    /**
     * @param $data
     * @return array|mixed|string|string[]
     * @throws JsonException
     */
    public static function convertToArray($data): mixed
    {
        $toArray = $data;
        if(!is_array($toArray)){
            $toArray = (self::jsonDecode($toArray) ===JSON_ERROR_NONE) ?
                json_decode($toArray, true, 512, JSON_THROW_ON_ERROR) :
                str_replace(['[', ']'], '', explode(',', $toArray));
        }
        return $toArray;
    }

    /**
     * @param $data
     * @return string
     * @throws JsonException
     */
    public static function implodeData($data): string
    {
        $toArray = $data;
        if(!is_array($toArray)){
            if(self::jsonDecode($toArray) === JSON_ERROR_NONE){
                $toArray = json_decode($toArray, true, 512, JSON_THROW_ON_ERROR);
            }else{
                $toArray = str_replace(['[', ']'], '', explode(',', $toArray));
            }
        }
        return implode(',', $toArray);
    }


    /**
     * @param $data
     * @return int
     */
    public static function jsonDecode($data): int
    {
        json_decode($data, true);
        return json_last_error();
    }

}
