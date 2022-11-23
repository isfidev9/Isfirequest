<?php

class Isfirequest
{

	public $_base_url = "";

	protected $_timeout = 0;

	protected $_headers = array();

	protected $_methods = "GET";

	public $isfireq;

	protected $response = [];


	public function config($options)
	{
	    $this->isfireq = $this->buildRequest($options);
	    return $this;
	}


	protected function buildRequest($opt)
	{
		$this->_base_url = !empty($opt["base_url"]) ? $opt["base_url"] : $this->_base_url;
		$this->_methods = !empty($opt["method"]) ? strtoupper($opt["method"]) : $this->_methods;

		if(!empty($opt["headers"]) && is_array($opt["headers"]))
		{
			foreach($opt["headers"] as $k => $v)
			{
				$this->_headers[] = $k.": ".$v;
			}
		}
		return $this;
		
	}

	public function setMethod($string="GET")
	{
		$this->_methods = strtoupper($string);
		return $this;
	}

	public function addHeaders($array)
	{
		foreach($array as $k => $v)
		{
			$d = $k.": ".$v;
			array_push($this->_headers, $d);
		}
		// $this->_headers = $headers;
		return $this;
	}


	public function post($url, $data=[])
	{
		$url = !empty($this->_base_url) ? $this->_base_url.$url : $url;
		$datas = http_build_query($data);
		if(in_array("Content-Type: application/json", $this->_headers))
		{
			$datas = json_encode($data);
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => $this->_timeout,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $datas,
		  CURLOPT_HTTPHEADER => $this->_headers,
		));

		$this->response = curl_exec($curl);
		return $this;
	}


	public function get($url, $data=[])
	{
		$url = !empty($this->_base_url) ? $this->_base_url.$url : $url;
		$datas = !empty($data) ? $data : "";
		$datas = !is_array($datas) ? $datas : http_build_query($datas);

		if(in_array("Content-Type: application/json", $this->_headers))
		{
			$datas = is_array($data) ? json_encode($data) : $data;
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => $this->_timeout,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => $datas,
		  CURLOPT_HTTPHEADER => $this->_headers,
		));

		$this->response = curl_exec($curl);
		return $this;
	}


	public function body()
	{
		return $this->response;
	}

	public function object()
	{
		if(!empty($this->response)){
			$res = ($this->json_validator($this->response)) ? json_decode($this->response) : $this->response;
		}else{
			$res = json_decode($this->response);
		}
		return $res;
	}

	public function json()
	{
		$res = json_encode($this->response);
		if(!empty($this->response)){
			$res = ($this->json_validator($this->response)) ? json_decode($this->response,true) : $this->response;
			$res = json_encode($res);
		}
		header("Content-Type: application/json");
		echo $res;
	}


	// return bolean true or false
	protected function json_validator($data) 
	{
		if (!empty($data)) {
			return is_string($data) &&
			is_array(json_decode($data, true)) ? true : false;
		}
		return false;
	}

}