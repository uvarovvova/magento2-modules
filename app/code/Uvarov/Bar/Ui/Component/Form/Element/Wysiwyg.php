<?php

namespace Uvarov\Bar\Ui\Component\Form\Element;

use Magento\Backend\Block\Widget\Button;
use Magento\Backend\Helper\Data as DataHelper;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Ui\Component\Form\Element\Wysiwyg as BaseWysiwyg;
use Magento\Ui\Component\Wysiwyg\ConfigInterface;

/**
 * Class Wysiwyg
 * @package Uvarov\Bar\Ui\Component\Form\Element
 */
class Wysiwyg extends BaseWysiwyg
{
	/**
	 * @var DataHelper
	 */
	protected $backendHelper;

	/**
	 * @var LayoutInterface
	 */
	protected $layout;

	/**
	 * Wysiwyg constructor.
	 * @param ContextInterface $context
	 * @param FormFactory $formFactory
	 * @param ConfigInterface $wysiwygConfig
	 * @param LayoutInterface $layout
	 * @param DataHelper $backendHelper
	 * @param array $components
	 * @param array $data
	 * @param array $config
	 */
	public function __construct(
		ContextInterface $context,
		FormFactory $formFactory,
		ConfigInterface $wysiwygConfig,
		LayoutInterface $layout,
		DataHelper $backendHelper,
		array $components = [],
		array $data = [],
		array $config = []
	)
	{
		$this->layout = $layout;
		$this->backendHelper = $backendHelper;

		$config['wysiwyg'] = true;
		parent::__construct($context, $formFactory, $wysiwygConfig, $components, $data, $config);
		$this->setData($this->prepareData($this->getData()));
	}

	/**
	 * @param array $data
	 * @return array
	 */
	private function prepareData($data)
	{
		if ($this->editor->isEnabled()) {
			$data['config']['content'] .= $this->getWysiwygButtonHtml();
		}
		return $data;
	}

	/**
	 * Return wysiwyg button html
	 *
	 * @return string
	 */
	private function getWysiwygButtonHtml()
	{
		return $this->layout->createBlock(
			Button::class,
			'',
			[
				'data' => [
					'label' => __('WYSIWYG Editor'),
					'type' => 'button',
					'class' => 'action-wysiwyg',
					'onclick' => 'catalogWysiwygEditor.open(\'' . $this->backendHelper->getUrl(
							'catalog/product/wysiwyg'
						) . '\', \'' . $this->editor->getHtmlId() . '\')',
				]
			]
		)->toHtml();
	}
}
