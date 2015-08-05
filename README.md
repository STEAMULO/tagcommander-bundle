TagCommander Bundle
===================

## Installation

Install the package with Composer :

```
composer require 1001pharmacies/tagcommander-bundle
```

Update `app/AppKernel.php` :

```php
$bundles = array(
    // ...
    new Meup\Bundle\TagcommanderBundle\MeupTagcommanderBundle(),
);
```

Setup your `app/config/config.yml`

```yaml
meup_tagcommander:
    default_event: "default"
    datalayer:
        name:    "tc_vars"
        default: { env: "%kernel.environment%", locale: "%locale%" }
    containers:
        - { name: "ab-test", script: "my-ab-test-container.js" }
        - { name: "generic", script: "my-generic-container.js", version: "v17.11", alternative: "//redirect1578.tagcommander.com/utils/noscript.php?id=3&amp;mode=iframe" }
    events:
        - { name: "default",      function: "tc_events_1" }
        - { name: "other_events", function: "tc_events_2" }
```

Then update your pages to track events :

```html
<html>
  <head>
    {% block head_javascript %}
    {{ tc_vars({ 'route': app.request.attributes.get('_route') }) }}
    {{ tc_container("ab-test") }}
    {% endblock %}
  </head>
  <body>
    <!-- simple tracking sample -->
    <a href="#" onclick="javascript: return {{ tc_event('lorem_click'}) }}">lorem ipsum</a>
    <!-- advanced tracking sample -->
    <img src="sample.jpg" onmouseover="javascript: return {{ tc_event('over_image', {'src': 'sample.jpg'}, 'other_events') }}">
    <!-- rendering tag commander containers -->
    {% block body_javascript %}
    {{ tc_container("generic") }}
    {% endblock %}
  </body>
</html>
```