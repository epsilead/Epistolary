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
namespace AR\Epistolary\Model;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package AR\Epistolary\Model
 */
class Status implements OptionSourceInterface
{
    /**
     * Get Grid row labels array.
     *
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['1' => __('Open'),'0' => __('Close')];
        return $options;
    }

    /**
     * Get Grid row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get Grid row type array for option element.
     *
     * @return array
     */
    public function getOptions()
    {
        $result = [];
        foreach ( $this->getOptionArray() as $index => $value ) {
            $result[] = ['value' => $index, 'label' => $value];
        }
        return $result;
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
