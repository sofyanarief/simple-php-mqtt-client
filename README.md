
# Simple PHP MQTT Client App

This PHP-Based App are used for storing topic's messages that recieved from MQTT Server to SQLite database. You can customize server's parameter, topics to subscribed and etc. on mqtt-server-config.php file inside common/mqtt-client directory. You can start this app by executing mqtt-client-subs.php on terminal and send it to running in the background. Or if you prefer to create this app in docker container, you can look it in [my another github repo](https://github.com/sofyanarief/simple-php-mqtt-client-docker).

## Requirement

- PHP >= 7.4
- PHP [Composer](https://getcomposer.org/) (for installing required library)
- PHP-SQLite plugin/addon
- Library [php-mqtt/client](https://github.com/php-mqtt/client) (prefer install it using composer)

## Installation

 1. Clone this repo to your prefered app directory.
 2. Run composer require php-mqtt/client inside your app directory.
 3. Run composer install inside your app directory.
 4. Edit mqtt-server-config.php in common/mqtt-client directory to meet your setting.
 5. Run mqtt-client-subs.php from common/mqtt-client directory in your terminal and send it to background (you can forward the output to /dev/null or your prefered log file).
 6. Now you can browse saved MQTT topic's messages by querying SQLite file from another your apps.