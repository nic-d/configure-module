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
Essentially, this module will collect all of your classes which extend AbstractConfigureService and iterate through and
call the appropriate method.

For example, when the configure.install event is triggered, the onInstall() method is called inside our Event, which in turn
calls the install() method in your mapped service.

## Mapping Services
All the mapped services are fetched from the container, so make sure you've mapped them in the ServiceManager first.

```php
ModuleName/config/module.config.php:

'service_manager' => [
    'factories' => [
        ExampleConfigureService::class => ExampleConfigureServiceFactory::class,
    ],
],
```

Now you can add your service to the ConfigureModule mapping:
```php
ModuleName/config/module.config.php:

'configure_module' => [
    // Map your FQCN service classes which extend the AbstractConfigureService here
    'configure_services' => [
        ExampleConfigureService::class,
    ],
],
```

## Creating a Service
All of your mapped configure services should extend the AbstractConfigureService.
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