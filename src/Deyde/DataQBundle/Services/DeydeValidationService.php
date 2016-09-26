<?php


namespace Deyde\DataQBundle\Services;

use Deyde\DataQBundle\Exception\ServiceNotAvailableException;
use Deyde\DataQBundle\lib\DeydeAddressValidator;
use Deyde\DataQBundle\Exception\ServiceException;

class DeydeValidationService 
{
	/**
	 * Log service
	 * @var \Monolog\Logger
	 */
	private $logger;
	
	
	
	/**
	 * Configuration options
	 * @var array
	 */
	private $options;
	
	
	
	/**
	 *
	 * @param unknown $container
	 * @param \Monolog\Logger $logger
	 */
	public function __construct($container,$logger){
		$this->logger = $logger;
		
		$this->options['deyde_user'] = $container->getParameter('deyde_address_validation.deyde_user');
		$this->options['deyde_password'] = $container->getParameter('deyde_address_validation.deyde_password');
		$this->options['address_validation_service_url'] = $container->getParameter('deyde_address_validation.address_validation_service_url');
		$this->options['product_list_parameter'] = $container->getParameter('deyde_address_validation.product_list_parameter');
		$this->options['deyde_base_url'] = $container->getParameter('deyde_address_validation.deyde_base_url');
		
		
		
		
		if($container->hasParameter('deyde_address_validation.proxy_address') &&
	   	   $container->hasParameter('deyde_address_validation.proxy_password') &&
		   $container->hasParameter('deyde_address_validation.proxy_user')){
						
			$this->options['proxy']['address'] = $container->getParameter('deyde_address_validation.proxy_address');
			$this->options['proxy']['user'] = $container->getParameter('deyde_address_validation.proxy_user');
			$this->options['proxy']['password'] = $container->getParameter('deyde_address_validation.proxy_password');
			
		}
	}
	
	
	public function validateAddress($address){
		
		$validator = new DeydeAddressValidator();		
		
		$validator->setOptions($this->options);
		$result =$validator->validateAddress($address);
		
		if($result==null){
			$this->logger->warn('DeydeDataQBundle : Deyde service not available. The request was:'.$address);
			throw new ServiceNotAvailableException();
		}
		if($result['error_code']!=null && $result['error_code']!=''){
			$this->logger->warn('DeydeDataQBundle : Deyde service throw an error:'. $result['error_code']. 'The request was:'.$address);
			throw new ServiceException();
		}
		
		
		return $result['data'];		
	}
	
}