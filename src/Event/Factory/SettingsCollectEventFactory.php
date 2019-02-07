<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 14:33
 */

namespace Nybbl\ConfigureModule\Event\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Nybbl\ConfigureModule\Event\SettingsCollectEvent;

/**
 * Class SettingsCollectEventFactory
 * @package Nybbl\ConfigureModule\Event\Factory
 */
class SettingsCollectEventFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return SettingsCollectEvent
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SettingsCollectEvent($container, $container->get('config')['configure_module']);
    }
}