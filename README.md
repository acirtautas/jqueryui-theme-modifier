jQuery UI theme modifier for Composer
==========================================

Simple tool to modify jQuery UI theme constants in Composer.

Installation / Usage
--------------------

1. Download the [`composer.phar`](https://getcomposer.org/composer.phar) executable or use the installer.

    ``` sh
    $ curl -sS https://getcomposer.org/installer | php
    ```

2. Create a composer.json defining your dependencies.

    ``` json
    {
        "require": {
            "acirtautas/jqueryui-theme-modifier": "dev-master"
        },
        "config": {
            "jqueryui-theme-dir": "components/jquery-ui/themes/base",
            "jqueryui-theme-modify": {
                "cornerRadius":"6px"
            }
        },
        "scripts": {
            "post-update-cmd": [
                "modifier::modify"
            ],
            "post-install-cmd": [
                "modifier::modify"
            ]
        }
    }
    ```

3. Run Composer: `php composer.phar install`
