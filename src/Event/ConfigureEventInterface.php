<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:01
 */

namespace Configure\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Interface ConfigureEventInterface
 * @package Configure\Event
 */
interface ConfigureEventInterface extends ListenerAggregateInterface
{
    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function onInstall(EventInterface $event);

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function onUpdate(EventInterface $event);

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function onUninstall(EventInterface $event);
}