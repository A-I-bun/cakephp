<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\EventInterface;
use Exception;
//追加
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class AuctionController extends AuctionBaseController
{
	// デフォルトテーブルを使わない
	public $useTable = false;

	// 初期化処理
	public function initialize() :void {
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadModel('Users');
		$this->loadModel('Biditems');
		$this->loadModel('Bidrequests');
		$this->loadModel('Bidinfo');
		$this->loadModel('Bidmessages');
		// ログインしているユーザー情報をauthuserに設定
		$this->set('authuser', $this->Auth->user());
		// レイアウトをauctionに変更
		$this->viewBuilder()->setLayout('auction');
	}

	// トップページ
	public function index() {
		// ページネーションでBiditemsを取得
		$auction = $this->paginate('Biditems', [
			'order' =>['endtime'=>'desc'], 
			'limit' => 10]);
		$this->set(compact('auction'));
	}

	// 商品情報の表示
	public function view($id = null) {
		// $idのBiditemを取得
		$biditem = $this->Biditems->get($id, [
			'contain' => ['Users', 'Bidinfo', 'Bidinfo.Users']
		]);

		// オークション終了時の処理
		if (($biditem->endtime < new \DateTime('now')) && $biditem->finished == 0) {
			$biditem->finished = 1;
			$this->Biditems->save($biditem);
			// Bidinfoを作成する
			$bidinfo = $this->Bidinfo->newEmptyEntity();
			// Bidinfoのbiditem_idに$idを設定
			$bidinfo->biditem_id = $id;
			// 最高金額のBidrequestを検索
			$bidrequest = $this->Bidrequests->find('all', [
				'conditions'=>['biditem_id'=>$id], 
				'contain' => ['Users'],
				'order'=>['price'=>'desc']])->first();

			// Bidrequestが得られた時の処理
			if (!empty($bidrequest)){
				// Bidinfoの各種プロパティを設定して保存する
				$bidinfo->user_id = $bidrequest->user->id;
				$bidinfo->user = $bidrequest->user;
				$bidinfo->price = $bidrequest->price;
				$this->Bidinfo->save($bidinfo);
			}
			// Biditemのbidinfoに$bidinfoを設定
			$biditem->bidinfo = $bidinfo;		
		}
		// Bidrequestsからbiditem_idが$idのものを取得
		$bidrequests = $this->Bidrequests->find('all', [
			'conditions'=>['biditem_id'=>$id], 
			'contain' => ['Users'],
			'order'=>['price'=>'desc']])->toArray();
		// オブジェクト類をテンプレート用に設定
		$this->set(compact('biditem', 'bidrequests'));
	}


	// 出品する処理 ★追加　画像登録
	public function add($biditem = null) {
		$biditem = $this->Biditems->newEmptyEntity();
		// debug($biditem);
		if ($this->request->is('post')) {
			//出品情報を取得
			$data=$this->request->getData();
			debug($data);
			// return;
			//商品画像情報を取得
			$img=$this->request->getData('image');
			$mime=$data['image']->getClientMediaType();
			$size=$data['image']->getSize();

			//商品画像のタイトル取得＆現在日時時刻をタイトルの頭に付与した情報を出品情報の画像情報に代入
			$data['image']= date('YmdHis').$data['image']->getClientFilename();
			$ext=pathinfo($data['image'],PATHINFO_EXTENSION);

			//全部取得したうえで、MIMEと拡張子ともに下記配列の値にあてはまるか確認
			$mimeCheck=['image/gif','image/png','image/jpeg'];
			$extCheck=['gif','png','jpg','jpeg'];

			if(!in_array((strtolower($mime)),$mimeCheck) && !in_array((strtolower($ext)),$extCheck)) {
				$this->Flash->error(__('「gif」「png」「jpeg」「jpg」いずれかの画像ファイルを登録してください'));
				return;
				}	elseif($size > 2000000) {
				$this->Flash->error(__('アップロードするファイルのサイズは2MB以下にしてください'));
				return;
			}
			
			$biditem = $this->Biditems->patchEntity($biditem,$data);
			debug($biditem); 
			return;
			if ($this->Biditems->save($biditem)) {
				//アップロードする商品画像の保存先指定
				$imgpath=realpath(WWW_ROOT.'/img/').'/'.$data['image'];
				//ファイルアップロードする,/vendor/laminas/laminas-diactoros/src/UploadedFile.php
				$img->moveTo($imgpath);
	
				$this->Flash->success(__('保存しました。'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
		}
		$this->set(compact('biditem'));
	}


	// 入札の処理
	public function bid($biditem_id = null) {
		$bidrequest = $this->Bidrequests->newEmptyEntity();
		// $bidrequestにbiditem_idとuser_idを設定
		$bidrequest->biditem_id = $biditem_id;
		$bidrequest->user_id = $this->Auth->user('id');
	
		if ($this->request->is('post')) {
			// $bidrequestに送信フォームの内容を反映する
			$bidrequest = $this->Bidrequests->patchEntity($bidrequest, $this->request->getData());

			if ($this->Bidrequests->save($bidrequest)) {
				$this->Flash->success(__('入札を送信しました。'));
				return $this->redirect(['action'=>'view', $biditem_id]);
			}
			$this->Flash->error(__('入札に失敗しました。もう一度入力下さい。'));
		}
		// $biditem_idの$biditemを取得する
		$biditem = $this->Biditems->get($biditem_id);
		$this->set(compact('bidrequest', 'biditem'));
	}
	
	// 落札者とのメッセージ
	public function msg($bidinfo_id = null)
	{
		// Bidmessageを新たに用意
		$bidmsg = $this->Bidmessages->newEmptyEntity();
		// POST送信時の処理
		if ($this->request->is('post')) {
			// 送信されたフォームで$bidmsgを更新
			$bidmsg = $this->Bidmessages->patchEntity($bidmsg, $this->request->getData());
			// Bidmessageを保存
			if ($this->Bidmessages->save($bidmsg)) {
				$this->Flash->success(__('保存しました。'));
			} else {
				$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
			}
		}
		try { // $bidinfo_idからBidinfoを取得する
			$bidinfo = $this->Bidinfo->get($bidinfo_id, ['contain'=>['Biditems']]);
		} catch(Exception $e){
			$bidinfo = null;
		}
		// Bidmessageをbidinfo_idとuser_idで検索
		$bidmsgs = $this->Bidmessages->find('all',[
			'conditions'=>['bidinfo_id'=>$bidinfo_id],
			'contain' => ['Users'],
			'order'=>['created'=>'desc']]);
		$this->set(compact('bidmsgs', 'bidinfo', 'bidmsg'));
	}

	// 落札情報の表示
	public function home() {
		// 自分が落札したBidinfoをページネーションで取得
		$bidinfo = $this->paginate('Bidinfo', [
			'conditions'=>['Bidinfo.user_id'=>$this->Auth->user('id')], 
			'contain' => ['Users', 'Biditems'],
			'order'=>['created'=>'desc'],
			'limit' => 10])->toArray();
		$this->set(compact('bidinfo'));
	}

	// 出品情報の表示
	public function home2() {
		$biditems = $this->paginate('Biditems', [
			'conditions'=>['Biditems.user_id'=>$this->Auth->user('id')], 
			'contain' => ['Users', 'Bidinfo'],
			'order'=>['created'=>'desc'],
			'limit' => 10])->toArray();
		$this->set(compact('biditems'));
	}
}
