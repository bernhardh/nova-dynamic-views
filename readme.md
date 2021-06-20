# Nova dynamic views

This package is ment to be used **INSTEAD** of overwriting the `custom-index-header`, `custom-index-toolbar`, `custom-detail-header`, `custom-detail-toolbar`, etc. by yourself. It provides a much easier api for it and it allows you to use these "placeholder" components multiple times without overwriting each other.

![2020-10-14_16-13](https://user-images.githubusercontent.com/642292/96001510-6592a980-0e38-11eb-9aea-54ebbf6126d1.png)

## Installation

Just add it with composer

```
composer require bernhardh/nova-dynamic-views
```

and register the tool in the `tools` method in your `\App\Providers\NovaServiceProvider`:

```php 
use Bernhardh\NovaDynamicViews\NovaDynamicViews;

...

public function tools() {
    return [
        new NovaDynamicViews()
    ];
}
```

## Usage

Let's say you want to add a custom button to the `toolbar` of all `index` views. Just create a vue component for it, as you would do if you use the `custom-index-header` (see section "Create custom component" if you don't know how to). Let's call it `my-index-toolbar-btn`. Now the only thing you have to do is register it to your `\App\Ņova\Resource` class, within a new method called `customIndexToolbarComponents`, which returns a `\Bernhardh\NovaDynamicViews\CustomComponents` object:

```php
public function customIndexToolbarComponents()
{
    return CustomComponents::make()
       ->addItem('my-index-toolbar-btn');
}
```

Thats it. Now you should see the content of your component in the toolbar.

### Provide extra data

If you want to add extra data (for example a label) to your component (without extra request), just add it to the `addItem` method as second parameter (as array):

```php
public function customIndexToolbarComponents()
{
    return CustomComponents::make()
       ->addItem('my-index-toolbar-btn', [
           'label' => 'My label'
       ]); 
}
```

### Access resource data

You have access to the ressource class in all methods by using `$this`. On `detail` and `edit` components, you have access to the ID of the current model with `request('id')`. So if you need the model itself in your `customDetailhHeaderComponents`, `customDetailToolbarComponents` or your `customUpdateHeaderComponents`, you can query for it like so:

```php
public function customDetailToolbarComponents() 
{
    $model = $this->model()->query()->where('id', request('id'))->first();

    //...
}
```

### Add (tailwind) class to the container

If you want to add additional css classes to the container div of a section (for example add `flex w-full justify-end items-center mx-3` to the `customIndexToolbarComponents` section), add the `class` in the `make` function (or use the `setClass` method):

```php
public function customIndexToolbarComponents()
{
    return CustomComponents::make('flex w-full justify-end items-center mx-3')
       ->addItem('my-index-toolbar-btn'); 
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
        return CustomComponents::make('flex w-full justify-end items-center mx-3')
            ->addItem('my-index-toolbar-btn', [
                'title' => 'My first btn'
            ])
            ->addItem('my-index-toolbar-btn', [
                'title' => 'My second btn'
            ]);
    }

    /**
     * Using the `custom-detail-header` placeholder component
     * 
     * @return array[]
     */
    public function customDetailHeaderComponents()
    {
        $model = $this->model()->query()->where('id', request('id'))->first();
        
        return CustomComponents::make()
           ->addItem('my-other-component', [
                'id' => $model->id,
                'name' => $model->name    
           ]);
    }
}
```


### Use only on specific resources

If you wanna show this button only on a specific resource, for example only for Users, just add this method to the `\App\Nova\User` class. 

## Available methods and areas

All `custom-*-*` nova placeholders (except `custom-dashboard-header`) are available as camel case methods postfixed with `Components`:

- `customAttachHeaderComponents`
- `customCreateHeaderComponents`
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


