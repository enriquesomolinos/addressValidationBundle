<?php

namespace Deyde\DataQBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DeydeDataQExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $yamlloader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $yamlloader->load("services.yml");
        
        
        
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);
        
        
        $container->setParameter('deyde_address_validation.deyde_user', $config['deyde_user']);
        $container->setParameter('deyde_address_validation.deyde_password', $config['deyde_password']);
        $container->setParameter('deyde_address_validation.address_validation_service_url', $config['address_validation_service_url']); 
        $container->setParameter('deyde_address_validation.deyde_base_url', $config['deyde_base_url']);
        $container->setParameter('deyde_address_validation.product_list_parameter', $config['product_list_parameter']);
            
        
        
        
        if(array_key_exists('proxy', $config)){
        	$container->setParameter('deyde_address_validation.proxy_user', $config['proxy']['user']);
        	$container->setParameter('deyde_address_validation.proxy_password', $config['proxy']['password']);
        	$container->setParameter('deyde_address_validation.proxy_address', $config['proxy']['address']);
        }    
        
    }

    public function getAlias()
    {
        return 'deyde_data_q';
    }
}
