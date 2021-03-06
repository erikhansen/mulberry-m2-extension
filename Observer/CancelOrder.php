<?php
/**
 * @category Mulberry
 * @package Mulberry\Warranty
 * @author Mulberry <support@getmulberry.com>
 * @copyright Copyright (c) 2019 Mulberry Technology Inc., Ltd (http://www.getmulberry.com)
 * @license http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Mulberry\Warranty\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Mulberry\Warranty\Api\Config\HelperInterface;
use Mulberry\Warranty\Api\Rest\CancelOrderServiceInterface;

class CancelOrder implements ObserverInterface
{
    /**
     * @var HelperInterface $configHelper
     */
    private $configHelper;

    /**
     * @var CancelOrderServiceInterface $orderCancelService
     */
    private $orderCancelService;

    /**
     * SendOrder constructor.
     *
     * @param HelperInterface $configHelper
     * @param CancelOrderServiceInterface $orderCancelService
     */
    public function __construct(HelperInterface $configHelper, CancelOrderServiceInterface $orderCancelService)
    {
        $this->configHelper = $configHelper;
        $this->orderCancelService = $orderCancelService;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /**
         * @var Order $order
         */
        $order = $observer->getEvent()->getOrder();

        if ($this->configHelper->isActive()) {
            $this->orderCancelService->cancelOrder($order);
        }
    }
}
