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
 * Class Mail
 * @package AR\Epistolary\Block\Adminhtml\Button
 */
class Mail extends Template implements ButtonProviderInterface
{
    /**
     * Get button data.
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Mail'),
            'on_click' => "function () {
            }",
            'class' => 'mail primary',
            'sort_order' => 20,
        ];
    }
}
