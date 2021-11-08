<?php
/**
 * AR_Epistolary module
 *
 * @category  AR
 * @package   AR_Epistolary
 * @copyright 2018 Artem Rotmistrenko
 * @license
 * @author    Artem Rotmistrenko
 */
namespace AR\Epistolary\Block\Adminhtml\Button;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Delete
 * @package AR\Epistolary\Block\Adminhtml\Button
 */
class Delete extends Template implements ButtonProviderInterface
{
    /**
     * Delete url
     *
     * @var string
     */
    protected $deleteUrl = 'epistolary/message/delete';

    /**
     * Get button data.
     *
     * @return array
     */
    public function getButtonData()
    {
        $request = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\Request\Http');
        $urlBuilder = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        $entityId = $request->getParam('entity_id');
        $deleteUrl = $urlBuilder->getUrl($this->deleteUrl, ['entity_id' => $entityId]);
        return [
            'label' => __('Delete'),
            'class' => 'delete primary',
            'on_click' => sprintf("location.href = '%s';", $deleteUrl),
            'sort_order' => 50,
        ];
    }
}
