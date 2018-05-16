# Ignition

Basic framework for expanding WordPress functionalities

## Table of Contents
    [Getting Started](#getting-started)
    [Prerequisites](#prerequisites)
    [Installation](#installation)
    [Usage](#usage)
    [Authors](#authors)
    [License](#license)


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Make sure you have composer installed and composer is configured

```
composer init
```

### Installation


```
composer install kylwes/ignition
```


Make sure you require the composer autoload
```
require(__DIR__ . '/vendor/autoload.php');
```

### Usage

Setup a base for your plugin in wp-content/plugins/{plugin}/{plugin}.php

and make a namespace for your username

```
namespace {author};

use Kylwes/Ignition/Plugin;

/**
 * @wordpress-plugin
 * Plugin Name:       {plugin}
 * Version:           0.0.1
 * Author
 */

 class {plugin} extends Plugin {
     public $plugin_name = {plugin}

     public $version = 0.0.1;

     public $autoload = [];
 }


```

## Authors

* **Kylian Wester** - *Initial work* - [KylWes](https://github.com/KylWes)

See also the list of [contributors](https://github.com/kylwes/ignition/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


