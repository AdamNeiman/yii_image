<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Просмотр изображений';
$this->params['breadcrumbs'][] = $this->title;

?>


<?php echo newerton\fancybox3\FancyBox::widget(); ?>


<div class="body-content">
	<h1><?= $this->title ?></h2>
	<p>Для сортировки нажмите на заголовок колонки в таблице.</p>
		<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'formatter' => [
					'class' => 'yii\i18n\Formatter',
					'timeZone' => Yii::$app->params['defaultTimeZone']
				],
				
				'columns' => [
					'id',
					'fileName',
					[
						'label' => 'Дата загрузки ('.Yii::$app->params['defaultTimeZone'].')',
					    'attribute' => 'timestamp',
						'format' => ['date', 'php:d.m.Y H:i:s']
					],
					//'timestamp',
			        
					[
						'label' => 'Предпросмотр',
						'format' => 'raw',
						'value' => function($data){
							
							return Html::a(Html::img(Yii::$app->params['uploadFolder'].'thumb/'.$data->fileName), 
							
							Yii::$app->params['uploadFolder'].$data->fileName, ['data-fancybox' => true]);

							
							return Html::img(Yii::$app->params['uploadFolder'].'thumb/'.$data->fileName,[
								'alt'=> $data->fileName,
								'style' => 'max-width:200px;'
							]);
						},
					],
			
				],
			]); 
		?>
</div>