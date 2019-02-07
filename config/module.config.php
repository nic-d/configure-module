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
            Event\SettingsCollectEvent::class => Event\Factory\SettingsCollectEventFactory::class,
        ],
    ],

    'configure_module' => [
        'configure_services' => [
            // ExampleConfigureService::class,
        ],

        'settings_services' => [
//             'module_name' => ExampleSettingsService::class,
        ],
    ],
];