<?php
namespace Deyde\DataQBundle\lib;

class DeydeAddressValidator{
	
	
	private $options;
	
	private $address_validation_service_url = 'deyde-autoCompletion/domicilio';
	private $product_list_parameter = 'deyde-autoCompletion/domicilio';
	private $deyde_base_url = 'https://ws.deyde.com.es/';
	
	
	/**
	 * Set the option to call deyde service
	 * @param array $options
	 * @throws InvalidArgumentException
	 */
	public function setOptions($options){
		
		
		if(!array_key_exists('address_validation_service_url',$options)){
			$options['address_validation_service_url'] = $this->address_validation_service_url;
		}
		if(!array_key_exists('product_list_parameter',$options)){
			$options['product_list_parameter'] = $this->product_list_parameter;
		}
		if(!array_key_exists('deyde_base_url',$options)){
			$options['deyde_base_url'] = $this->deyde_base_url;
		}
		if(!array_key_exists('deyde_user',$options) || !array_key_exists('deyde_password',$options)){
			throw new InvalidArgumentException('Both deyder_user, deyde_password must be defined');
		}	
		$this->options = $options;
		
	}	
	
	
	/**
	 * public service that calls deyde address validation service
	 * @param string $address
	 */
	public function validateAddress($address){
	
		$data = array (
				"user" => $this->options['deyde_user'],
				"pass" => $this->options['deyde_password'],
				"t" => $address,
				"l" => $this->options['product_list_parameter'],
				"responseFormat" => "json"
		);
	
		$result = $this->callAPI("GET", $this->options['deyde_base_url'].$this->options['address_validation_service_url'],$data);
		
		if($result['data']!=null){
			$result['data'] = json_decode($result['data']);
		}

		return $result;
	}
	
	
	/**
	 * Call an Api with method $method 
	 * @param string $method
	 * @param string $url
	 * @param string $data
	 */
	private function callAPI($method, $url, $data = false)
	{
		$curl = curl_init();
		
		if(array_key_exists('proxy',$this->options)){
			curl_setopt($curl, CURLOPT_PROXY, $this->options['proxy']['address']);
			curl_setopt ($curl, CURLOPT_PROXYUSERPWD, $this->options['proxy']['user'].':'.$this->options['proxy']['password'] );
		}
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	
	
		switch ($method)
		{
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
	
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			default:
	
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		curl_setopt($curl,CURLOPT_URL,$url);
	
		$result = array();
		
		$result['data'] = curl_exec($curl);
		$result['error_code']=curl_error($curl);
		
		curl_close($curl);
		return $result;
	}
	
	
	
	
}