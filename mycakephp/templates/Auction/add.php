<h2>商品を出品する</h2>
<?= $this->Form->create($biditem,['type'=>'file']) ?>
<fieldset>
	<legend>※下記項目を入力・商品画像を登録：</legend>
	<?php
		echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
		echo '<p><strong>ユーザー名: ' . $authuser['username'] . '</strong></p>';
		echo $this->Form->control('name',['label'=>'商品名']);
		echo $this->Form->hidden('finished',['value' => 0]);
		echo $this->Form->control('endtime',['label'=>'終了日時']);
		//説明記入欄
		echo $this->Form->control('description',
		['label'=>'商品説明 (500文字以内で入力)','rows'=>5,'maxlengh'=>500]);
		//画像アップロード欄
		echo $this->Form->control('image',['type'=>'file','label'=>'商品画像（アップロード可能サイズ2MB以下）']);
	?>
</fieldset>
<?= $this->Form->button(__('出品する')) ?>
<?= $this->Form->end() ?>