<?php
/* @var View $this */
/* @var Plan $plan */

/* @var array $paymentParams */

use frontend\models\Plan;
use yii\helpers\Html;
use frontend\components\View;

?>
<style>
    .btn-secondary, .btn-secondary:hover, .btn-secondary:disabled {
        color: #fff !important;
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
</style>
<?= Html::beginForm(['plans/generate-custom'], 'post', ['class' => 'form-plan']) ?>

<?= Html::hiddenInput('id', $plan->id) ?>
<div class="row quantity-block">
    <div class="col-md-1 offset-4" style="top:10px;">
        <i class="fa fa-minus minus" data-active="<?= $plan->isFree() ? 0 : 1 ?>"></i>
    </div>
    <div class="col-md-2">
        <?= Html::textInput('quantity', 1, [
            'class'    => 'inp-val form-control m-r-5',
            'style'    => 'width:64px; text-align:center;',
            'readonly' => $plan->isFree(),
            'disabled' => $plan->isFree(),
        ]) ?>
    </div>
    <div class="col-md-1" style="top:10px;">
        <i class="fa fa-plus plus" data-active="<?= $plan->isFree() ? 0 : 1 ?>"></i>
    </div>
</div>
<?php
$buttonClass = $plan->isFree() ? 'btn btn-secondary btn-lg' : 'btn btn-primary btn-lg';
?>
<?= Html::submitButton('Select', [
    'class'    => [
        $buttonClass,
        $plan->isFree() ? 'disabled' : null,
    ],
    'disabled' => $plan->isFree(),
    'style'    => 'margin-top:20px;',
]) ?>

<?= Html::endForm() ?>
<form action="https://www.paypal.com/cgi-bin/webscr"
      id="form-paypal-<?= $plan->id ?>"
      method="post"
      style="display: none"
>
    <?php
    foreach ($paymentParams as $fieldName => $paymentParam) {
        echo '<input type="hidden" name="' . $fieldName . '" value="' . $paymentParam . '">';
    }
    ?>
    <input type="hidden" name="a3" value="<?= $plan->price ?>" id="plan-price-<?= $plan->id ?>">
    <input type="hidden" name="p3" value="<?= $plan->subscription_duration ?: 30 ?>">
    <input type="hidden" name="custom" value="" id="plan-custom-<?= $plan->id ?>">
    <input type="submit" id="submit-<?= $plan->id ?>">
</form>
<?php $this->registerJs(/* @lang JavaScript */ '
$(document).on("click", ".minus", function() {
    if ($(this).data("active") == 0) {
        return false;
    }
    var input = $(this).closest(".quantity-block").find("input"); 
    var value = parseInt(input.val()) - 1;
    if (value < 1) {
        return false;
    }
    var target_limit = $(this).closest(".pricing-inner").find(".target_limit");
    var limit = target_limit.data("limit")
        target_limit.html(parseInt(target_limit.html()) - limit);
    input.val(value);
});
', View::POS_READY, 'quantity minus') ?>
<?php $this->registerJs(/* @lang JavaScript */ '
$(document).on("click",".plus", function() {
    if ($(this).data("active") == 0) {
        return false;
    }
    var input = $(this).closest(".quantity-block").find("input");
    var value = parseInt(input.val()) + 1;
    if (value < 1) {
        return false;
    }
    var target_limit = $(this).closest(".pricing-inner").find(".target_limit");
    var limit = target_limit.data("limit")
        target_limit.html(parseInt(target_limit.html()) + limit);
        input.val(value);
});
', View::POS_READY, 'quantity plus') ?>

<?php $this->registerJs(/* @lang JavaScript */ '
    $(".form-plan").on("submit", function (e) {
       e.preventDefault(); 
       var form = $(this);
       var url = form.attr("action");
    
        $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
               {
                   var id = null;
                   var dataForm = form.serializeArray();
                   for (var i = 0; i< dataForm.length; i++) {
                       var item = dataForm[i];
                       if (item.name == "id") {
                           id = item.value;
                       }
                   }
                   data = JSON.parse(data);
                   $("#plan-custom-" + id).val(data.custom);
                   $("#plan-price-" + id).val(data.price);
                   $("#submit-" + id).trigger("click");
               }
         });
    })
', View::POS_READY, 'actionInput') ?>
