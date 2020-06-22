<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\mpdf\Pdf;
// use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'People');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Person'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?=
    ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'lastname',
            'firstname',
            [
                'attribute' => 'birthdate',
                'hAlign' => 'center',
            ],
            'email',
            [
                'attribute' => 'tel',
                'hAlign' => 'center',
            ],
            'street',
            'cityName',
            'zip',
            'iban',
        ],
        'target' => '_self',
        'exportConfig' => [
            'Txt' => false,
            'Xls' => false,
        ],
        'exportContainer' => [
            'class' => 'btn-group mr-2'
        ],
        'dropdownOptions' => [
            'label' => 'Export all',
            'class' => 'btn btn-outline-secondary',
        ],
        'showConfirmAlert' => false,
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'lastname',
            'firstname',
            [
                'attribute' => 'birthdate',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'tel',
                'hAlign' => 'center',
            ],
            'cityName',
            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        ],
        // set a label for default menu
        'export' => [
            'label' => 'Export Page',
            'target' => '_self',
            'fontAwesome' => true,
            'header' => '',
        ],
        'exportConfig' => [
            'pdf' => true,
            'html' => true,
            'csv' => true,
            'xls' => true,
            'json' => true,
        ],
        'exportContainer' => [
            'class' => 'btn-group mr-2'
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
        ]
    ]);?>
</div>
