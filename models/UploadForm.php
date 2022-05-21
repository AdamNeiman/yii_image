<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\Inflector;

/**
 * ContactForm is the model behind the contact form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
	//public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [            [['imageFiles'], 'required'],
            // imageFiles
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp, gif, bmp', 'maxFiles' => 5],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
			'imageFiles' => 'Файлы изображений'
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
			$UPLOAD_FOLDER = Yii::$app->params['uploadFolder'];
			$fileNames = [];
            foreach ($this->imageFiles as $file) {
				
				$baseName  = mb_strtolower(Inflector::transliterate( $file->baseName ));
				$extension = mb_strtolower(Inflector::transliterate( $file->extension ));
				
				$fileName =  $baseName . '.' . $extension;
				
				$MAX_INT = 300; $count=0;
				while ( file_exists( $UPLOAD_FOLDER .$fileName) && ($count++) < $MAX_INT) {
					$fileName = $baseName . '_' . $count . '.' . $extension;
				}
				
				if ($count >= $MAX_INT) return false;
                
				// файл на диск
				$fileNames[] = $fileName;
				$file->saveAs( $UPLOAD_FOLDER .$fileName );
				
				// генерация миниатюры изображения
				Image::thumbnail($UPLOAD_FOLDER .$fileName, 200, 200)->save($UPLOAD_FOLDER .'thumb/'.$fileName, ['quality' => 70]);

				
				$imageFile = new ImageFile();
				$imageFile->fileName = $fileName;
				$imageFile->timestamp = date ('Y-m-d H:i:s');
				$imageFile->save();
				
            }
            return $fileNames;
        } else {
            return false;
        }
    }
	
	

}
