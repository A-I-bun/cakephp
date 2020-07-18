<h2>ミニオークション!</h2>
<h3>※出品されている商品</h3>
<table cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th class="main" scope="col"><?= $this->Paginator->sort('商品名') ?></th>
		<th scope="col"><?= $this->Paginator->sort('入札状況') ?></th>
		<th scope="col"><?= $this->Paginator->sort('終了日時') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
</thead>
<tbody>
	<?php foreach ($auction as $biditem): ?>
	<tr>
		<td><?= h($biditem->name) ?></td>
		<?php if ($biditem->finished=1):?>
		<td>終了</td>
		<?php else: ?>
		<td>受付中</td>
		<?php endif; ?>
		<td><?= h($biditem->endtime) ?></td>
		<td class="actions">
			<?= $this->Html->link(__('詳細を見る'), ['action' => 'view', $biditem->id]) ?>
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