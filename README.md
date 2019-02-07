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
The core of an ACL is a resource. To map your resources (aka controllers), you can specify
an array key in your module configs.

Application/config/module.config.php:
```php
'controllers' => [
    'factories' => [
        Controller\ApplicationController::class => InvokableFactory::class,
    ],
],

## This is where you can specify your resources
'access_manager' => [
    'resources' => [
        Controller\ApplicationController::class => [
            [
                'allow'   => 'Guest',
                'actions' => ['index'],
            ],
            [
                'allow'   => 'Admin',
                'actions' => ['home', 'users', 'posts'],
            ],
        ],
    ],
],
```

## Customising the not-authorised view
By default, the "not-authorised" view just renders some text. You most likely want to customise this.
You can create a view directory in any module with the path:
```
access-acl/not-authorised/index.twig
```

## Changing Role Providers
To change your role provider, you'll need a class that implements the RoleProviderInterface.
Then add the alias to the interface in your module config:

```php
'service_manager' => [
    'aliases' => [
        Nybbl\AccessAcl\Contract\RoleProviderInterface::class => MyCustomRoleProvider::class,
    ],
],
```

## Creating Roles
To create a role, you'll need to create a class that implements the Nybbl\AccessAcl\Contract\RoleInterface

Like so:
```php
class AdminRole implements RoleInterface
{
    // Implement body methods.
}
```
Your custom role provider can then consume these roles.

## Creating Dynamic Assertions
```php
use Nybbl\AccessAcl\Contract\DynamicAssertionInterface;

class ExampleAssertion implements DynamicAssertionInterface
{
    /**
     * @param string $resource
     * @param null $privilege
     * @param array $options
     * @return bool|mixed
     */
    public function assert(string $resource, $privilege = null, array $options = [])
    {
        // Implement yor logic based on the result...
        if ($options['can.edit']) {
            if ($options['identity']->id() === $options['blogPost']->ownerId()) {
                return self:ACCESS_GRANTED;
            }
        }
    }
}
```

In your controller:
```php
public function editAction()
{
    $this->assert(ExampleAssertion::class, 'index', 'can.edit', [
        'identity' => $this->identity(),
        'blogPost' => $blogPostEntity,
    ]);

    return new ViewModel();
}
```
By default, a dynamic assertion will return false.