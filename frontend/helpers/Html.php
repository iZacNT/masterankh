<?php

namespace frontend\helpers;

class Html extends \yii\helpers\Html
{
    /**
     * Client redirect using JS.
     * @param string $url
     * @param float $delay - seconds
     * @return string
     */
    public static function redirect(string $url, float $delay = 0): string
    {
        $delay *= 1000;
        $js = 'window.location.replace("' . $url . '");';
        if ($delay) {
            $js = 'setTimeout(function () {' . $js . '}, ' . (int)$delay . ');';
        }
        return static::tag('script', $js, ['type' => 'text/javascript']);
    }
}
