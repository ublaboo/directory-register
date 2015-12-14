DirectoryRegister
=================

Register extension in config.neon:

    extensions:
        autoRegister: Ublaboo\DirectoryRegister\DI\AutoRegisterExtension

With this extension, all classes within specified directories will be automatically registered in DIC. E.g.:

    autoRegister:
        dirs: [
            App\Forms: %appDir%/Forms,
            App\ORM\Repository: %appDir%/ORM/Repository
        ]

        skip: [App\Forms\ContactFormFactory]

Always you have to specify namespace for classes in partucular directory. Let's take following directorystructure as an example:

    app/
        Forms/
            ContactFormFactory.php
            ProductFormFactory.php
            SignInFormFactory.php
            FooFormFactory.php
            BarFormFactory.php
            BazFormFactory.php

See, now above configuration will be the same as writing all these lines in `config.neon`:

    services:
        - App\Forms\ProductFormFactory
        - App\Forms\SignInFormFactory
        - App\Forms\FooFormFactory
        - App\Forms\BarFormFactory
        - App\Forms\BazFormFactory
    
