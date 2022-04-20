# seat-buyback
[![Latest Stable Version](http://img.shields.io/packagist/v/wipeoutinc/seat-buyback.svg?style=flat-square)]()
![](https://img.shields.io/badge/SeAT-4.0.x-blueviolet?style=flat-square)
![](https://img.shields.io/github/license/WipeOut-Inc/seat-buyback?style=flat-square)

A module for [SeAT](https://github.com/eveseat/seat) that makes your life with corporation buyback programs a lot easier.

In case of problems please contact me via EVE-Online message or over the seat discord: `H4zz4rd`

## Development state is at 95%
> :warning: Please **DO NOT** install this plugin until it has reached 100%!
## Screenshots
![adminpanel](https://i.imgur.com/3u1bkLv.png)

![requestpanel](https://i.imgur.com/j1PhdrF.png)


## Permissions
There are three different types of permissions you can give to your members:

#### Request
This is the default right a corp mate needs to access the buyback module. This permission includes the "Request" and "My Contracts" section.
#### Contract
This permission is for all corp mates that are allowed to manage the corp buyback requests / contracts. 
#### Admin
This permission gives access to the admin section. Here you can adjust some general plugin settings and configure the buyback item settings.

## Usage
* First you need to set up some items over the admin section you want to buy with your corporation. Items that are not added over the admin section are automatically ignored.
* A player can now copy the items with ( CTRL + A ) out of the EVE inventory and paste them with ( CTRL + V ) into the request form field. After pressing on "Send" the plugin will get the current prices from Jita to calculate the ISK the player gets for each item. A list of all items will be shown under step 2.
* If everything is fine and correct he can create a contract with the data shown under step 3 in EVE and confirm this with a final click on the "Confirm" button.
> :warning: The buyback will only be saved with the click on "Confirm". Created contracts in EVE can not be seen by the plugin.

> :warning: Each item price is cached and only refreshed by default every hour. You can change the cache time over the admin section. Please **do not** set this value too low because this would spam the evemarketer api and your server could get banned for a while. 

## Quick Installation Guide:
I can also recommend reading through the [official seat documentation](https://eveseat.github.io/docs/community_packages/).
### Install
Switch to your seat installation directory ( default : /var/www/seat)

```shell
sudo -H -u www-data bash -c 'php artisan down'
sudo -H -u www-data bash -c 'composer require wipeoutinc/seat-buyback'
sudo -H -u www-data bash -c 'php artisan vendor:publish --force --all'
sudo -H -u www-data bash -c 'php artisan migrate'
sudo -H -u www-data bash -c 'php artisan seat:cache:clear'
sudo -H -u www-data bash -c 'php artisan config:cache'
sudo -H -u www-data bash -c 'php artisan route:cache'
sudo -H -u www-data bash -c 'php artisan up'
```
*Note that `www-data` is the default ubuntu webserver user. If you are running on a different distribution please adjust the user.
### Docker Install
Open your .env file and edit the SEAT_PLUGINS variable to include the package.
```
# SeAT Plugins
SEAT_PLUGINS=wipeoutinc/seat-buyback
```
After adding the plugin to your .env file run:
```
docker-compose up -d
```
The plugin should be installed after docker has finished booting.
## Donations
Donations are always welcome, although not required. If you end up using this module a lot, I'd appreciate a donation.
You can give ISK or contract PLEX and Ships to `H4zz4rd`.



