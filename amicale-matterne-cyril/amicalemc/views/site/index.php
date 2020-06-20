<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">
        <h1><?=Yii::t('app', 'Welcome to the brand new site of <br>The Friendship Club of Cyril Matterne') ?></h1>

    </div>

    <div class="body-content">

        <?= Html::img('@web/images/noun_friendship_2849222.png', ['alt'=>'', 'class'=>'img-fluid mx-auto d-block', 'style'=>'width:40%'])?>

    </div>
</div>
