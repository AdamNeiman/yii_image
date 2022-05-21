<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use app\models\ImageFile;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionUpload()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
			
			$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			$fileNames = $model->upload();
			if ( $fileNames !== false ) {
                // file is uploaded successfully
				$msg = 'Файлы загружены.<br>Имена файлов ('.count($fileNames).'):<br>'.implode('<br>', $fileNames);
				Yii::$app->session->setFlash('uploadFormSubmitted', $msg);
				
                
            } else {
				$msg = 'Ошибка.<br>Не удалось загрузить файлы.<br><br>Возможно файл/файлы превышает допустимый размер: '.ini_get('upload_max_filesize');
				Yii::$app->session->setFlash('uploadFormSubmittedError', $msg);
			}
			
            //return $this->refresh();
        }
		
        return $this->render('upload', [
            'model' => $model,
        ]);
    }
	
	public function actionShow() {
		
		$dataProvider = new ActiveDataProvider([
			'query' => ImageFile::find(),
			'pagination' => [
				'pageSize' => 10,
			],
			
			'sort'=>[
				'defaultOrder'=>[
					 'id'=>SORT_DESC
				]
			]
			
		]);
		
		return $this->render('show', [
			'dataProvider' => $dataProvider
        ]);
	}
	
}
