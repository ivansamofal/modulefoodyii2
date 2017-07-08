<?php
namespace app\modules\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\models\Ingredients;
use app\modules\models\Dishes;
use app\modules\models\Chain;


class DishesController extends Controller
{
    /**
     * @inheritdoc
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionAdddish(){
		$ingredients = Ingredients::find()->where([ 'active' => 1 ])->all();
		$idDish = intval(htmlspecialchars(trim(Yii::$app->request->get()['id'])));
		if( Yii::$app->request->post("Dishes") ){
			/*$model = new Dishes();
			$model->name = htmlspecialchars(trim(Yii::$app->request->post("Dishes")['name']));
			$model->active = htmlspecialchars(trim(Yii::$app->request->post("Dishes")['active']));
			$model->save();*/
		}else{
			$model = Dishes::find()->where([ 'id' => $idDish])->one();
		}
		
		return $this->render('adddish', [
			'model' => $model,
			'ingredients' => $ingredients
		]);
	}
	
	public function actionDlist(){
		
		$dishes = Dishes::find()->all();
		return $this->render('dlist', [
			'model' => $model,
			'dishes' => $dishes,
			
		]);
	}
		public function actionList(){
		//$ingredients = Ingredients::find()->where([ 'active' => 1 ])->all();
		$dishes = Dishes::find()->where([ 'active' => 1 ])->all();
		$ingredientsArray = array();
		$i = 0;
		foreach( $dishes as $dishe ){
			
			$query = new \yii\db\Query;
			$query->select('`ingredients`.`name`')
            ->from('`ingredients`')
            ->leftJoin('`chain`', '`ingredients`.`id` = `chain`.`id_ingregient`')
			->leftJoin('`dishes`', '`dishes`.`id` = `chain`.`id_dishes`')
			->where(['`chain`.`id_dishes`' => $dishe->id])
			->Andwhere(['`dishes`.`active`' => 1])
			->Andwhere(['`ingredients`.`active`' => 1]);
            //->limit($Limit);
			$command = $query->createCommand();
			$ingredients = $command->queryAll();
			
			if( count($ingredients) ){
				foreach( $ingredients as $ingredient ){
					$list[] = $ingredient['name'];
				}
				$ingredientsArray[$dishe->id] = $list;
				$list = null;
			}
			
			
		}
		return $this->render('list', [
			'model' => $model,
			'dishes' => $dishes,
			'ingredientsArray' => $ingredientsArray
		]);
	}
	
	public function actionNewdish(){
		if( Yii::$app->request->isPost ){
			$name = htmlspecialchars(trim(Yii::$app->request->post()['name']));
			$active = Yii::$app->request->post()['active'] === 'true' ? 1 : 0;
			$ingredients = Yii::$app->request->post()['ingredients'];
			$modelDish = new Dishes();
			
			
			
			$modelDish->name = $name;
			$modelDish->active = $active;
			$modelDish->save();
			$idNewDish = Dishes::find()->select('id')->where([ 'name' => $name ])->one();
			
			foreach( $ingredients as $ingredient ){
				$modelChain = new Chain();
				$modelChain->id_dishes = $idNewDish->id;
				$modelChain->id_ingregient = intval($ingredient);
				$modelChain->save();
			}
			
			Yii::$app->getResponse()->redirect('adddish');
		}
		
	}
	
	//SELECT `dishes`.`name`, `dishes`.`active`, `ingredients`.`name`, `ingredients`.`active` as `act_ing` as `act_dishe` FROM `chain` JOIN `dishes` ON `dishes`.`id` = `chain`.`id_dishes` JOIN `ingredients` ON `ingredients`.`id` = `chain`.`id_ingredient` 
	//SELECT `dishes`.`name`, `dishes`.`active` as `act_dishe`, `ingredients`.`name`, `ingredients`.`active` as `act_ing`  FROM `chain` JOIN `dishes` ON `dishes`.`id` = `chain`.`id_dishes` JOIN `ingredients` ON `ingredients`.`id` = `chain`.`id_ingregient`  WHERE `dishes`.`id` = 4
	public function actionShowdishe(){
		$idDish = intval(Yii::$app->request->get()['id']);
		$model = Dishes::find()->where(['id' => $idDish])->one();
		$query = new \yii\db\Query;
		$query->select('*')
            ->from('`chain`')
            ->leftJoin('`dishes`', '`dishes`.`id` = `chain`.`id_dishes`')
			->leftJoin('`ingredients`', '`ingredients`.`id` = `chain`.`id_ingregient`')
			->where(['`dishes`.`id`' => $idDish]);
            //->limit($Limit);
		$command = $query->createCommand();
		$ingredients = $command->queryAll();
		var_dump($ingredients);
		return $this->render('showdishe', [
			'model' => $model,
			'ingredients' => $ingredients
		]);
	}
	public function actionChangeitem(){
		if(  Yii::$app->request->isGet ){
			$idDishes = intval(Yii::$app->request->get()['id']);
			$model = Dishes::find()->where([ 'id' => $idDishes ])->one();
			$state = Yii::$app->request->get()['state'] == 'true' ? true : false;
			$name = htmlspecialchars(trim(Yii::$app->request->get()['name']));
			if( Yii::$app->request->get()['act'] == 'upd' ){
				$model->active = $state;
				$model->name = $name;
				if( $model->save() ){
					$data = (object) array('message' => 'ok', 'action' => 'upd');
				}else{
					$data = (object) array('message' => 'cannot update. error');
				}
				echo json_encode($data);
			}else if( Yii::$app->request->get()['act'] == 'del' ){
				if( $model->delete() ){
					$data = (object) array('message' => 'ok', 'action' => 'del');
				}else{
					$data = (object) array('message' => 'cannot delete. error');
				}
				echo json_encode($data);
			}
			
		}
	}


    
}
