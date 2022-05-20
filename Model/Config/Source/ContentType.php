<?php
declare(strict_types=1);

/**
 * Magenable
 *
 * @category    Magenable
 * @package     Magenable_TopBarNotification
 * @copyright   Copyright (c) Magenable (https://magenable.com.au/)
 */

namespace Magenable\TopBarNotification\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ContentType implements OptionSourceInterface
{
    public const HTML = 1;
    public const TEXT = 2;

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::HTML, 'label' => __('HTML')],
            ['value' => self::TEXT, 'label' => __('Text')],
        ];
    }
}
