# TystrReactJsBundle
[![Build Status](https://travis-ci.org/tystr/TystrReactJsBundle.svg?branch=master)](https://travis-ci.org/tystr/TystrReactJsBundle)
[![Code Climate](https://codeclimate.com/github/tystr/TystrReactJsBundle/badges/gpa.svg)](https://codeclimate.com/github/tystr/TystrReactJsBundle)
[![Test Coverage](https://codeclimate.com/github/tystr/TystrReactJsBundle/badges/coverage.svg)](https://codeclimate.com/github/tystr/TystrReactJsBundle/coverage)

A bundle for integrating [React][0] into [Symfony][1]. Provides server-side
rendering via the [v8js PHP extension][2] for building isomorphic applications.

[0]: https://facebook.github.io/react/index.html
[1]: https://symfony.com
[2]: http://php.net/v8js


# Installation

Install `tystr/react-js-bundle` with composer:

    # composer.phar require tystr/react-js-bundle:dev-master:~0.1
    
# Configuration

Register the bundle with your application:

```PHP
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tystr\ReactJsBundle\TystrReactJsBundle(),
        // ...
    );
}
```

Configure the paths to your react.js and components javascript files:

```YAML
# app/config.yml

tystr_react_js:
    react_path: path/to/react.js
    components_path: path/to/components.js
```

By default, the [v8js PHP extension][2] is used to render the react components.
If you would prefer to use an external server to render the react components,
you may configure an external rendering method:

```YAML
# app/config.yml

tystr_react_js:
    react_path: path/to/react.js
    components_path: path/to/components.js
    render_method: external
    render_url: http://localhost:3000
```

This will cause a `GET` request to be made to the `render_url` value with the
component and data (`{name: Tyler}` in this case) in the url as query parameters:

    GET http://localhost:3000?component=MyComponent&data=%7B%22name%22%3A%22Tyler%22%7D


# Usage

```twig
{{ react_component('MyComponent', 'my-component') }}

```

This will render the react component `MyComponent` on the server-side and place
it inside a div with the id `my-component`.

To pass data to a component, pass a hash as the third argument:

```twig
{{ react_component('MyComponent', 'my-component', {'name': 'Tyler'}) }}
```
This makes `this.props.name` available in `MyComponent`.

To mount all components rendered server-side with the `react_component`
function, use the `react_mount_components` twig function:

```twig
<script>
    {{ react_mount_components() }}
</script>
```

To mount a single react component (as long as it's already rendered with
`react_component`), use the `react_mount_component` function:

```twig
<script>
    {{ react_mount_component('MyComponent') }}
</script>
```
Attempting to mount a component whose markup has not been rendered will result
in an exception `Tystr\ReactJsBundle\Exception\ComponentNotRenderedException`.
