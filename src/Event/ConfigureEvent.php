<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 13:34
 */

namespace Nybbl\ConfigureModule\Event;

use Psr\Container\ContainerInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Nybbl\ConfigureModule\Service\AbstractConfigureService;
use Nybbl\ConfigureModule\Service\ConfigureServiceInterface;

/**
 * Class ConfigureEvent
 * @package Nybbl\ConfigureModule\Event
 */
class ConfigureEvent implements ConfigureEventInterface
{
    /** @var ContainerInterface $container */
    private $container;

    /** @var array $listeners */
    private $listeners = [];

    /** @var array $moduleConfig */
    private $moduleConfig;

    /** @var array $configureServices */
    private $configureServices = [];

    /**
     * ConfigureEvent constructor.
     * @param ContainerInterface $container
     * @param array $moduleConfig
     */
    public function __construct(ContainerInterface $container, array $moduleConfig = [])
    {
        $this->container = $container;
        $this->moduleConfig = $moduleConfig;
        $this->initConfigureServices();
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            'configure.install',
            [$this, 'onInstall'],
            $priority
        );

        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            'configure.update',
            [$this, 'onUpdate'],
            $priority
        );

        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            'configure.uninstall',
            [$this, 'onUninstall'],
            $priority
        );
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $key => $value) {
            if ($events->detach($value)) {
                unset($this->listeners[$key]);
            }
        }
    }
    
    /**
     * @param EventInterface $event
     * @return void
     */
    public function onInstall(EventInterface $event)
    {
        /** @var ConfigureServiceInterface $configureService */
        foreach ($this->configureServices as $configureService) {
            $configureService->install();
        }
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function onUpdate(EventInterface $event)
    {
        /** @var ConfigureServiceInterface $configureService */
        foreach ($this->configureServices as $configureService) {
            $configureService->update();
        }
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function onUninstall(EventInterface $event)
    {
        /** @var ConfigureServiceInterface $configureService */
        foreach ($this->configureServices as $configureService) {
            $configureService->uninstall();
        }
    }

    /**
     * @return void
     */
    private function initConfigureServices()
    {
        // Get the mapped services from the config
        $configureServices = $this->moduleConfig['configure_services'];
        $discoveredServices = [];

        foreach ($configureServices as $configureService) {
            // If the mapped configure service extends this class, it's a valid configure service!
            if (is_subclass_of($configureService, AbstractConfigureService::class)) {
                $discoveredServices[] = $this->container->get($configureService);
            }
        }

        $this->configureServices = $discoveredServices;
    }
}