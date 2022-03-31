<?php
/* @var View $this */
/* @var string $content */

use frontend\assets\AdminAsset;
use frontend\components\View;
use yii\helpers\Html;
use yii\helpers\Url;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="ppe-verify" content="ppe-3af2a71bfae878c5cf10829167c0d37267f2a463">

    <link rel="apple-touch-icon" sizes="180x180" href="//theme/images/genieping/brand/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="//theme/images/genieping/brand/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="//theme/images/genieping/brand/favicon/favicon-16x16.png">
    <link rel="manifest" href="//theme/images/genieping/brand/favicon/site.webmanifest">
    <link rel="mask-icon" href="//theme/images/genieping/brand/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="//theme/images/genieping/brand/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-config" content="//theme/images/genieping/brand/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body class="dark-only">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
