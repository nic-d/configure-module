# Nybbl Configure Module
Allows you to hook into Install (and related) events. This module was being used in several of our internal projects.
In our use case, we had an install tool that needed to set up Doctrine entitites and what-not in an environment that we didn't have access to, or control.

## Installation
```
$ composer require nybbl/configure-module
```

## Usage
To use this module, add it to your modules.config.php file:
```php
return [
    ...
    
    'Nybbl\ConfigureModule',
];
```

## Overview
There are two core features of this module; Configure and Collect.

#### Configure
The Configure feature will collect all of your classes which extend AbstractConfigureService and iterate through and
call the appropriate method.

For example, when the configure.install event is triggered, the onInstall() method is called inside our Event, which in turn
calls the install() method in your mapped service.

#### Collect
The Collect feature will collect all of your classes which implement SettingsInterface and
iterate through and fetch the settings using the get() method.

## Mapping Services
All the mapped services are fetched from the container, so make sure you've mapped them in the ServiceManager first.

```php
ModuleName/config/module.config.php:

'service_manager' => [
    'factories' => [
        ExampleSettingsService::class => ExampleSettingsServiceFactory::class,
        ExampleConfigureService::class => ExampleConfigureServiceFactory::class,
    ],
],
```

Now you can add your services to the configure_services or settings_services mapping:
```php
ModuleName/config/module.config.php:

'configure_module' => [
    // Map your FQCN service classes which extend the AbstractConfigureService here
    'configure_services' => [
        ExampleConfigureService::class,
    ],
    
    // Map your FQCN service classes which implement the SettingsServiceInterface here
    'settings_services' => [
        'module_name' => ExampleSettingsService::class,
    ],
],
```

Note: settings_services requires a module name to be the key. For example, I have an ApplicationSettingsService in my
Application module, so my mapping would look like:
```php
Application/config/module.config.php:

'configure_module' => [
    ...
    
    'settings_services' => [
        'Application' => ApplicationSettingsService::class,
    ],
],
```

## Creating Services
#### Configure Service
All of your Configure Services should extend the AbstractConfigureService.
You just need to call the init() method and pass an array of your entities.

```php
ModuleName/src/Service/ExampleConfigureService.php

class ExampleConfigureService extends AbstractConfigureService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $this->init([
           Entity\Settings::class,
           Entity\EmailSettings::class,
        ]);
    }
}
```

#### Settings Service
All of your Settings Services should implement the SettingsServiceInterface
(and if you wish, your entities can implement the SettingsInterface).

```php
ModuleName/src/Service/SettingsService.php

class SettingsService implements SettingsServiceInterface
{
    public function get(): SettingsInterface;
    {
        // It's up to you how you fetch your settings...
    }
}
```

## Triggering Events
Obviously, none of this is going to execute unless we trigger the events!

```php
// $eventManager is any object that implements the EventManagerInterface

// Trigger Settings events
$eventManager->trigger('configure.settings.collect');

// Trigger Configure events
$eventManager->trigger('configure.install');
$eventManager->trigger('configure.update');
$eventManager->trigger('configure.uninstall');
```