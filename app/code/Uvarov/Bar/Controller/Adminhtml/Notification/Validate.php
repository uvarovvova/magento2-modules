<?php

namespace Uvarov\Bar\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Validate
 * @package Uvarov\Bar\Controller\Adminhtml\Notification
 */
class Validate extends Action
{
    /** @var JsonFactory $jsonFactory */
    protected $jsonFactory;

    /** @var  \Magento\Framework\DataObject $response */
    protected $response;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->response = new \Magento\Framework\DataObject();
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     */
    public function validateRequireEntries(array $data)
    {
        $requiredFields = [
            'identifier' => __('Notification Identifier'),
        ];
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $this->_addErrorMessage(
                    __('To apply changes you should fill in required "%1" field', $requiredFields[$field])
                );
            }
        }
    }

    /**
     * Add error message validation
     *
     * @param $message
     */
    protected function _addErrorMessage($message)
    {
        $this->response->setError(true);
        if (!is_array($this->response->getMessages())) {
            $this->response->setMessages([]);
        }
        $messages = $this->response->getMessages();
        $messages[] = $message;
        $this->response->setMessages($messages);
    }

	/**
	 * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 */
    public function execute()
    {
        $this->response->setError(0);

        $this->validateRequireEntries($this->getRequest()->getParams());

        $resultJson = $this->jsonFactory->create()->setData($this->response);
        return $resultJson;
    }
}
