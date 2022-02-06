# Magenable_TopBarNotification

**Top Bar Notification** is a Magento 2 extension to display a banner/notice at the top of Magento store pages, before all other content.

**The extension was developed as a quick way to display COVID-19 notice, but can be used for other notices as well**

## PWA Studio
The extension for Magento PWA Studio you can find here: https://www.npmjs.com/package/@magenable/top-bar-notification

## Final result

![magenable_top_bar_notification_result](https://user-images.githubusercontent.com/22763909/79934790-613f9200-848e-11ea-8eb8-4e2a9d85cc6e.png)

## Installation

### Composer

Run the following command in Magento 2 root folder

```
composer require magenable/module-top-bar-notification
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```
## User Guide

### Configuration

Go to **Stores** > **Settings** > **Configuration** > **Magenable Extensions** > **Top Bar Notification**.

*General Settings*

![magenable_top_bar_notification_general](https://user-images.githubusercontent.com/22763909/79934990-c4c9bf80-848e-11ea-8500-5918bf001cb7.png)
Set *Enabled* to 'YES'.

*Design Settings*

For HTML content
![magenable_top_bar_html_content](https://user-images.githubusercontent.com/22763909/79935583-3d7d4b80-8490-11ea-9c29-78177c002c01.png)
1. You have to set *Content Type* to 'HTML'
2. Insert the html-content to display to users

For text content
![magenable_top_bar_text_content](https://user-images.githubusercontent.com/22763909/79935614-5c7bdd80-8490-11ea-9329-023c41caa0c0.png)
1. You have to set *Content Type* to 'text'
2. Insert the text to display to users
3. Insert font size
4. Insert an exadecimal value to set the color of *Background color*
5. Insert an exadecimal value to set the color of *Text color*

*Pages to show/hide* (optionally)
![magenable_top_bar_text_content](https://user-images.githubusercontent.com/22763909/79935677-75848e80-8490-11ea-9260-913a6d3cfd91.png)
Insert page(s) to show/hide this notification

# Compatibility

Tested with Magento Open Source 2.3.2-2.3.4, but will probably work with older Magento 2.X versions and Magento Commerce

# About developer

The extension is developed by Magenable (https://magenable.com.au), eCommerce consultancy specializing in Magento based in Melbourne, Australia
