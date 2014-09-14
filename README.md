HandlerSocketBundle
===================

Bundle allows you to use HandlerSocket inside your Symfony2 project.

Installation
===================
- add to composer.json row `"konstantin-kuklin/handlersocket-bundle": "dev-master"`

- add to AppKernel.php row `new KonstantinKuklin\HandlerSocketBundle\HandlerSocketBundle()`

- add to your config file:

```
hs:
    reader:
        host: localhost
        port: 9998
        debug: "%kernel.debug%"
        auth_key: "Password_Read1"

    writer:
        host: localhost
        port: 9999
        debug: "%kernel.debug%"
```

How to use
===================

Now HS Reader and Writer are available from Symfony DI
```php
/** @var \HS\Reader $reader */
$reader = $this->get("hs_reader");

/** @var \HS\Writer $writer */
$writer = $this->get("hs_writer");
```

About queries and more detailed HandlerSocket information you can read on (https://github.com/KonstantinKuklin/HandlerSocketLibrary).

How to Debug
===================
Also HS debug information is available on symfony web console

![Symfony2 web console](https://pp.vk.me/c622717/v622717353/201f/wO6SGH2icWA.jpg)

![HS on profile](https://pp.vk.me/c622717/v622717353/2031/LcoEQhNIRf4.jpg)

![HS Detailed](https://pp.vk.me/c622717/v622717353/2028/5CsaNgEjNcA.jpg)
