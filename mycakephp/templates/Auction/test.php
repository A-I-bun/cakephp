<?php
//ファイル情報取得
$ext=pathinfo($_FILES['image']['name']);
$perm=['gif','jpg','jpeg','png'];


public function add() {
  $biditem = $this->Biditems->newEmptyEntity();

  if ($this->request->is('post')) {
    //出品情報を取得
    $biditemdata=$this->request->getData();
    //商品画像情報を取得
    $img=$this->request->getData('image');

    //画像判定
    $biditemdata['image']

    //商品画像のタイトル取得＆現在日時時刻をタイトルの頭に付与した情報を出品情報の画像情報に代入
    $biditemdata['image']= date('YmdHis').$biditemdata['image']->getClientFilename();

    //アップロードする商品画像の保存先指定
    $imgpath=realpath(WWW_ROOT.'/img/').'/'.$biditemdata['image'];

    $biditem = $this->Biditems->patchEntity($biditem,$biditemdata);
    
    // $biditemを保存する
    if ($this->Biditems->save($biditem)) {
      //ファイルアップロードする,/vendor/laminas/laminas-diactoros/src/UploadedFile.php
      $img->moveTo($imgpath);

      $this->Flash->success(__('保存しました。'));
      return $this->redirect(['action' => 'index']);
    }
    $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
  }
  $this->set(compact('biditem'));
}
