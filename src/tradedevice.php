<?php

/**
   * TradeDevice PHP API
   * 
   * 
   * @package    tradedevice-php-api
   * @subpackage TradeDevice
   * @author     TradeDevice <info@tradedevice.com>
   */

class TradeDevice {

	private $api_root;
	private $country;

	public $url = "tradedevice.com/api/";

	public function __construct($country = "us")
	{
		// Fixing User Errors
		if($country == "US")
			$country = "us";
		if($country == "CA")
			$country = "ca";
		// Settings
		$this->country = $country;
	}

       /**
       * 
       * gets API root from Website
       *
       * @return string
       */
	private function getApiRoot()
	{
		$country = $this->country;
		$root = $country . $this->url;
		return $root;
	}

       /**
       * 
       * Grabs data from the API
       *
       * @param string $query The query which was setup by other methods.
       * @return boolean
       */
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
	
       /**
       * 
       * Sets up query for getting devices from the API
       *
       * @param int $limit Limit for how many devices
       * @return string ($data=query)
       */
	public function getDevices($limit = 0)
	{
		// Define query
		$query = "devices?limit=".$limit;
		// Get the data and return it
		$data = $this->getData($query);
		return $data;
	}

       /**
       * 
       * Sets up query for getting devices from the API
       *
       * @param string $device
       * @return string ($data=query)
       */
	public function getQuestions($device)
	{
		// Define query
		$query = "questions?device=".$device;
		// Get the data and return it
		$data = $this->getData($query);
		return $data;
	}

       /**
       * 
       * Sets up query for getting devices from the API
       *
       * @param string $device
       * @param array $questionarrow
       * @return string ($data=query)
       */
	public function getAmount($device,$questionarray)
	{
		$questions;
		foreach($questionarray as $q => $a)
		{
			// Prepare
			$questions .= $q."=".$a."&";
		}
		// Prepare the query
		$query = "amount?device=".$device."&".$questions;
		// Thats a long query!
		// We will submit it anyways
		$data = $this->getData($query);
		return $data;
	}

}
