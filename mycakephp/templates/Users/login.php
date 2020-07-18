<div class="users form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
  <fieldset>
    <legend>アカウント名とパスワードを入力して下さい</legend>
    <?= $this->Form->control('username',['label'=>'ユーザー名']) ?>
		<?= $this->Form->control('password',['label'=>'パスワード']) ?>
  </fieldset>
    <?= $this->Form->button(__('ログイン')); ?>
    <?= $this->Form->end() ?>

</div>