<?php

namespace H4zz4rdDev\Seat\SeatBuyback\Helpers;

class MiscHelper
{
    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomString(int $length = 25) : string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}