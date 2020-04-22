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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenable\TopBarNotification\Model\Config\Source\ContentType;

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

    public function __construct(
        AuthorizationInterface $authorization,
        ScopeConfigInterface $scopeConfig,
        UrlInterface $url
    ) {
        $this->authorization = $authorization;
        $this->scopeConfig   = $scopeConfig;
        $this->url           = $url;
    }

    public function isAllowed(): bool
    {
        if ($this->scopeConfig->isSetFlag('topbar_notification/general/enabled') === false) {
            return false;
        }

        $urlPath = parse_url($this->url->getCurrentUrl(), PHP_URL_PATH);

        return $this->checkIsPageAllowed($urlPath);
    }

    public function isTextNotification(): bool
    {
        return (int)$this->getConfigValue('design', 'content_type') === ContentType::TEXT;
    }

    public function getHtmlContent(): string
    {
        return $this->getConfigValue('design', 'html_content') ?? '';
    }

    public function getText(): string
    {
        return $this->getConfigValue('design', 'text') ?? '';
    }

    public function getFontSize(): string
    {
        $value = 'auto';
        $confValue = (string)$this->getConfigValue('design', 'font_size');
        if (null !== $confValue) {
            $value = $confValue . 'px';
        }

        return $value;
    }

    public function getBackgroundColor(): string
    {
        return $this->getConfigValue('design', 'bg_color') ?? 'auto';
    }

    public function getTextColor(): string
    {
        return $this->getConfigValue('design', 'text_color') ?? 'auto';
    }

    private function getConfigValue(string $group, string $field)
    {
        $path = "topbar_notification/$group/$field";

        return $this->scopeConfig->getValue($path);
    }

    private function checkIsPageAllowed($url)
    {
        $includePagesConf = $this->getConfigValue('pages_to_show', 'include_pages_with_url');
        if ($includePagesConf !== null) {
            $arrayPages       = explode(PHP_EOL, $includePagesConf);
            $includePagesConf = array_map('trim', $arrayPages);
            if (count($includePagesConf) !== 0) {
                return in_array($url, $includePagesConf, true);
            }
        }

        $excludePagesConf = $this->getConfigValue('pages_to_show', 'exclude_pages_with_url');
        if ($includePagesConf !== null) {
            $arrayPages   = explode(PHP_EOL, $excludePagesConf);
            $excludePages = array_map('trim', $arrayPages);

            if (count($excludePages) !== 0) {
                return !in_array($url, $excludePages, true);
            }
        }

        return true;
    }
}
