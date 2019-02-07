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

## First Steps


## Mapping Services