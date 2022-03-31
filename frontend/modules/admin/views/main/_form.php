<?php
/* @var View $this */
/* @var Job $model */
/* @var string|false $flash */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\helpers\Html;
use frontend\models\Job;
use frontend\widgets\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$user = $model->user ?? Yii::$app->user->identity;
$plan = $model->getPlan();
?>

<?php $form = ActiveForm::begin([
    'fieldClass' => ActiveField::class,
    'enableAjaxValidation' => true,
]) ?>

<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'active')->checkbox() ?>
        </div>
        <div class="col-sm-3 padding-top-1 font-weight-bold">
            Email Sent:
            <?= $model->inform_today ?> out of <?= $plan->inform_limit ?>
        </div>
        <div class="col-sm-3 padding-top-1 font-weight-bold">
            Expiry Date:
            <?= date('d-M-Y', $model->getExpirationDate()) ?>
        </div>
        <div class="col-sm-3">

        </div>
    </div>
</div>

<?= $form->field($model, 'title')->textInput([
    'class' => "form-control btn-square input-md",
]) ?>

<?= $form->field($model, 'url')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'find_method')->dropDownList(Job::$methods) ?>

<?= Html::label($model->getAttributeLabel('template'), 'job-template', ['class' => 'control-label']) ?>

<?php if ($flash): ?>
    <?= IcofontAsset::icon('spinner icofont-spin') ?>
<?php elseif ($model->isExpired()): ?>
    <?= Html::a(
        IcofontAsset::icon('cart text-info'),
        ['plans/index']
    ) ?>
<?php elseif ($model->status == Job::STATUS_TIMEOUT): ?>
    <?= IcofontAsset::icon('clock-time text-warning') ?>
<?php elseif ($model->status == Job::STATUS_FOUND): ?>
    <?= IcofontAsset::icon('check text-success') ?>
<?php else: ?>
    <?= IcofontAsset::icon('close text-danger') ?>
<?php endif ?>

<?= $form->field($model, 'template', ['enableLabel' => false])->textInput([
    'class' => "form-control btn-square input-md",
]) ?>

Primary Email Sending Goals:

<div class="container">
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'inform_found')->checkbox() ?>
            <?= $form->field($model, 'inform_not_found')->checkbox() ?>
            <?php #$form->field($model, 'inform_fail')->checkbox() ?>

            <div class="font-weight-bold">
                Plan:
                <?= Html::encode($plan->name) ?>
            </div>
        </div>
        <div class="col-md-6">
            <fieldset class="padding-top-1 font-weight-bold">
                <legend>Key Map</legend>
                <p>
                    <?= IcofontAsset::icon('check text-success') ?>
                    = Text can be Read
                </p>
                <p>
                    <?= IcofontAsset::icon('close text-danger') ?>
                    = Text cannot be read
                </p>
                <p>
                    <?= IcofontAsset::icon('cart text-info') ?>
                    = Expired, Please purchase
                </p>
                <p>
                    <?= IcofontAsset::icon('clock-time text-warning') ?>
                    = We cant read the Text within <?= Job::CHECK_TIMEOUT ?> Seconds so the check was skipped until the next interval
                </p>
            </fieldset>
        </div>
    </div>
</div>

<?= $form->field($model, 'interval')->dropDownList(Job::$intervals, [
    'disabled' => $plan->isFree(),
]) ?>

<?php if ($plan->isFree()): ?>
    The interval selection is available only for active tariff plans <b>PRO</b> and <b>PREMIUM</b>.
    <?= Html::a(
        'Go to plans page',
        ['/admin/plans']
    ) ?>
<?php endif ?>

<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <?= Html::submitButton('Save & Test', [
                'class' => 'btn btn-info btn-lg',
                'disabled' => $model->isExpired(),
                'formaction' => Url::current(['to' => 'update']),
            ]) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton('Save & Close', [
                'class' => 'btn btn-success btn-lg',
                'disabled' => $model->isExpired(),
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= Html::a('Cancel', ['dashboard'], ['class' => 'btn btn-danger btn-lg']) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-lg',
                'data-confirm' => 'Are you sure you want to "Delete" this ping target? You will not be refunded any payments.',
            ]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>
