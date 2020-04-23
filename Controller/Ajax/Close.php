<?php
declare(strict_types=1);

/**
 * Magenable
 *
 * @category    Magenable
 * @package     Magenable_TopBarNotification
 * @copyright   Copyright (c) Magenable (https://magenable.com.au/)
 */

namespace Magenable\TopBarNotification\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Session\SessionManagerInterface;

/**
 * Class Close
 *
 * @package Magenable\TopBarNotification\Cotroller\Ajax
 */
class Close extends Action
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    public function __construct(Context $context, JsonFactory $jsonFactory, SessionManagerInterface $sessionManager)
    {
        $this->jsonFactory    = $jsonFactory;
        $this->sessionManager = $sessionManager;

        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->sessionManager->setNotificationClosed(true);

        $result = $this->jsonFactory->create();
        $result->setData(['result' => true]);

        return $result;
    }
}
