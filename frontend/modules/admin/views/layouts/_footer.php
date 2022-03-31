<?php
/* @var View $this */

use frontend\assets\IcofontAsset;
use frontend\components\View;
?>
<footer class="footer" style="margin-left: 0;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright">
                <p>
                    <?= date('2016 - Y') ?>
                    © www.genieping.com
                </p>
            </div>
            <div class="col-md-6">
                <p class="pull-right">
                    Hand crafted &amp; made with <?= IcofontAsset::icon('heart', 1) ?>
                </p>
            </div>
        </div>
    </div>
</footer>
