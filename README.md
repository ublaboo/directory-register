[![Latest Stable Version](https://poser.pugx.org/ublaboo/directory-register/v/stable)](https://packagist.org/packages/ublaboo/directory-register)
[![License](https://poser.pugx.org/ublaboo/directory-register/license)](https://packagist.org/packages/ublaboo/directory-register)
[![Total Downloads](https://poser.pugx.org/ublaboo/directory-register/downloads)](https://packagist.org/packages/ublaboo/directory-register)
[![Gitter](https://img.shields.io/gitter/room/nwjs/nw.js.svg)](https://gitter.im/ublaboo/help)

DirectoryRegister
=================

Register extension in config.neon:

```yaml
extensions:
    autoRegister: Ublaboo\DirectoryRegister\DI\AutoRegisterExtension
```

With this extension, all classes within specified directories will be automatically registered in DIC. E.g.:

```yaml
autoRegister:
    dirs: [
        App\Forms: %appDir%/Forms,
        App\ORM\Repository: %appDir%/ORM/Repository
    ]

    skip: [App\Forms\ContactFormFactory]
```

Always you have to specify namespace for classes in partucular directory. Let's take following directorystructure as an example:

```
app/
    Forms/
        ContactFormFactory.php
        ProductFormFactory.php
        SignInFormFactory.php
        FooFormFactory.php
        BarFormFactory.php
        BazFormFactory.php
```

See, now above configuration will be the same as writing all these lines in `config.neon`:

```yaml
services:
    - App\Forms\ProductFormFactory
    - App\Forms\SignInFormFactory
    - App\Forms\FooFormFactory
    - App\Forms\BarFormFactory
    - App\Forms\BazFormFactory
```    

## PSR

This extension is simple and fast, but only works with projects that stick to PSR-0 or PSR-4. So you have to have all automatically registered classes named same as the file is and neither of your files can contain other classes.
