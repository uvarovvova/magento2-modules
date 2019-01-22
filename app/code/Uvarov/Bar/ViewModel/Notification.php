<?php

namespace Uvarov\Bar\ViewModel;

use Uvarov\Bar\Model\ResourceModel\Notification\Collection as NotificationCollection;
use Magento\Store\Model\StoreManagerInterface;

class Notification implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
	public function __construct()
	{
		echo 44;exit;
	}
}