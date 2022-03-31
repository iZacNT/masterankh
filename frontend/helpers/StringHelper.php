<?php

namespace frontend\helpers;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * Make string shorter than $length.
     * @param string $str
     * @param int $length - max lenght
     * @return string
     */
    public static function shortener(string $str, int $length)
    {
        $currentLength = mb_strlen($str, 'utf-8');
        $result = mb_substr($str, 0, $length, 'utf-8');
        if ($length < $currentLength) {
            $result.= '...';
        }
        return $result;
    }
}
