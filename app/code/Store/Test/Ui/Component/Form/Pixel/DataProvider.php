<?php
/**
 * DataProvider
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */
namespace Store\Test\Ui\Component\Form\Pixel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Store\Test\Model\Pixel;
use Store\Test\Model\Pixel\Attribute\Backend\ImageFactory;
use Store\Test\Model\ResourceModel\Pixel\Collection;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    
    /**
     * @var FilterPool
     */
    protected $filterPool;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $collection
     * @param FilterPool $filterPool
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
        $this->request = $request;
    }

	/**
	 * @return array
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
    public function getData()
    {
        if (!$this->loadedData) {
            $storeId = (int)$this->request->getParam('store');
            $pixel = $this->collection
                ->setStoreId($storeId)
                ->addAttributeToSelect('*')
                ->getFirstItem();
            $pixel->setStoreId($storeId);
            $pixel->addData($this->pixelImagesData($pixel));
            $this->loadedData[$pixel->getId()] = $pixel->getData();
        }
        return $this->loadedData;
    }

    private function pixelImagesData(Pixel $pixel): array
    {
        $imagesData = [];
        $imageAttributeCodes = array_keys(ImageFactory::IMAGE_ATTRIBUTE_CODES);
        foreach ($imageAttributeCodes as $imageAttrCode) {
            if ($pixel->getData($imageAttrCode)) {
                $imagesData[$imageAttrCode] = $pixel->getImageValueForForm($imageAttrCode);
            }
        }
        return $imagesData;
    }
}
