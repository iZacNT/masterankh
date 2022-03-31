<?php
/* @var View $this */
/* @var string $content */

use frontend\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\View;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>         
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="apple-touch-icon" sizes="180x180" href="/theme/images/genieping/brand/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/theme/images/genieping/brand/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/theme/images/genieping/brand/favicon/favicon-16x16.png">
        <link rel="manifest" href="/theme/images/genieping/brand/favicon/site.webmanifest">
        <link rel="mask-icon" href="/theme/images/genieping/brand/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/theme/images/genieping/brand/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="msapplication-config" content="/theme/images/genieping/brand/favicon/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">

        <title>Endless - Premium Admin Template</title>
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
    </head>
    <body main-theme-layout="main-theme-layout-4" class="dark-only" style="font-size: 14px;">          
        <?php $this->beginBody() ?>
        <div class="page-wrapper">

            <?= $this->render('_header') ?>

            <div class="page-body-wrapper">
                <div class="page-body">
                    <?= $content ?>
                </div>

                <?= $this->render('_footer') ?>

            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
