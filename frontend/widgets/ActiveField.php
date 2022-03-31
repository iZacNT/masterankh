<?php

namespace frontend\widgets;

class ActiveField extends \yii\bootstrap\ActiveField
{
    /**
     * {@inheritdoc}
     */
    public $checkboxTemplate = "<div class=\"checkbox\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>";
}
