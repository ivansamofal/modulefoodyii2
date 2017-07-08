<? 
use app\modules\models\Dishes;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$script = <<< JS

	function deleteItem( id ){
		$.ajax({
			url: "deleteItem?idgredient",
			type: "POST",
			data: {id: id},
			cache: false,
			dataType: "json",
			processData: false, 
			contentType: false, 
			success: function( respond, textStatus, jqXHR ){
				
				if( typeof respond.error === "undefined" ){
					
					console.log( respond );
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
	}
	
JS;
$this->registerJs($script);
?>

	<? Pjax::begin();?>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'form-list-ingredients']); ?>
	<?foreach( $dishes as $dishe ):?>
	<? $checkbox =  $form->field($dishe, 'active')->checkbox([ 'label' => 'Активный ингредиент', 'labelOptions' => [ 'style' => 'padding-left: 20px;' ], 'checked ' => ( $dishe->active ? true : false ) ]) ?>
	<? $inputName = $form->field($dishe, 'name')->textInput(['value' => $dishe->name])?>
		<? $td2 = Html::tag('td', $checkbox)?>
		<? $updateButton = Html::submitButton(Yii::t('app', 'Обновить'), ['class' => "btn btn-warning", 'onClick' => "changeItem($dishe->id, 'upd'); return false;"]) ?>
		<? $deleteButton = Html::submitButton(Yii::t('app', 'Удалить'), ['class' => "btn btn-danger", 'onClick' => "changeItem($dishe->id, 'del'); return false;"]) ?>
		<? $td1 = Html::tag('td', $inputName );?>
		<? $td3 = Html::tag('td', $updateButton );?>
		<? $td4 = Html::tag('td', $deleteButton );?>
		<? $tr .= Html::tag('tr', $td1 . $td2 . $td3 . $td4, [ 'class' => "oneIngredient tr-$dishe->id"] );?>
	<?endforeach;?>
	
	<? $td1 = Html::tag('td', 'Название' );?>
	<? $td2 = Html::tag('td', 'Активность' );?>
	<? $td3 = Html::tag('td', '' );?>
	<? $td4 = Html::tag('td', '' );?>
	<? $trHeader = Html::tag('tr', $td1 . $td2 . $td3 . $td4 );?>
	
	<?=Html::tag('table', $trHeader . $tr, [ 'class' => 'list-ingredients' ]);?>
	<?php ActiveForm::end(); ?>
	<? Pjax::end();?>
	
	
	
<script>
	function changeItem( id, action ){
		if( action === 'upd' ){
			var state = $( '.tr-' + id + ' input[type="checkbox"]' ).prop('checked');
			var name = $( '.tr-' + id + ' input[type="text"]' ).val();
			var url = "changeitem?act=" + action + "&id=" + id + "&state=" + state + "&name=" + name;
		}else{
			var url = "changeitem?act=" + action + "&id=" + id;
		}
		$.ajax({
			url: url,
			type: "GET",
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
	}
</script>