# Phpshots ViewModel Package

Phpshots ViewModel is a powerful PHP package that provides a structured approach to building view models for your web applications. It allows you to separate the presentation logic from your business logic, resulting in clean and maintainable code.

## Features

- **ViewModel Abstraction**: The package provides a base `ViewModel` class that can be extended to create custom view models. It encapsulates the data required for rendering a view and provides methods for manipulating and rendering the data.

- **Event System**: The package includes an event system that allows you to hook into specific points during the rendering process. You can register event callbacks to modify the view model or perform additional actions before or after rendering.

- **Flexible Templating**: The view models support flexible templating using PHP files. You can set the layout file and content template, and the package handles rendering them together to generate the final HTML output.

- **Data Binding**: The view models support data binding, allowing you to easily pass data to the template. You can set and retrieve data using the `setData()` and `getData()` methods.

- **Extensibility**: The package provides interfaces for customizing the behavior of view models and events. You can create your own view models by extending the base `ViewModel` class and implement custom event classes by extending the `ViewEvent` class.

## Installation

Install the package using Composer:

```shell
composer require phpshots/viewmodel
```

## Usage
1. Create a custom view model by extending the `Phpshots\Viewmodel\ViewModel` class. Implement the `registerEventCallbacks()` method to define your event callbacks.

2. Create a custom event class by extending the `Phpshots\Viewmodel\ViewEvent` class. Implement the `registerCallbacks()` method to define your event callbacks.

3. Set up your view model, event, and template configuration:
```php

```

4. Render the view model:
```php

```

For more details on extending the view model and event classes, refer to the Extending ViewModel and ViewEvent section below.

## Extending ViewModel and ViewEvent

### Extending ViewModel
To create a custom view model, follow these steps:

1. Create a new PHP class and extend the base `Phpshots\Viewmodel\ViewModel` class.

2. Implement the `registerEventCallbacks()` method to define your event callbacks. Inside this method, use the `addEventCallback()` method to register your event callbacks.

3. Customize the view model by adding any additional properties or methods specific to your application.

Here's an example of extending the view model:

```php

```


### Extending ViewEvent


To create a custom event class, follow these steps:

1. Create a new PHP class and extend the base  Phpshots\Viewmodel\ViewEvent class.

2. Implement the registerCallbacks() method to define your event callbacks. Inside this method, populate the $eventCallbacks property with your event callbacks.

Here's an example of extending the event class:

```php

```

# Version

This package is currently at version v0.1.
