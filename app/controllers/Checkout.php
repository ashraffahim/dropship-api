<?php

namespace controllers;

use libraries\Controller;
use models\_Checkout;

class Checkout extends Controller {
	
	private $c;
	
	function __construct() {
		$this->c = new _Checkout();
	}

	public function success($id = false) {
		$this->sanitizeInputGet();
		$data = $this->c->success($id, $this->get('payment_intent_client_secret', ''));
		$data_param = [
			'title' => '',
			'description' => '',
			'canonical' => '',
			'meta' => '<meta name="robots" content="noindex">',
			'schema' => '',
			'data' => $data_param
		];

		include '../app/views/inc/header.php';
		require_once '../app/views/checkout/success.php';
		include '../app/views/inc/footer.php';
	}

	public function pay($m = false, $id = false) {
		$am = $this->availMethod();

		if (!in_array($m, $am)) {
			$data = [
				'title' => '',
				'description' => '',
				'canonical' => '',
				'meta' => '<meta name="robots" content="noindex">',
				'schema' => ''
			];
			include '../app/views/inc/header.php';
			require_once '../app/views/checkout/method.php';
			include '../app/views/inc/footer.php';
			return;
		}

		
		if ($id == false) {
			$po = $this->c->pendingOrder();
			if (isset($po->id)) {
				redir('/checkout/pay/' . $m . '/' . $po->id);
			} else {
				redir('/cart');
			}

			return;
		} else {
			if (!$this->c->validatePayableID($id)) {
				redir('/cart');
			}
		}

		// id = $id
		$cur = $this->c->orderCurrency($id);
		$a = $this->c->orderPayable($id);
		
		switch ($m) {
			case 'stripe':

				if ($this->RMisPost()) {
					$this->stripe($id, $cur, number_format($a, 2, '', ''));
				}
				
				$data = [
					'title' => '',
					'description' => '',
					'canonical' => '',
					'meta' => '<meta name="robots" content="noindex">',
					'schema' => ''
				];
				include '../app/views/inc/header.php';
				require_once '../app/views/checkout/stripe.php';
				include '../app/views/inc/footer.php';
				break;
		}
	}

	public function availMethod() {
		$ms = $this->c->availMethod();
		$a = [];
		foreach ($ms as $m) {
			$a[$m->id] = $m->code;
		}

		return $a;
	}

	public function order() {
		if ($this->RMisPost()) {
			$this->sanitizeInputPost();
			$data = $this->c->order($_POST);
			$this->return($data);
		}
	}

	private function amount($id) {
		return $this->c->orderPayable($id);
	}

	private function stripe($id, $c, $a) {

		require '../app/libraries/stripe-php/init.php';

		// This is your test secret API key.
		\Stripe\Stripe::setApiKey('sk_test_51JGXp4IoGl18YWC8sqlP7TeCjGpezoYpn45HwDmSUWGmNLCeKG5EfdY2ZUYCQATLhovA4HuevEdSPH1Xp0yGhqFI00tEdFGqMx');
		
		header('Content-Type: application/json');
		
		try {
			// retrieve JSON from POST body
			// $jsonStr = file_get_contents('php://input');
			// $jsonObj = json_decode($jsonStr);
		
			// Create a PaymentIntent with amount and currency
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => $a,
				'currency' => $c,
				'automatic_payment_methods' => [
					'enabled' => true,
				],
			]);
		
			$output = [
				'clientSecret' => $paymentIntent->client_secret,
			];
		
			echo json_encode($output);
		} catch (Error $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}

		exit;
	}
}

?>