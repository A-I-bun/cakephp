/src/Controller/AuctionController.php (line 85)
object(App\Model\Entity\Biditem) {

	'[new]' => true,
	'[accessible]' => [
		'user_id' => true,
		'name' => true,
		'finished' => true,
		'endtime' => true,
		'created' => true,
		'image' => true,
		'description' => true,
		'user' => true,
		'bidinfo' => true,
		'bidrequests' => true
	],
	'[dirty]' => [],
	'[original]' => [],
	'[virtual]' => [],
	'[hasErrors]' => false,
	'[errors]' => [],
	'[invalid]' => [],
	'[repository]' => 'Biditems'

}
/src/Controller/AuctionController.php (line 113)
[
	'user_id' => '11',
	'name' => 'j9',
	'finished' => '0',
	'endtime' => '2020-05-28T23:32:00',
	'description' => 'i',
	'image' => '2020052816084946_1080_1920.png'
]
/src/Controller/AuctionController.php (line 117)
object(App\Model\Entity\Biditem) {

	'user_id' => (int) 11,
	'name' => 'j9',
	'finished' => false,
	'endtime' => object(Cake\I18n\FrozenTime) {

		'time' => '2020-05-28 23:32:00.000000+09:00',
		'timezone' => 'Asia/Tokyo',
		'fixedNowTime' => false
	
	},
	'description' => 'i',
	'image' => '2020052816084946_1080_1920.png',
	'created' => object(Cake\I18n\FrozenTime) {

		'time' => '2020-05-28 16:08:49.725825+09:00',
		'timezone' => 'Asia/Tokyo',
		'fixedNowTime' => false
	
	},
	'id' => (int) 86,
	'[new]' => false,
	'[accessible]' => [
		'user_id' => true,
		'name' => true,
		'finished' => true,
		'endtime' => true,
		'created' => true,
		'image' => true,
		'description' => true,
		'user' => true,
		'bidinfo' => true,
		'bidrequests' => true
	],
	'[dirty]' => [],
	'[original]' => [],
	'[virtual]' => [],
	'[hasErrors]' => false,
	'[errors]' => [],
	'[invalid]' => [],
	'[repository]' => 'Biditems'

}// var xmlhttp = new XMLHttpRequest();


// console.log(endtime);
// console.log(nowtime);

var endtime = new Date('<?php echo h($biditem->endtime); ?>');
var nowtime = new Date();
function countdownTimer(){
  var period = endtime - nowtime ;
  var addZero = function(n){return('0'+n).slice(-2);} //0+引数して右から2桁取得
  var addZeroDay = function(n){return('0'+n).slice(-3);}
console.log(period);
  if(period >= 0) {
  var day = Math.floor(period / (1000 * 60 * 60 * 24)); //1日
  period -=  (day　*(1000 * 60 * 60 * 24));
  var hour = Math.floor(period / (1000 * 60 * 60));
  period -= (hour *(1000 * 60 * 60));
  var minutes =  Math.floor(period / (1000 * 60));
  period -= (minutes * (1000 * 60));
  var second = Math.floor(period / 1000);

  var insert = '終了まであと'+ "";
  insert += '<span class="h">' + addZeroDay(day) +'日' + '</span>';
  insert += '<span class="h">' + addZero(hour) + '時間'+'</span>';
  insert +=  '<span class="m">' + addZero(minutes) +'分' + '</span>';
  insert += '<span class="s">' + addZero(second)+ '秒'+ '</span>';
  document.getElementById('timer').innerHTML = insert; //要素を.innerHTMLでinsertの内容に挿入？
	document.getElementById("timer").style.color = "red";
  setTimeout(countdownTimer,10); //1000ミリ秒単位　指定された時間が経過したところで一回だけ第一引数の処理？
  }
  else{
  var insert ='終了しました';
    document.getElementById('timer').innerHTML = insert;
	  document.getElementById("timer").style.color = "red";
  }
}

countdownTimer();