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
        $(config.closeBtnSelector).on('click', function() {
            $(element).fadeOut(300);

            $.ajax({
                url: config.closeNotificationUrl,
                dataType: 'json',
                type: 'GET'
            });
        });
    }
});
