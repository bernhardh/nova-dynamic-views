# Nova dynamic views

This package is ment to be used **INSTEAD** of overwriting the `custom-index-header`, `custom-index-toolbar`, `custom-detail-header`, `custom-detail-toolbar`, etc. by yourself. It provides a much easier api for it and it allows you to use these "place-holder" components multiple times without overwriting each other.

![2020-10-14_16-13](https://user-images.githubusercontent.com/642292/96001510-6592a980-0e38-11eb-9aea-54ebbf6126d1.png)

## Usage

Let's say you want to add a custom button to the `toolbar` of all `index` views. Just create a vue component for it, as you would do if you use the `custom-index-header` (see section "Create custom component" if you don't know how to). Let's call it `my-index-toolbar-btn` Now the only thing you have to do is register it to your `\App\Ņova\Resource` class, within a new method called `customIndexToolbarComponents`:

```php
public function customIndexToolbarComponents()
{
    return [
        'items' => [
            [
                'name' => 'my-index-toolbar-btn',
            ],
        ]
    ];
}
```

Thats it. Now you should see the content of your component in the toolbar.

### Provide extra data

If you want to add extra data (for example a label) to your component (without extra request), just add it to the returned array in the `meta` key:

```php
public function customIndexToolbarComponents()
{
    return [
        'items' => [
            [
                'name' => 'my-index-toolbar-btn',
                'meta' => [
                    'label' => 'My label'
                ]
            ],
        ]
    ];
}
```

### Add (tailwind) class to the container

If you want to add additional css classes to the container div of a section (for example add `flex w-full justify-end items-center mx-3` to the `customIndexToolbarComponents` section), add the `class` key:

```php
public function customIndexToolbarComponents()
{
    return [
        'class' => 'flex w-full justify-end items-center mx-3',
        'items' => [
            ...
        ]
    ];
}
```

### Full usage example

```php
class Resource extends \Laravel\Nova\Resource {
    ...

    /**
     * Using the `custom-index-toolbar` placeholder component
     * 
     * @return array[]
     */
    public function customIndexToolbarComponents()
    {
        return [
            'class' => 'flex w-full justify-end items-center mx-3',
            'items' => [
                [
                    'name' => 'my-index-toolbar-btn',
                    'meta' => [
                        'label' => 'My first btn'
                    ]
                ],
                [
                    'name' => 'my-index-toolbar-btn',
                    'meta' => [
                        'label' => 'My second btn'
                    ]
                ],
            ]
        ];
    }

    /**
     * Using the `custom-detail-header` placeholder component
     * 
     * @return array[]
     */
    public function customDetailHeaderComponents()
    {
        return [
            'items' => [
                [
                    'name' => 'my-other-component'
                ]
            ]
        ];
    }
}
```


### Use only on specific resources

If you wanna show this button only on a specific resource, for example only for Users, just add this method to the `\App\Nova\User` class. 

## Available methods and areas

All `custom-*-*` nova placeholders are available as camel case methods postfixed with `Components`:

- `customAttachHeaderComponents`
- `customCreateHeaderComponents`
- `customDashboardHeaderComponents`
- `customDetailhHeaderComponents`
- `customDetailToolbarComponents`
- `customIndexHeaderComponents`
- `customIndexToolbarComponents`
- `customLensHeaderComponents`
- `customUpdateAttachHeaderComponents`
- `customUpdateHeaderComponents`

## Create custom component

This is just a kick start documentation for this. For more infos see https://nova.laravel.com/docs/3.0/customization/resource-tools.html

Create a new resource tool with artisan:

```bash
php artisan nova:resource-tool acme/my-index-toolbar-btn
```

and say yes to all questions of the prompt. Now you can use this component (located ad `nova-components/my-index-toolbar-btn`) inside your `customXXXComponents` (f.e. `customIndexToolbarComponents`)


