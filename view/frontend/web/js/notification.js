/**
 * Magenable
 *
 * @category    Magenable
 * @package     Magenable_TopBarNotification
 * @copyright   Copyright (c) Magenable (https://magenable.com.au/)
 */
define([
    "jquery"
], function($) {
    "use strict";

    return function(config, element) {
        $(config.closeButtonSelector).on('click', function() {
            $(element).fadeOut(300);
        });
    }
});
