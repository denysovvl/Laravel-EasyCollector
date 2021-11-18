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
     * @param mixed $args 
     * @return array
     */
    public function collect($element, $args)
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
MyAwesomeCollector::toArray($data);

# returns Collection
MyAwesomeCollector::toCollection($data);

# returns object
MyAwesomeCollector::toObject($data);

```

## Examples

There are few examples to use:

Define ```collect()``` method in your Collector class

```php

    public function collect($element, $args)
    {
        return [
            'some_key' => $element->name,
            'another_key' => $element->age,
            'role' => 'human',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

```

Somewhere in your controllers or services:

```php

    public function myMethod()
    {
        $users = User::all();

        $collector = MyAwesomeCollector::toArray($users);
    }

```

In ```$collector``` you will see something like this:

```php
[
    [
        'some_key' => John Connor,
        'another_key' => 35,
        'role' => 'human',
        'created_at' => '2020-10-10 10:10:00',
        'updated_at' => '2020-10-10 10:10:00'
    ],
    [
        'some_key' => Sarah Connor,
        'another_key' => 55,
        'role' => 'human',
        'created_at' => '2020-10-10 10:10:00',
        'updated_at' => '2020-10-10 10:10:00'
    ],
    ...
]

```

Or you can use your arrays as parameters:

```php

    public function myMethod()
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

Also, you can pass additional values

```php

    public function myMethod()
    {
        $users = User::all();
        
        $role = 'human';
        
        $collector = MyAwesomeCollector::toArray($users, compact('role'));
    }

```
These values will be available through ```$args``` parameter

```php

    public function collect($element, $args)
    {
        return [
            'some_key' => $element->name,
            'another_key' => $element->age,
            'role' => $args->role
            'default_value' = $args->qwerty
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

```

If you use non-existent property such as ```$args->qwerty``` you will get ```null``` as value for ```default_value``` key,
but you can change this behavior with ```defaultArgsValue()``` method:

```php

class MyAwesomeCollector extends BaseCollector
{
    public function collect($element, $args)
    {
        return [
            'some_key' => $element->name,
            'another_key' => $element->age,
            'role' => $args->role
            'default_value' = $args->qwerty
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
    
    public function defaultArgsValue()
    {
        return 'empty :(';
    }

}

```

And you will get

```php
[
    [
        'some_key' => John Connor,
        'another_key' => 35,
        'role' => 'human'
        'default_value' => 'empty :(',
        'created_at' => '2020-10-10 10:10:00',
        'updated_at' => '2020-10-10 10:10:00'
    ],
    [
        'some_key' => Sarah Connor,
        'another_key' => 55,
        'role' => 'human',
        'default_value' => 'empty :(',
        'created_at' => '2020-10-10 10:10:00',
        'updated_at' => '2020-10-10 10:10:00'
    ],
    ...
]

```


By the way, EasyCollector is a convenient way to mass insert to model 

```php

    public function myMethod()
    {
        $users = User::all();
       
        AnotherModel::insert(MyAwesomeCollector::toArray($users));
    }

```