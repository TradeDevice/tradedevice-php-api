<?php

/*
 *
 *	TradeDevice PHP Api
 *  for use with TradeDevice.com
 *  License: MIT
 *  Api Keys and/or Referall/Affiliate Keys may be required!
 *
 */

class TradeDevice {

	private $api_root;
	private $country;
	private $api_key;
	private $affiliate;

	public $url = "tradedevice.com/api/";

	public function __construct($country = "us", $api_key = null, $affiliate = null)
	{
		// Fixing User Errors
		if($country == "US")
		{
			$country = "us";
		}
		if($country == "CA")
		{
			$country = "ca";
		}
		// Settings
		$this->country = $country;
		if(is_null($api_key))
		{
			$this->api_key = 0;
		}
		else
		{
			$this->api_key = $api_key
		}
		if(is_null($affiliate))
		{
			$this->affiliate = 0;
		}
		else
		{
			$this->affiliate = $affiliate
		}
	}

	private function getApiRoot()
	{
		$country = $this->country;
		$root = $country . $this->url;
		return $root;
	}

	private function getData($query)
	{
		$root = $this->getApiRoot();
		$final = $root.$query;

		$json = file_get_contents($final);
		// Turn it into something usefull!
		$data = json_decode($json);
		// Return it
		return $data;
	}

	public function getDevices()
	{
		// Define query
		$query = "devices?api_key=".$this->api_key."&affiliate=".$this->affiliate;
		// Get the data and return it
		$data = $this->getData($query);
		return $data;
	}

	public function getQuestions($device)
	{
		// Define query
		$query = "questions?api_key=".$this->api_key."&affiliate=".$this->affiliate."&device".$device;
		// Get the data and return it
		$data = $this->getData($query);
		return $data;
	}

	public function getAmount($device,$questionarray)
	{
		$questions;
		foreach($questionarray as $q => $a)
		{
			// Prepare
			$questions .= $q."=".$a."&";
		}
		// Prepare the query
		$query = "amount?api_key=".$this->api_key."&affiliate=".$this->affiliate."&device".$device."&".$questions;
		// Thats a long query!
		// We will submit it anyways
		$data = $this->getData($query);
		return $data;
	}

}