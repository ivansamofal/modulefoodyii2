<? 
use app\modules\models\Dishes;
use app\modules\models\Ingredients;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new Dishes;

?>

 <?= Html::tag('h1', 'Добавить новое блюдо:') ?> 
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'food', 'class' => 'add-food'], 'id' => 'food-form']); ?>

    <?= $form->field($model, 'name')->textInput(['value' => $model->name, 'placeholder' => 'Введите название блюда']) ?>
    <?= $form->field($model, 'active')->checkbox([ 'label' => 'Активное блюдо', 'labelOptions' => [ 'style' => 'padding-left: 20px;' ], 'checked ' => true ]) ?>
	
	<?= Html::tag('h2', 'Выберите список ингредиентов для нового блюда:');?>
	<?foreach( $ingredients as $ingredient ):?>
		<?= $form->field($ingredient, 'name')->checkbox([ 'label' => $ingredient->name, 'labelOptions' => [ 'style' => 'padding-left: 20px;', 'class' => "label-ingredient"], 'data-id' => $ingredient->id
			 ]) ?>
	<?endforeach;?>
	
	<? $submitButton = Html::submitButton('Submit', ['class' => 'btn btn-success submit-dishe']) ?>
   <?= Html::tag('div', $submitButton, ['class' => 'form-group']) ?> 

<?php ActiveForm::end(); ?>










<script>
//$( document ).ready(function() {
	$('.submit-dishe').on('click', function(){
		var arrIngredients = [];
		$('.label-ingredient input').each(
			function(index, item ){
				if( $(item).prop('checked') ){
					arrIngredients.push($(item).attr('data-id'));
				}
			});
		var dishesName = $('#dishes-name').val();
		var dishesActive = $('#dishes-active').prop('checked');
		console.log(dishesActive);
		var data = {
			name: dishesName,
			active: dishesActive,
			ingredients: arrIngredients
		};
		console.log(data);
		$.ajax({
			url: 'newdish',
			type: "POST",
			data: data ,
			success: function( respond, textStatus, jqXHR ){
				var data = JSON.parse( respond );
					if( data.message === 'ok' && data.action === 'del' ){
						$( '.tr-' + id ).remove();
					}else if( data.message === 'ok' && data.action === 'upd' ){
						$( '.tr-' + id + ' input[type="checkbox"]').prop('checked', state);
					}
				else{
					console.log("ОШИБКИ ОТВЕТА сервера: " + respond.error );
				}
			},
			error: function( jqXHR, textStatus, errorThrown ){
				console.log("ОШИБКИ AJAX запроса: " + textStatus );
			}
		});
		
		return false;
	});
	
//});
</script>