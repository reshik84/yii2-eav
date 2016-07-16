<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */
?>
<?php Pjax::begin([
    'enablePushState' => FALSE
]); ?>
<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'username',
            'email',
            'text',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y H:i:s']
            ]
        ]
    ]);
?>
<?php Pjax::end(); ?>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?= $form->field($model, 'username')->textInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'text')->textarea() ?>
<?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
<?= yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
<?php \yii\widgets\ActiveForm::end(); ?>