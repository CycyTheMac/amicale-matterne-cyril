<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\City;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'format'=>'yyyy-mm-dd'
        ]
]); ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cityid')->dropDownList(
        ArrayHelper::map(City::find()->all(), 'id', 'name', 'zip')
    ) ?>

    <?= $form->field($model, 'iban')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
