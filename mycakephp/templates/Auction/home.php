<h2><?=$authuser['username'] ?> さんのマイページ</h2>
<h3>※落札情報</h3>
<table cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th scope="col"><?= $this->Paginator->sort('商品ID') ?></th>
		<th class="main" scope="col"><?= $this->Paginator->sort('商品名') ?></th>
		<th scope="col"><?= $this->Paginator->sort('落札日時') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
</thead>
<tbody>
	<?php foreach ($bidinfo as $info): ?>
	<tr>
		<td><?= h($info->id) ?></td>
		<td><?= h($info->biditem->name) ?></td>
		<td><?= h($info->created) ?></td>
		<td class="actions">
			<?= $this->Html->link(__('メッセージ'), ['action' => 'msg', $info->id]) ?>
		</td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>

<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->first('<< ' . __('最初へ')) ?>
		<?= $this->Paginator->prev('< ' . __('前へ')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('次へ') . ' >') ?>
		<?= $this->Paginator->last(__('最後へ') . ' >>') ?>
	</ul>
</div>
<h6><?= $this->Html->link(__('出品情報へ>>'), ['action' => 'home2']) ?></h6>