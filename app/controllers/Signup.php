<?php

namespace controllers;

use libraries\Controller;
use models\_User;

class Signup extends Controller {

	private $u;

	function __construct() {
		$this->u = new _User();
	}

	public function index() {

		$data = [];

		if ($this->RMisPost()) {
			$this->sanitizeInputPost();
			
			// Temp info collector
			if (isset($_POST['email'])) {
				$data = $this->u->setTmp($_POST);
				if ($data['status'] == 0) {
					$VCode = $this->u->createVCode();
					$this->u->emailVCode($VCode);
				}
			}

			// Verify email
			if (isset($_POST['vcode'])) {
				$data = $this->u->verifyEmail($_POST['vcode']);

				if ($data['status'] == 0) {

					$auth = $this->u->login($_SESSION['tmp_em'], $_SESSION['tmp_pw']);

					if (isset($auth['data']->id)) {
						$_SESSION['u'] = $auth['data'];
					}

					$data = $auth;
					
					// Clear temp data
					unset($_SESSION['tmp_fn']);
					unset($_SESSION['tmp_ln']);
					unset($_SESSION['tmp_em']);
					unset($_SESSION['tmp_pw']);
					unset($_SESSION['tmp_c']);
					unset($_SESSION['atmp']);
					unset($_SESSION['vcode']);
				}
			}
		}

		$this->return($data);
	}

	public function resend() {
		$this->u->emailVCode($_SESSION['vcode']);
		$this->return(['status' => 0]);
	}

	public function clearTmp() {
		unset($_SESSION['tmp_fn']);
		unset($_SESSION['tmp_ln']);
		unset($_SESSION['tmp_em']);
		unset($_SESSION['tmp_pw']);
		unset($_SESSION['tmp_c']);
		unset($_SESSION['atmp']);
		unset($_SESSION['vcode']);

		$this->return(['status' => 0]);
	}

}

?>