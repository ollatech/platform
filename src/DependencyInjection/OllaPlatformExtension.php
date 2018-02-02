<?php

namespace Olla\Platform\DependencyInjection;


use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;


final class OllaPlatformExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
       
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $this->reconfig($configs, $container);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('platform.xml');
        $loader->load('service.xml');
    }

    private function reconfig(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('flow_resource_paths', $config['mapping']['resource']);
        $container->setParameter('flow_operation_paths', $config['mapping']['operation']);
        $container->setParameter('flow_admin_paths', $config['mapping']['admin']);
        $container->setParameter('flow_frontend_paths', $config['mapping']['frontend']);
        //classes
        if(isset($config['class']['operation'])) {
            $class_operation = $config['class']['operation'];
        } else {
            $class_operation = 'Olla\Platform\Action\CollectionAction';
        }
        if(isset($config['class']['item'])) {
            $class_item = $config['class']['item'];
        } else {
            $class_item = 'Olla\Platform\Action\ItemAction';
        }
        if(isset($config['class']['create'])) {
            $class_create = $config['class']['create'];
        } else {
            $class_create = 'Olla\Platform\Action\CreateAction';
        }
        if(isset($config['class']['update'])) {
            $class_update = $config['class']['updateAction'];
        } else {
            $class_update = 'Olla\Platform\Action\UpdateAction';
        }
        if(isset($config['class']['delete'])) {
            $class_delete = $config['class']['delete'];
        } else {
            $class_delete = 'Olla\Platform\Action\DeleteAction';
        }
        $container->setParameter('class_collection_operation', $class_operation);
        $container->setParameter('class_item_operation', $class_item);
        $container->setParameter('class_create_operation', $class_create);
        $container->setParameter('class_update_operation', $class_update);
        $container->setParameter('class_delete_operation', $class_delete);
    }
}
