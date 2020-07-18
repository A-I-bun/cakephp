<h2><?=$authuser['username'] ?>さんのマイページ</h2>
<h3>※出品情報</h3>
<table cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th scope="col"><?= $this->Paginator->sort('商品ID') ?></th>
		<th class="main" scope="col"><?= $this->Paginator->sort('商品名') ?></th>
		<th scope="col"><?= $this->Paginator->sort('出品日時') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
</thead>
<tbody>
	<?php foreach ($biditems as $biditem): ?>
	<tr>
		<td><?= h($biditem->id) ?></td>
		<td><?= h($biditem->name) ?></td>
		<td><?= h($biditem->created) ?></td>
		<td class="actions">
			<?php if (!empty($biditem->bidinfo)): ?>
			<?= $this->Html->link(__('メッセージ'), ['action' => 'msg', $biditem->bidinfo->id]) ?>
			<?php endif; ?>
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
<h6><?= $this->Html->link(__('<<落札情報へ'), ['action' => 'home']) ?></h6>