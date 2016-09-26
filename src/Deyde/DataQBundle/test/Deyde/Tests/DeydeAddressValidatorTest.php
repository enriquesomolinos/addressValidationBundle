<?php



namespace Deyde\Tests;

use DeydeAddressValidator;

class DeydeAddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    
	public function testAddressValidation(){
		$validator = new DeydeAddressValidator();		
		$validator->setOptions($this->getValidOptions());
				
		$result = $validator->validateAddress('Calle Milan 34 28043 Madrid');		
		$this->assertNotNull($result);
		$this->assertEquals($result->codigoPostal,'28043');
		$this->assertEquals($result->municipio,'MADRID');
		$this->assertEquals($result->nombreVia,'MILAN');
		$this->assertEquals($result->numeroVia,'0034');
		$this->assertEquals($result->poblacion,'MADRID');
		$this->assertEquals($result->provincia,'MADRID');														
	}
	
	public function testEmptyAddressValidation(){
		$validator = new DeydeAddressValidator();
		$validator->setOptions($this->getValidOptions());
	
		$result = $validator->validateAddress('');
		
		$this->assertNull($result);
		
	}
	public function testInvalidOption(){
		$validator = new DeydeAddressValidator();
		$validator->setOptions($this->getInValidOptions());
	
		$result = $validator->validateAddress('Calle Milan 34 28043 Madrid');
		$this->assertNull($result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Both deyder_user, deyde_password must be defined
	 */
	public function testIncompleteOption(){
		$validator = new DeydeAddressValidator();
		$validator->setOptions($this->getIncompleteOptions());
	
		
		$result = $validator->validateAddress('Calle Milan 34 28043 Madrid');
		
	}
	
	private function getIncompleteOptions(){
		$options = array();
	
		$options['deyde_user'] = 'test';
		
		$options['address_validation_service_url'] = 'deyde-autoCompletion/domicilio';
		$options['product_list_parameter'] = 'es,dom,cod';
		$options['deyde_base_url'] = 'https://ws.deyde.com.es/';
		
	
		return $options;
	
	}
	
	private function getInValidOptions(){
		$options = array();
	
		$options['deyde_user'] = 'test';
		$options['deyde_password'] = 'test';
		$options['address_validation_service_url'] = 'deyde-autoCompletion/domicilio';
		$options['product_list_parameter'] = 'es,dom,cod';
		$options['deyde_base_url'] = 'https://ws.deyde.com.es/';
		
	
		return $options;
	
	}
	
	private function getValidOptions(){
		$options = array();
		
		$options['deyde_user'] = 'PUT YOUR USER HERE';
		$options['deyde_password'] = 'PUT YOUR PASSWORD HERE';
		$options['address_validation_service_url'] = 'deyde-autoCompletion/domicilio';
		$options['product_list_parameter'] = 'es,dom,cod';
		$options['deyde_base_url'] = 'https://ws.deyde.com.es/';
		
		
		return $options;
		
	}

}
