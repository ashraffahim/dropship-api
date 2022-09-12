<?php

namespace models;

use libraries\Database;

class _User {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function exist($e) {
		$this->db->query('SELECT `id` FROM `buyer` WHERE `b_email` = :e');
		$this->db->bind(':e', $e, $this->db->PARAM_STR);
		
		$data = $this->db->single();

		if (isset($data->id)) {
			return [
				'status' => 0,
				'data' => $data
			];
		}
		return ['status' => 1];
	}

	public function setTmp($d) {
		if ($this->exist($d['email'])['status'] == 0) {
			return [
				'status' => 1
			];
		}

		if (isset($_SESSION['tmp_em'])) {
			return [
				'status' => 2
			];
		}

		$_SESSION['tmp_fn'] = $d['first_name'];
		$_SESSION['tmp_ln'] = $d['last_name'];
		$_SESSION['tmp_em'] = $d['email'];
		$_SESSION['tmp_pw'] = $d['password'];
		$_SESSION['tmp_c'] = $d['country'];

		return [
			'status' => 0
		];
	}

	public function createVCode() {
		$_SESSION['vcode'] = rand(100000, 999999);
		$_SESSION['atmp'] = 0;
	}

	public function emailVCode() {
		$email = new \libraries\Email();
		$email->send($_SESSION['tmp_em'], 'Confrim Signup', "<h3>{$_SESSION['vcode']}</h3>", '');
	}

	public function verifyEmail($v) {
		
		$_SESSION['atmp']++;

		if ($v == $_SESSION['vcode']) {
		
			return $this->createUser();
		
		} else {

			// Check attempt

			if ($_SESSION['atmp'] > 4) {

				// Attempts exceeded

				$this->createVCode();
				$this->emailVCode();

				return [
					'status' => 1
				];
			}

			// Failed attempt
			return [
				'status' => 2
			];
		}
	}

	public function createUser() {
		$this->db->query('
		INSERT INTO 
			`buyer` 
			(
				`b_first_name`, 
				`b_last_name`, 
				`b_email`,
				`b_password`,
				`b_country`,
				`b_timestamp`,
				`b_latimestamp`
			) 
		VALUES 
			(
				:fn,
				:ln,
				:em,
				:pw,
				:c,
				' . time() . ',
				' . time() . '
			)
		');

		$this->db->bind(':fn', $_SESSION['tmp_fn'], $this->db->PARAM_STR);
		$this->db->bind(':ln', $_SESSION['tmp_ln'], $this->db->PARAM_STR);
		$this->db->bind(':em', $_SESSION['tmp_em'], $this->db->PARAM_STR);
		$this->db->bind(':pw', md5($_SESSION['tmp_pw']), $this->db->PARAM_STR);
		$this->db->bind(':c', $_SESSION['tmp_c'], $this->db->PARAM_STR);

		$this->db->execute();

		return [
			'status' => 0
		];
	}

	public function login($e, $p) {
		$this->db->query('
		SELECT 
			`id`, 
			`b_first_name` AS `n`, 
			`b_email` AS `e`, 
			`b_country` AS `c` 
		FROM 
			`buyer` 
		WHERE 
			`b_email` = :e 
			AND `b_password` = :p
		');

		$this->db->bind(':e', $e, $this->db->PARAM_STR);
		$this->db->bind(':p', md5($p), $this->db->PARAM_STR);

		$d = $this->db->single();

		$p = DATADIR.DS.'buyer'.DS.$d->id.DS.'p.jpg';
		if (file_exists($p)) {
			$d->p = DATA.'/buyer/'.$d->id.'/p.jpg';
		} else {
			$d->p = null;
		}

		return [
			'status' => isset($d->id) ? 0 : 1,
			'data' => $d
		];
	}
}

?>