<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Загрузить файлы изображений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-upload">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('uploadFormSubmitted')): ?>

        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('uploadFormSubmitted'); ?>
        </div>
		
		<p><a class="btn btn-outline-secondary" href="/index.php?r=site%2Fupload">Загрузить еще &raquo;</a></p>
		<p><a class="btn btn-outline-secondary" href="/index.php?r=site%2Fshow">Посмотреть &raquo;</a></p>
		 
	<?php elseif (Yii::$app->session->hasFlash('uploadFormSubmittedError')): ?>
	    
		<div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('uploadFormSubmittedError'); ?>
        </div>
		
    <?php else: ?>

        <p>
            Выберите одновременно до 5 файлов для загрузки на хостинг.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'upload-form']); ?>

					
					<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

                    <?php 	//$form->field($model, 'verifyCode')->widget(Captcha::className(), [
							//'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
							//]) 
					?>

                    <div class="form-group">
                        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
