<?php
/**
 * ImageFactory
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */

namespace Store\Test\Model\Pixel\Attribute\Backend;

use InvalidArgumentException;
use Magento\Framework\ObjectManagerInterface;

class ImageFactory
{
    const IMAGE_ATTRIBUTE_CODES = [
        Pixelimage::ATTRIBUTE_CODE => Pixelimage::class,
    ];

    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create corresponding class instance
     *
     * @param $imageAttributeCode
     * @param array $data
     * @return ObjectType
     */
    public function create(string $imageAttributeCode, array $data = [])
    {
        if (empty(self::IMAGE_ATTRIBUTE_CODES[$imageAttributeCode])) {
            throw new InvalidArgumentException(sprintf('"%s": isn\'t allowed', $imageAttributeCode));
        }

        $resultInstance = $this->objectManager->create(self::IMAGE_ATTRIBUTE_CODES[$imageAttributeCode], $data);
        if (!$resultInstance instanceof ImageAbstract) {
            throw new InvalidArgumentException(sprintf('%s isn\'t instance of %s',
                get_class($resultInstance),
                ImageAbstract::class
            ));
        }

        return $resultInstance;
    }
}