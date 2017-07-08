<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class Chain extends ActiveRecord 
{
		public function afterFind()
	{
		parent::afterFind();
		foreach($this as $key => $attribute){
			$this[$key] = Html::encode($attribute);
		}
	}
}
