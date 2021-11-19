/**
 * Magenable
 *
 * @category    Magenable
 * @package     Magenable_TopBarNotification
 * @copyright   Copyright (c) Magenable (https://magenable.com.au/)
 */
define([
    "jquery",
    "jquery/jquery.cookie"
], function($) {
    "use strict";

    return function(config, element) {
        if (!checkUrl(config.includePages, config.excludePages)) {
            return false;
        }
        if (!$.cookie('top_bar_notification_closed')) {
            $(element).removeClass('hidden');
        }
        $(config.closeBtnSelector).on('click', function() {
            $(element).fadeOut(300);
            $.cookie('top_bar_notification_closed', true);
        });
    }

    function checkUrl(includePages, excludePages) {
        function inArrayCheck(url) {
            return url === document.location.pathname;
        }
        if (includePages) {
            return includePages.split('\r\n').some(inArrayCheck);
        }
        if (excludePages) {
            return !excludePages.split('\r\n').some(inArrayCheck);
        }

        return true;
    }
});
