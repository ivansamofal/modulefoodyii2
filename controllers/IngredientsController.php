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


class IngredientsController extends Controller
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
	
	public function actionAddfood(){
		
		$idIngredient = intval(htmlspecialchars(trim(Yii::$app->request->get()['id'])));
		if( Yii::$app->request->post("Ingredients") ){
			$model = new Ingredients();
			$model->name = htmlspecialchars(trim(Yii::$app->request->post("Ingredients")['name']));
			$model->active = htmlspecialchars(trim(Yii::$app->request->post("Ingredients")['active']));
			
			//var_dump( $model->load( \Yii::$app->request->post("Ingredients") );die;
			if(  $model->save() ){

			}
		}else{
			$model = Ingredients::find()->where([ 'id' => $idIngredient])->one();
		}
		
		return $this->render('addfood', [
			'model' => $model
		]);
	}
	
	public function actionIlist(){
		
		$ingredients = Ingredients::find()->all();
		if( Yii::$app->request->post()['food'] ){
			
		}else{
			
		}
		
		return $this->render('ilist', [
			'model' => $model,
			'ingredients' => $ingredients
		]);
	}
	public function actionChangeitem(){
		if(  Yii::$app->request->isGet ){
			$idIngredient = intval(Yii::$app->request->get()['id']);
			$model = Ingredients::find()->where([ 'id' => $idIngredient ])->one();
			$state = Yii::$app->request->get()['state'] === true ? true : false;
			$name = htmlspecialchars(trim(Yii::$app->request->get()['name']));
			var_dump($state);
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
	
	public function actionOnedish(){
		
		$dishesList = Dishes::find()->all();
		if( Yii::$app->request->post()['food'] ){
			
		}else{
			
		}
		
		return $this->render('disheslist', [
			
			'ingredients' => $ingredients
		]);
	}
	
	public function actionDisheslist(){
		
		$dishesList = Dishes::find()->all();
		if( Yii::$app->request->post()['food'] ){
			
		}else{
			
		}
		
		return $this->render('disheslist', [
			
			'ingredients' => $ingredients
		]);
	}

	public function actionFood(){
		$posts = Posts::find()->all();
		
		return $this->render('posts', [
			'posts' => $posts
		]);
	}
    
}
