DeydeDataQBundle (Deyde data quality bundle)
==============

The DeydeDataQBundle adds support for the deyde data quality services. In this version only supports the address normalization service.

Installation
------------
1. Download DeydeDataQBundle
2. Enable the Bundle

### Step 1: Install DeydeDataQBundle with composer

Run the following composer require command:

``` bash
$ php composer.phar require liip/theme-bundle:dev-master

```

### Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Deyde\DataQBundle\DeydeDataQBundle(),
    );
}
```

Configuration
------------

You will have to set your basic configuration to use de deyde services.

### Minimal configuration

``` yaml
# app/config/config.yml
deyde_address_validation:
        deyde_user: test
        deyde_password: password
```

Where desde_user is your deyde user account and deyde_password is your account password. 
> __Note__: deyde_user and deyde_password are the only required configuration params.

### Use behind a proxy
``` yaml
deyde_address_validation:
        deyde_user: test
        deyde_password: password
        proxy:
            address: ip_machine:port
            user: proxy_user
            password: proxy_pass
```
> __Note__: use this configuration when you are behind a proxy.


### Modify the Deyde base url

If Deyde changes their services host there's not problem. It's possible to change this via configuration file.
``` yaml
deyde_address_validation:
        deyde_user: test
        deyde_password: password
        deyde_base_url: https://deyde.es/
```
> __Note__: by default, the url is https://ws.deyde.com.es/


### Modify the address validation service url

If Deyde changes the address validation service url there's not problem. It's possible to change this via configuration file.
``` yaml
_deyde_address_validation:
        deyde_user: test
        deyde_password: password
        address_validation_service_url: deyde-autoCompletion/domicilio-nuevo
```
> __Note__: by default, the url is deyde-autoCompletion/domicilio

### Modify the product_list_parameter
The product list parameter determines what kind of products are selected.

By deafult its value is 'es,dom,cod'. You can change its value via configuration file.
``` yaml
deyde_address_validation:
        deyde_user: test
        deyde_password: password
        product_list_parameter: pt,dom,cod
```
> __Note__: At this moment 'es,dom,cod' and 'pt,dom,cod' values are supported.


Complete Configuration File
------------

Finally we show a complete configuration file, fully overwritten its values.
``` yaml
deyde_address_validation:
        deyde_user: test
        deyde_password: password
        deyde_base_url: https://ws.deyde.com.es/
        address_validation_service_url: deyde-autoCompletion/domicilio
        product_list_parameter: es,dom,cod
        proxy:
            address: ip_machine:port
            user: proxy_user
            password: proxy_pass
```

Use
------------
``` yaml
service = $this->get('deyde_address_validation_service');
$service->validateAddress("Calle mayor 2 2800 madrid");
```
The most commond response is like follows:

```  json
{
  "codigoPoblacion" : "28079000000",
  "codigoPostal" : "28013",
  "codigoVia" : "2807903981",
  "indicadorDyf" : "4",
  "indicadorEstadoCodificacion" : "F",
  "indicadorEstadoFiabilidad" : "7",
  "mujeres" : 1712655,
  "municipio" : "MADRID",
  "nombreVia" : "MAYOR",
  "numeroVia" : "0002",
  "poblacion" : "MADRID",
  "provincia" : "MADRID",
  "restoVia" : "",
  "tipoVia" : "",
  "varones" : 1494592
}
```
> __Note__:In case that Deyde service is down, the bundle throws a ServiceNotAvalaibleException.


Test
------------
Test are under DeydeDataQBundle/test directory.
Launch them is simple, just run the next command from DeydeDataQBundle/test directory:
``` 
phpunit --bootstrap bootstrap.php Deyde/Tests/DeydeAddressValidatorTest
```

