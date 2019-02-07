<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:17
 */

namespace Nybbl\ConfigureModule\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Interface SettingsCollectEventInterface
 * @package Nybbl\ConfigureModule\Event
 */
interface SettingsCollectEventInterface extends ListenerAggregateInterface
{
    /**
     * @param EventInterface $event
     * @return array
     */
    public function onCollect(EventInterface $event): array;
}