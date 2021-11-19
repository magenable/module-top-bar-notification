<?php
declare(strict_types=1);

/**
 * Magenable
 *
 * @category    Magenable
 * @package     Magenable_TopBarNotification
 * @copyright   Copyright (c) Magenable (https://magenable.com.au/)
 */

namespace Magenable\TopBarNotification\ViewModel;

use Magenable\TopBarNotification\Model\Config\Source\ContentType;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Notification
 * @package Magenable\TopBarNotification\ViewModel
 */
class Notification implements ArgumentInterface
{

    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var Json
     */
    private $jsonHelper;

    /**
     * Notification constructor.
     *
     * @param AuthorizationInterface  $authorization
     * @param ScopeConfigInterface    $scopeConfig
     * @param SessionManagerInterface $sessionManager
     * @param UrlInterface            $url
     * @param Json                    $jsonHelper
     */
    public function __construct(
        AuthorizationInterface $authorization,
        ScopeConfigInterface $scopeConfig,
        SessionManagerInterface $sessionManager,
        UrlInterface $url,
        Json $jsonHelper
    ) {
        $this->authorization  = $authorization;
        $this->scopeConfig    = $scopeConfig;
        $this->url            = $url;
        $this->sessionManager = $sessionManager;
        $this->jsonHelper     = $jsonHelper;
    }

    /**
     * Is block render allowed.
     *
     * @return bool
     */
    public function isAllowed(): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        if ($this->sessionManager->getNotificationClosed()) {
            return false;
        }

        $urlPath = parse_url($this->url->getCurrentUrl(), PHP_URL_PATH);

        return $this->checkIsPageAllowed($urlPath);
    }

    /**
     * Is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->getConfigValue('general', 'enabled');
    }

    /**
     * Is text notification.
     *
     * @return bool
     */
    public function isTextNotification(): bool
    {
        return (int)$this->getConfigValue('design', 'content_type') === ContentType::TEXT;
    }

    /**
     * Get html content,
     *
     * @return string
     */
    public function getHtmlContent(): string
    {
        return $this->getConfigValue('design', 'html_content') ?? '';
    }

    /**
     * Get text content.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->getConfigValue('design', 'text') ?? '';
    }

    /**
     * Get font size.
     *
     * @return string
     */
    public function getFontSize(): string
    {
        $value = 'auto';
        $confValue = (string)$this->getConfigValue('design', 'font_size');
        if (null !== $confValue) {
            $value = $confValue . 'px';
        }

        return $value;
    }

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->getConfigValue('design', 'bg_color') ?? 'auto';
    }

    /**
     * Get text color.
     *
     * @return string
     */
    public function getTextColor(): string
    {
        return $this->getConfigValue('design', 'text_color') ?? 'auto';
    }

    /**
     * Get include page(s).
     *
     * @return string|null
     */
    public function getIncludePages(): ?string
    {
        return $this->getConfigValue('pages_to_show', 'include_pages_with_url');
    }

    /**
     * Get exclude page(s).
     *
     * @return string|null
     */
    public function getExcludePages(): ?string
    {
        return $this->getConfigValue('pages_to_show', 'exclude_pages_with_url');
    }

    /**
     * Get config data.
     *
     * @return array
     */
    public function getConfigData(): string
    {
        return $this->jsonHelper->serialize([
            'notification' => [
                'closeNotificationUrl' => $this->url->getUrl('top_bar_notification/ajax/close'),
                'closeBtnSelector'     => '#notification-close-btn',
            ],
        ]);
    }

    /**
     * Get config value
     *
     * @param string $group
     * @param string $field
     *
     * @return mixed
     */
    private function getConfigValue(string $group, string $field)
    {
        $path = "topbar_notification/$group/$field";

        return $this->scopeConfig->getValue($path);
    }

    /**
     * Check is page allowed.
     *
     * @param $url
     *
     * @return bool
     */
    private function checkIsPageAllowed($url)
    {
        $includePagesConf = $this->getIncludePages();
        if ($includePagesConf !== null) {
            $arrayPages       = explode(PHP_EOL, $includePagesConf);
            $includePagesConf = array_map('trim', $arrayPages);
            if (count($includePagesConf) !== 0) {
                return in_array($url, $includePagesConf, true);
            }
        }

        $excludePagesConf = $this->getExcludePages();
        if ($excludePagesConf !== null) {
            $arrayPages   = explode(PHP_EOL, $excludePagesConf);
            $excludePages = array_map('trim', $arrayPages);

            if (count($excludePages) !== 0) {
                return !in_array($url, $excludePages, true);
            }
        }

        return true;
    }
}
