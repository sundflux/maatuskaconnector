maatuska connector for webvaloa
========

Magento 2 integration project for Webvaloa.

Warning! Early stages of development. Rude installation. Dirty results!

Getting started
---------------

### The setup

Checkout the repository:
```bash
git clone https://github.com/sundflux/maatuskaconnector.git
```

Add this repository path to your `config/config.php` file to LIBVALOA_EXTENSIONSPATH
```php
DEFINE('LIBVALOA_EXTENSIONSPATH', '<your repository path>');
```

Install the component and plugins from the backend: Extensions > Install.

Add the Magento 2 web api endpoint + user credentials from 
Extensions > Components > Mconnector > Settings

After installation remember to assign the Mconnector controller to
some role group. Add it for public role to enable public product listings.

### Misc
License: [The MIT License (MIT)](LICENSE)

[Contributors](CONTRIBUTORS.md)
