<?php


namespace Deyde\DataQBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This extension validates the configuration
 *
 * @author usuario
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder $builder The tree builder
     */
    public function getConfigTreeBuilder()
    {
    	
    	$supportedProductLists = array('es,dom,cod','pt,dom,cod');
        $builder = new TreeBuilder();

        $rootNode = $builder->root('deyde_data_q');
        $rootNode
            ->children()
            	->arrayNode('proxy')
            		->children()
            			
            			->scalarNode('user')->end()
            			->scalarNode('password')->end()
            			->scalarNode('address')->end()
            		->end()
            	->end()
                ->scalarNode('deyde_user')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('deyde_password')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('address_validation_service_url')->defaultValue('deyde-autoCompletion/domicilio')->cannotBeEmpty()->end()
                ->scalarNode('deyde_base_url')->defaultValue('https://ws.deyde.com.es/')->cannotBeEmpty()->end()
                ->scalarNode('product_list_parameter')->defaultValue('es,dom,cod')->cannotBeEmpty()
                	->validate()
                	->ifNotInArray($supportedProductLists)
                	->thenInvalid('The Product list %s is not supported in this version. Please choose one of '.json_encode($supportedProductLists))
                	->end()
                
                
                
            ->end();
        
       

        return $builder;
    }
}
