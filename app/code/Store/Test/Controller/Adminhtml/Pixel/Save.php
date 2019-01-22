<?php
/**
 * Save
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */
namespace Store\Test\Controller\Adminhtml\Pixel;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Store\Test\Model\Pixel\Attribute\Backend\ImageFactory;
use Store\Test\Model\PixelFactory;

class Save extends Action
{
    /** @var PixelFactory $objectFactory */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param PixelFactory $objectFactory
     */
    public function __construct(
        Context $context,
        PixelFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Store_Test::pixel');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $storeId = (int)$this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getParams();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            $objectInstance->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            } else {
                $objectInstance->load($data['entity_id']);
                $params['entity_id'] = $data['entity_id'];
            }
            $imageData = $this->preparedImagesData($data);
            $data = array_merge($data, $imageData);
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                'store_test_pixel_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {
                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['entity_id'] = $objectInstance->getId();
                    $params['_current'] = true;
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function preparedImagesData(array $data): array
    {
        $imagesData = [];
        $imageAttributeCodes = array_keys(ImageFactory::IMAGE_ATTRIBUTE_CODES);
        foreach ($imageAttributeCodes as $imageAttrCode) {
            if (empty($data[$imageAttrCode])) {
                $imagesData[$imageAttrCode]['delete'] = true;
            }
        }
        return $imagesData;
    }

}
