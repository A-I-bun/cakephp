<h2>「<?=$biditem->name ?>」の情報</h2>
<table class="vertical-table">
<tr>
	<th class="small" scope="row">出品者</th>
	<td><?= $biditem->has('user') ? $biditem->user->username : '' ?></td>
</tr>
<tr>
	<th scope="row">商品名</th>
	<td><?= h($biditem->name) ?></td>
</tr>
<!-- 追加　画像欄 -->
<tr>
	<th scope="row">商品画像</th>
	<td><?= $this->Html->image(h($biditem->image), ['alt' => h($biditem->name).'の写真','width'=>200,'height'=>200]) ?></td>
</tr>
<!-- 追加　説明欄 -->
<tr>
	<th scope="row">商品説明</th>
	<td><?= h($biditem->description) ?></td>
</tr>
<tr>
	<th scope="row">商品ID</th>
	<td><?= $this->Number->format($biditem->id) ?></td>
</tr>
<tr>
	<th scope="row">終了時間</th>
	<td><?= h($biditem->endtime)?>&emsp;
	<span id ="timer"></span>	
<!-- 追加タイマー	 -->
<script>
var endDate = new Date('<?php echo h($biditem->endtime); ?>');
function countdownTimer(){
  var nowDate = new Date();
  var period = endDate - nowDate ;
  var addZero = function(n){return('0'+n).slice(-2);} //0+引数して右から2桁取得
  var addZeroDay = function(n){return('0'+n).slice(-3);}
  if(period >= 0) {
  var day = Math.floor(period / (1000 * 60 * 60 * 24)); //1日
  period -=  (day　*(1000 * 60 * 60 * 24));
  var hour = Math.floor(period / (1000 * 60 * 60));
  period -= (hour *(1000 * 60 * 60));
  var minutes =  Math.floor(period / (1000 * 60));
  period -= (minutes * (1000 * 60));
  var second = Math.floor(period / 1000);

  var insert ='終了まであと'+ "";
  insert += '<span class="h">' + addZeroDay(day) +'日' + '</span>';
  insert += '<span class="h">' + addZero(hour) + '時間'+'</span>';
  insert +=  '<span class="m">' + addZero(minutes) +'分' + '</span>';
  insert += '<span class="s">' + addZero(second)+ '秒'+ '</span>';
	document.getElementById('timer').innerHTML = insert; //要素を.innerHTMLでinsertの内容に挿入？
	document.getElementById("timer").style.color = "red";
  setTimeout(countdownTimer,100); //1000ミリ秒単位　指定された時間が経過したところで一回だけ第一引数の処理？
  }
  else{
		var insert ='終了しました';
		document.getElementById('timer').innerHTML = insert;
		document.getElementById("timer").style.color = "red";
  }
}
countdownTimer();
</script>
<!-- 追加タイマー終了 -->
</td>
</tr>
<tr>
	<th scope="row">投稿時間</th>
	<td><?= h($biditem->created) ?></td>
</tr>
<tr>
	<th scope="row"><?= __('受付状況') ?></th>
	<td><?= $biditem->finished ? __('終了') : __('入札受付中'); ?></td>
</tr>
</table>
<div class="related">
	<h4><?= __('落札情報') ?></h4>
	<?php if (!empty($bidinfo)): ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th scope="col">落札者</th>
		<th scope="col">落札金額</th>
		<th scope="col">落札日時</th>
	</tr>
	<tr>
		<td><?= h($biditem->bidinfo->user->username) ?></td>
		<td><?= h($biditem->bidinfo->price) ?>円</td>
		<td><?= h($biditem->endtime) ?></td>
	</tr>
	</table>
	<?php else: ?>
	<p><?='なし' ?></p>
	<?php endif; ?>
</div>
<div class="related">
	<h4><?= __('入札情報') ?></h4>
	<?php if (!$biditem->finished): ?>
	<h6><a href="<?=$this->Url->build(['action'=>'bid', $biditem->id]) ?>">《入札する！》</a></h6>
	<?php if (!empty($bidrequests)): ?>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th scope="col">入札者</th>
		<th scope="col">金額</th>
		<th scope="col">入札日時</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bidrequests as $bidrequest): ?>
	<tr>
		<td><?= h($bidrequest->user->username) ?></td>
		<td><?= h($bidrequest->price) ?>円</td>
		<td><?= h($bidrequest->created) ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php else: ?>
	<p><?='なし' ?></p>
	<?php endif; ?>
	<?php else: ?>
	<p><?='※入札は、終了しました。' ?></p>
	<?php endif; ?>
</div>
