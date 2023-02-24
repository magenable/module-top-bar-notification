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
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

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
     * @var Escaper
     */
    private $escaper;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Json $jsonHelper,
        Escaper $escaper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->jsonHelper = $jsonHelper;
        $this->escaper = $escaper;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->getConfigValue('general', 'enabled');
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

    public function getIncludePages(): ?string
    {
        return $this->getConfigValue('pages_to_show', 'include_pages_with_url');
    }

    public function getExcludePages(): ?string
    {
        return $this->getConfigValue('pages_to_show', 'exclude_pages_with_url');
    }

    public function getConfigData(): string
    {
        return $this->jsonHelper->serialize([
            'notification' => [
                'closeBtnSelector' => '#tbn-close-btn',
                'includePages' => $this->getIncludePages(),
                'excludePages' => $this->getExcludePages()
            ]
        ]);
    }

    public function getEscaper(): Escaper
    {
        return $this->escaper;
    }

    /**
     * Get config value
     *
     * @param string $group
     * @param string $field
     * @param string $scope
     * @return mixed
     */
    private function getConfigValue(
        string $group,
        string $field,
        string $scope = ScopeInterface::SCOPE_STORE
    ) {
        $path = "topbar_notification/$group/$field";

        return $this->scopeConfig->getValue($path, $scope);
    }
}
