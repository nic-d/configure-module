<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 13:34
 */

namespace Nybbl\ConfigureModule\Event\Factory;

use Interop\Container\ContainerInterface;
use Nybbl\ConfigureModule\Event\ConfigureEvent;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConfigureEventFactory
 * @package Nybbl\ConfigureModule\Event\Factory
 */
class ConfigureEventFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ConfigureEvent
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ConfigureEvent($container, $container->get('config')['configure_module']);
    }
}