<? 
use app\modules\models\Ingredients;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new Ingredients;
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'food', 'class' => 'add-food'], 'id' => 'food-form']); ?>

    <?= $form->field($model, 'name')->textInput(/*['value' => $foodInfo->name]*/) ?>
    <?= $form->field($model, 'active')->checkbox([ 'label' => 'Активный ингредиент', 'labelOptions' => [ 'style' => 'padding-left: 20px;' ], 'checked ' => true ]) ?>
	<? $submitButton = Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
   <?= Html::tag('div', $submitButton, ['class' => 'form-group']) ?> 

<?php ActiveForm::end(); ?>
