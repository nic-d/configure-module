<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:05
 */

use Nybbl\ConfigureModule\Event;

return [
    'service_manager' => [
        'factories' => [
            Event\ConfigureEvent::class => Event\Factory\ConfigureEventFactory::class,
        ],
    ],

    'configure_module' => [
        // Map your FQCN service classes which extend the AbstractConfigureService here
        'configure_services' => [
            // ExampleConfigureService::class,
        ],
    ],
];