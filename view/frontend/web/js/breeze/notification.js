(function () {
    'use strict';

    function init(config, element) {
        if (!checkUrl(config.includePages, config.excludePages)) {
            return false;
        }
        if (!$.mage.cookies.get('top_bar_notification_closed')) {
            $(element).removeClass('hidden');
        }
        $(config.closeBtnSelector).on('click', function() {
            $(element).fadeOut(300);
            $.mage.cookies.set('top_bar_notification_closed', true);
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

    $(document).on('breeze:mount:notification', (e, data) => {
        init(data.settings, data.el)
    })
})();
