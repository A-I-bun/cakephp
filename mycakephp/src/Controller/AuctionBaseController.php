<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\EventInterface;

class AuctionBaseController extends AppController {

	public function initialize() :void{
		parent::initialize();
	
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Auth', [
			'authorize' => ['Controller'],
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'username',
						'password' => 'password'
					]
				]
			],
			'loginRedirect' => [
				'controller' => 'Users',
				'action' => 'login'
			],
			'logoutRedirect' => [
				'controller' => 'Auction', //User
				'action' => 'index',
			],
			'authError' => 'ログインして',
		]);
	}

	function login() {
		if($this->request->is('post')) {
			$user = $this->Auth->identify();
			// Authのidentifyをユーザーに設定
			if(!empty($user)){
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('ユーザー名かパスワードが間違っています。');
		}
	}
	

	// ログアウト処理
	public function logout() {
		$this->request->getSession()->destroy();
		$this->Flash->success('完了');
		return $this->redirect($this->Auth->logout());
	}

	// 認証をしないページの設定
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		$this->Auth->allow([]);
	}
	
	// 認証時のロールの処理
	public function isAuthorized($user = null){
		if($user['role'] === 'admin'){
		   return true;
		}
		// 一般ユーザーはAuctionControllerのみtrue、他はfalse
		if($user['role'] === 'user'){
			if ($this->name == 'Auction'){
				return true;
			} else {
				return false;
			}
		}
		// その他はすべてfalse
		return false;
	}
}
