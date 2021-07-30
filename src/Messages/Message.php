<?php

namespace JagdishJP\FpxPayment\Messages;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use JagdishJP\FpxPayment\Models\FpxTransaction;
use JagdishJP\FpxPayment\Traits\VerifyCertificate;

class Message {
	use VerifyCertificate;

	/**
	 * Payment Business Model Flow
	 * 01 = B2C
	 * 02 = B2B1
	 * 03 = B2B2
	 */
	public $flow;
	public const FLOW_B2C  = '01';
	public const FLOW_B2B1 = '02';
	public const FLOW_B2B2 = '03';

	/**
	 * Transaction Id For Each Payment
	 *
	 */
	public $id;

	/**
	 * Transaction Id generated by FPX on each transaction
	 *
	 */
	public $foreignId;

	/**
	 * Seller ID provided by FPX
	 */
	public $sellerId;

	/**
	 * Account ID provided by FPX
	 */
	public $exchangeId;

	/**
	 * Seller bank code used in the transaction
	 */
	public $bankCode;

	/**
	 * FPX request type
	 * @see JagdishJP\FpxPayment\Constant\Type;
	 */
	public $type;

	/**
	 * FPX used Verision
	 */
	public $version;

	/**
	 * Currency
	 */
	public $currency;

	/**
	 * Total amount to be paid
	 */
	public $amount;

	/**
	 * datetime of the transaction in YYYYMMDDHHmmSS format
	 */
	public $timestamp;

	/**
	 * datetime of the transaction generate from FPX in YYYYMMDDHH24MISS
	 */
	public $foreignTimestamp;

	/**
	 * Reference Number used to reference the transaction
	 */
	public $reference;

	/**
	 * The customer email address (optional)
	 */
	public $buyerEmail;

	/**
	 * The customer name
	 */
	public $buyerName;

	/**
	 * Buyer Account ID used for identify verification. (Optional)
	 */
	public $buyerAccountNumber;

	/**
	 * The customer id on the FPX side. (Only For B2B2) (Optional For B2C)
	 */
	public $buyerId;


	/**
	 * The selected bank ID by the customer
	 */
	public $targetBankId;

	/**
	 * The bank branch where the customer opened his/her account in. (Only For B2B2)
	 */
	public $targetBankBranch;

	/**
	 * The bank account number of the customer. (Only For B2B2)
	 */
	public $targetBankAccountNumber;

	/**
	 * Buyer representative (Maker) who initiate the transaction. (Only For B2B2)
	 */
	public $buyerMakerName;

	/**
	 * Buyer IBAN. (Only For B2B2)
	 */
	public $buyerIBAN;

	/**
	 * Product Description
	 */
	public $productDescription;

	/**
	 * Credit Card response status sent by FPX
	 */
	public $creditResponseNumber;
	public $creditResponseStatus;

	/**
	 * Debit Card response status sent by FPX
	 */
	public $debitResponseNumber;
	public $debitResponseStatus;

	/**
	 * Response checksum
	 */
	public $checkSum;

	/**
	 * Request from App or Web
	 */
	protected $responseFormat;

	public function __construct() {

		$this->id = $this->generate_uuid();
		$this->flow = self::FLOW_B2C;
		$this->bankCode = Config::get('fpx.bank_code');
		$this->exchangeId = Config::get('fpx.exchange_id');
		$this->sellerId = Config::get('fpx.seller_id');
		$this->currency = Config::get('fpx.currency');
		$this->version = Config::get('fpx.version');
	}

	public function generate_uuid() {
		do {
			$uuid = Str::uuid();
		} while (FpxTransaction::where("unique_id", $uuid)->first());

		return $uuid;
	}
}
