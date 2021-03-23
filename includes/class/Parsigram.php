<?php

	###################################
	####					       ####
	####    Parsigram Php Client   ####
	####        Version: 1.0       ####
	####    http://parsigram.com   ####
	####					       ####
	###################################

	class Parsigram
	{

		protected $token;
		protected $endpoint = 'http://api.parsigram.com/';

	    public function __construct($token)
	    {
			
			$this->token = $token;

			if(!function_exists('curl_version'))
			{
				throw new Exception('Server doesn\'t have curl library');
			}

		}

		/* Get wallet balance */
		public function walletBalance()
		{

			$data = $this->request('service/balance/wallets');

			return $this->response($data);

		}

		/* Get wallet transactions */
		public function walletTransactions($page='', $limit='', $batch='', $account='', $time_from='', $time_to='', $type='')
		{

			$post = [
						'page'				=> $page,
						'limit'				=> $limit,
						'batch'				=> $batch,
						'account'			=> $account,
						'time_from'			=> $time_from,
						'time_to'			=> $time_to,
						'type'				=> $type
					];			

			$data = $this->request('service/balance/transactions', $post);

			return $this->response($data);

		}

		/* Transfer money to a Parsigram account */
		public function walletToAccount($account, $amount, $target)
		{

			$post = [
						'account'			=> $account,
						'amount'			=> $amount,
						'target'			=> $target
					];			

			$data = $this->request('service/balance/to_account', $post);

			return $this->response($data);

		}

		/* Create a Parsigram card with Parsigram account */
		public function walletCreateCard($account, $amount)
		{

			$post = [
						'account'			=> $account,
						'amount'			=> $amount
					];			

			$data = $this->request('service/balance/create_card', $post);

			return $this->response($data);

		}

		/* Transfer money to a Parsigram card with Parsigram account */
		public function walletToCard($account, $amount, $card)
		{

			$post = [
						'account'			=> $account,
						'amount'			=> $amount,
						'card'				=> $card
					];			

			$data = $this->request('service/balance/to_card', $post);

			return $this->response($data);

		}

		/* Create a Parsigram voucher with Parsigram account */
		public function walletToVoucher($account, $amount)
		{

			$post = [
						'account'			=> $account,
						'amount'			=> $amount
					];			

			$data = $this->request('service/voucher/create', $post);

			return $this->response($data);

		}

		/* Check a Parsigram voucher */
		public function checkVoucher($voucher, $activation)
		{

			$post = [
						'voucher'			=> $voucher,
						'activation'		=> $activation
					];			

			$data = $this->request('service/voucher/check', $post);

			return $this->response($data);

		}

		/* Get Parsigram vouchers list */
		public function getVouchers($page='', $limit='', $status='')
		{

			$post = [
						'page'				=> $page,
						'limit'				=> $limit,
						'status'			=> $status
					];			

			$data = $this->request('service/voucher/get', $post);

			return $this->response($data);

		}

		/* Use Parsigram voucher to Parsigram account */
		public function voucherToAccount($account, $voucher, $activation)
		{

			$post = [
						'account'			=> $account,
						'voucher'			=> $voucher,
						'activation'		=> $activation
					];			

			$data = $this->request('service/voucher/to_account', $post);

			return $this->response($data);

		}

		/* Use Parsigram voucher to create a Parsigram card */
		public function voucherCreateCard($voucher, $activation)
		{

			$post = [
						'voucher'			=> $voucher,
						'activation'		=> $activation
					];			

			$data = $this->request('service/voucher/create_card', $post);

			return $this->response($data);

		}

		/* Use Parsigram voucher to Parsigram card */
		public function voucherToCard($card, $voucher, $activation)
		{

			$post = [
						'card'				=> $card,
						'voucher'			=> $voucher,
						'activation'		=> $activation
					];			

			$data = $this->request('service/voucher/to_card', $post);

			return $this->response($data);

		}

		/* Get Parsigram cards list */
		public function getCards($page='', $limit='', $status='')
		{

			$post = [
						'page'				=> $page,
						'limit'				=> $limit,
						'status'			=> $status
					];			

			$data = $this->request('service/card/get', $post);

			return $this->response($data);

		}

		/* Start Parsigram payment */
		public function parsigramPayment($account, $amount, $callback, $referance='', $domain='')
		{

			$post = [
						'account'			=> $account,
						'amount'			=> $amount,
						'callback'			=> $callback,
						'referance'			=> $referance,
						'domain'			=> $domain
					];

			$data = $this->request('service/gateway/card', $post);

			return $this->response($data);

		}


		/* Start Parspay payment */
		public function wirePayment($amount, $callback, $referance='', $card='', $domain='')
		{

			$post = [
						'amount'			=> $amount,
						'callback'			=> $callback,
						'referance'			=> $referance,
						'card'				=> $card,
						'domain'			=> $domain
					];

			$data = $this->request('service/gateway/wire', $post);

			return $this->response($data);

		}

		/* Verify payment for Parsigram payment and Parspay payment */
		public function verifyPayment($order)
		{

			$post = [
						'order'				=> $order
					];

			$data = $this->request('service/gateway/verify', $post);

			return $this->response($data);

		}

		/* Get list of Parspay bank accounts */
		public function wireBanks($bank='')
		{

			$post = [
						'bank'				=> $bank
					];

			$data = $this->request('service/wire/accounts', $post);

			return $this->response($data);

		}

		/* Check bank account number owner name */
		public function wireAccountOwner($bank, $account)
		{

			$post = [
						'bank'				=> $bank,
						'account'			=> $account
					];

			$data = $this->request('service/wire/account_name', $post);

			return $this->response($data);

		}

		/* Make account to account money transfer */
		public function wireAccountTransfer($bank, $account, $amount, $source_account='')
		{

			$post = [
						'bank'				=> $bank,
						'account'			=> $account,
						'amount'			=> $amount,
						'source_account'	=> $source_account
					];

			$data = $this->request('service/wire/account_transfer', $post);

			return $this->response($data);

		}

		/* Check bank sheba number owner name */
		public function wireIbanOwner($bank, $iban)
		{

			$post = [
						'bank'				=> $bank,
						'iban'				=> $iban
					];

			$data = $this->request('service/wire/iban_name', $post);

			return $this->response($data);

		}

		/* Make sheba money transfer */
		public function wireIbanTransfer($bank, $iban, $amount, $source_account='')
		{

			$post = [
						'bank'				=> $bank,
						'iban'				=> $iban,
						'amount'			=> $amount,
						'source_account'	=> $source_account
					];

			$data = $this->request('service/wire/iban_transfer', $post);

			return $this->response($data);

		}


		private function response(&$req)
		{

			if(isset($req->result) && $req->result=='ok')
			{
				return $req;
			}

			$code = isset($req->code)?$req->code:0;
			$msg  = isset($req->message)?$req->message:'Unexpected error!';

			throw new Exception('('.$code.') '.$msg);

		}

	    private function request($method, $post=[])
	    {

	    	$post['token'] = $this->token;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->endpoint.$method);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$output = curl_exec($ch);

			curl_close($ch);

			return @json_decode($output);

	    }

	}
	