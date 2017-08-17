# XM\Doctrine Entity Repository

A different way of creating Doctrine Repositories based on [this article](https://blog.fervo.se/blog/2017/07/06/doctrine-repositories-autowiring/) by Magnus Nordlander. The main difference is that these can be autowired by Symfony. We've also found them easier to test.

Repositories extending this class should not be referenced by the `repositoryClass` entity mapping. But the repository can be used in the same way as "normal" [Doctrine Entity Repositories](https://symfony.com/doc/current/doctrine/repository.html).

## Installation

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require xm\doctrine-entity-repository
```

This command requires [Composer](https://getcomposer.org/download/).

## Usage

```php
<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use XM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * The entity class name that the repository is for.
     * Required. 
     */
    protected $class = User::class;
    
    // ... custom methods
}
```