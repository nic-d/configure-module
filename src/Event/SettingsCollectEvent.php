<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 14:31
 */

namespace Nybbl\ConfigureModule\Event;

use Psr\Container\ContainerInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Nybbl\ConfigureModule\Entity\SettingsInterface;
use Nybbl\ConfigureModule\Service\SettingsServiceInterface;

/**
 * Class SettingsCollectEvent
 * @package Nybbl\ConfigureModule\Event
 */
class SettingsCollectEvent implements SettingsCollectEventInterface
{
    /** @var ContainerInterface $container */
    private $container;

    /** @var array $listeners */
    private $listeners = [];

    /** @var array $moduleConfig */
    private $moduleConfig;

    /** @var array $settingsServices */
    private $settingsServices = [];

    /**
     * SettingsCollectEvent constructor.
     * @param ContainerInterface $container
     * @param array $moduleConfig
     */
    public function __construct(ContainerInterface $container, array $moduleConfig = [])
    {
        $this->container = $container;
        $this->moduleConfig = $moduleConfig;
        $this->initSettingsServices();
    }

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            'configure.settings.collect',
            [$this, 'onCollect'],
            $priority
        );
    }

    /**
     * @param EventManagerInterface $events
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
     * @return array
     */
    public function onCollect(EventInterface $event): array
    {
        $moduleSettings = [];

        /** @var SettingsServiceInterface $settingsService */
        foreach ($this->settingsServices as $key => $settingsService) {
            $moduleSettings[$key] = $settingsService->get();
        }

        return $moduleSettings;
    }

    /**
     * @return void
     */
    private function initSettingsServices()
    {
        // Get the mapped services from the config
        $settingsServices = $this->moduleConfig['settings_services'];
        $discoveredServices = [];

        foreach ($settingsServices as $key => $settingsService) {
            if ($settingsService instanceof SettingsInterface) {
                $discoveredServices[$key] = $this->container->get($settingsService);
            }
        }

        $this->settingsServices = $discoveredServices;
    }
}