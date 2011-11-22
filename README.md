# Controller prefix plugin for CakePHP2.0.x #

`Controller name prefix' custom route plugin for CakePHP

## Background ##

This custom route class prove controller name prefix route.

ex. /admin/users/edit => AdminUsersController::edit()

## Installation ##

1. Download this: http://github.com/k1LoW/controller_prefix/zipball/master
2. Unzip that download.
3. Copy the resulting folder to app/Plugin
4. Rename the folder you just copied to ControllerPrefix

## Usage ##

Add the following code in bootstrap.php

    CakePlugin::loadAll();
    // or
    CakePlugin::load('ControllerPrefix');


,and Add the following code in routes.php

    App::import('Lib', 'ControllerPrefix.ControllerPrefixRoute');
    Router::connect('/admin/:controller/:action/*',
                    array('controllerPrefix' => 'admin'), array('routeClass' => 'ControllerPrefixRoute'));

## License ##

under MIT Lisence