<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:05
 */

namespace Configure;

use Configure\Event\ConfigureEvent;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

/**
 * Class Module
 * @package Configure
 */
class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param EventInterface $e
     * @return array|void
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var EventManagerInterface $eventManager */
        $eventManager = $e->getApplication()->getEventManager();

        /** @var ConfigureEvent $configureEvent */
        $configureEvent = $e->getApplication()->getServiceManager()->get(ConfigureEvent::class);
        $configureEvent->attach($eventManager);
    }
}