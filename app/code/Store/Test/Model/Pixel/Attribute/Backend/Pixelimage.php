<?php
/**
 * Pixelimage
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */

namespace Store\Test\Model\Pixel\Attribute\Backend;

class Pixelimage extends ImageAbstract
{
    /**
     * @var string
     */
    const ATTRIBUTE_CODE = 'pixelimage';

    protected function subdirName(): string
{
    return self::ATTRIBUTE_CODE;
}

    protected function attributeCode(): string
{
    return self::ATTRIBUTE_CODE;
}

}
