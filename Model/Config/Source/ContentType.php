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
    const HTML = 1;
    const TEXT = 2;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::HTML, 'label' => __('HTML')],
            ['value' => self::TEXT, 'label' => __('Text')],
        ];
    }
}
