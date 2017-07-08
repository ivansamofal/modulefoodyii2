<? 
use app\modules\models\Dishes;
use app\modules\models\Ingredients;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$model = new Ingredients;
?>


	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'form-list-ingredients']); ?>
	<?foreach( $dishes as $dishe ):?>
	
		<? $inputName = $form->field($dishe, 'name')->textInput(['value' => $dishe->name])?>
			<?foreach( $ingredientsArray as $key => $ingredient):
				if( $dishe->id == $key ):
					foreach( $ingredient as $key => $item):
						if( $key < count($ingredient) - 1 ){
							$list .= $item . ', ';
						}else{
							$list .= $item;
						}
					endforeach;
				endif;
			endforeach;?>
			
			<? $td2 = Html::tag('td', $list)?>
			<? $td1 = Html::tag('td', $inputName );?>
			
			<? $tr .= Html::tag('tr', $td1 . $td2 . $td3 . $td4, [ 'class' => "oneIngredient tr-$dishe->id"] );?>
		<?	$list = null;?>
	<?endforeach;?>
	<? $td1 = Html::tag('td', 'Название блюда' );?>
	<? $td2 = Html::tag('td', 'Ингредиенты' );?>
	<? $td3 = Html::tag('td', '' );?>
	<? $td4 = Html::tag('td', '' );?>
	<? $trHeader = Html::tag('tr', $td1 . $td2 . $td3 . $td4 );?>
	
	<?=Html::tag('table', $trHeader . $tr, [ 'class' => 'list-ingredients' ]);?>
	<?php ActiveForm::end(); ?>

	
	
	
