# Laravel EasyCollector

EasyCollector is a package for Laravel for making collectors like Laravel Resources.

## Installation

Use composer to install

```bash
composer require denysovvl/easy-collector
```

## Creating Collector

Create Collector:

```bash
php artisan make:collector MyAwesomeCollector
```
This command will create Collector class in **App/Collectors** directory:

```php
<?php

namespace App\Collectors;

use Denysovvl\EasyCollector\BaseCollector;

class MyAwesomeCollector extends BaseCollector
{
    /**
     * @param $element
     * @return array
     */
    public function collect($element)
    {
        return [
            //TODO: define your data here
        ];
    }
}

```
## Usage

Available methods

```php
# returns array
MyAwesomeCollector::toArray($arrayOrObjectOrCollection);

# returns Collection
MyAwesomeCollector::toCollection($arrayOrObjectOrCollection);

# returns object
MyAwesomeCollector::toObject($arrayOrObjectOrCollection);

```

## Examples

There are few examples to use:

Define **collect($element)** method

```php

    public function collect($element)
    {
        return [
            'some_key' => $element->name,
            'another_key' => $element->age,
            'role' => 'human'
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

```

Somewhere in your controllers or services:

```php

    public function myFunction()
    {
        $users = User::all();

        $collector = MyAwesomeCollector::toArray($users);
    }

```

In **$collector** you will see something like this:

```php
[
    [
        'some_key' => John Connor,
        'another_key' => 35,
        'role' => 'human'
        'created_at' => "2020-10-10 10:10:00",
        'updated_at' => "2020-10-10 10:10:00"
    ],
    [
        'some_key' => Sarah Connor,
        'another_key' => 55,
        'role' => 'human'
        'created_at' => "2020-10-10 10:10:00",
        'updated_at' => "2020-10-10 10:10:00"
    ],
    ...
]

```

Or you can use your arrays as parameters:

```php

    public function myFunction()
    {
        $users = [
            [
                'name' => 'Lua',
                'age'  => 28,
                ...
            ],
            [
                'name' => 'Mark',
                'age'  => 70,
                ...
            ],
            ...
        ];

        $collector = MyAwesomeCollector::toArray($users);
    }

```
EasyCollector is a convenient way to mass insert to model 

```php

    public function myFunction()
    {
        $users = ...

        $collector = MyAwesomeCollector::toArray($users);
        
        AnotherModel::insert($collector);
    }

```