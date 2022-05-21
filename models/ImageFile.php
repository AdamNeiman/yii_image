<?php

/*
CREATE TABLE `image` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fileName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


*/
namespace app\models;

use yii\db\ActiveRecord;

class ImageFile extends ActiveRecord {
	
	    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'fileName' => 'Имя файла',
			'timestamp' => 'Дата/время загрузки'
        ];
    }
	
}
