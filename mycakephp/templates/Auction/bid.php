<h2>「<?=$biditem->name ?> 」の情報</h2>
<?= $this->Form->create($bidrequest) ?>
<fieldset>
	<legend><?= __('※入札を行う') ?></legend>
	<?php
		echo $this->Form->hidden('biditem_id', ['value' => $bidrequest->biditems_id]);
		echo $this->Form->hidden('user_id', ['value' => $bidrequest->user_id]);
		echo $this->Form->control('price',['label'=>'金額']);
	?>
</fieldset>
<?= $this->Form->button(__('送信')) ?>
<?= $this->Form->end() ?>
