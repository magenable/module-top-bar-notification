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
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Notification implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Json
     */
    private $jsonHelper;

    /**
     * Notification constructor.
     *
     * @param ScopeConfigInterface    $scopeConfig
     * @param Json                    $jsonHelper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Json $jsonHelper
    ) {
        $this->scopeConfig    = $scopeConfig;
        $this->jsonHelper     = $jsonHelper;
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
     * @return string
     */
    public function getConfigData(): string
    {
        return $this->jsonHelper->serialize([
            'notification' => [
                'closeBtnSelector' => '#notification-close-btn',
                'includePages' => $this->getIncludePages(),
                'excludePages' => $this->getExcludePages()
            ]
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
}
