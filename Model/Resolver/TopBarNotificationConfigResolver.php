<?php
declare(strict_types=1);

namespace Magenable\TopBarNotification\Model\Resolver;

use Magenable\TopBarNotification\ViewModel\Notification;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class TopBarNotificationConfigResolver implements ResolverInterface
{
    /**
     * @var Notification
     */
    private Notification $notification;

    /**
     * TopBarNotificationConfigResolver constructor.
     * @param Notification $notification
     */
    public function __construct(
        Notification $notification
    ) {
        $this->notification = $notification;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): array
    {
        return [
            'enabled' => $this->notification->isEnabled(),
            'is_text' => $this->notification->isTextNotification(),
            'content' => $this->notification->isTextNotification() ?
                $this->notification->getText() : $this->notification->getHtmlContent(),
            'font_size' => $this->notification->isTextNotification() ?
                $this->notification->getFontSize() : '',
            'background_color' => $this->notification->isTextNotification() ?
                $this->notification->getBackgroundColor() : '',
            'text_color' => $this->notification->isTextNotification() ?
                $this->notification->getTextColor() : '',
            'include_urls' => $this->notification->getIncludePages(),
            'exclude_urls' => $this->notification->getExcludePages()
        ];
    }
}
