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
namespace AR\Epistolary\Model\ResourceModel\Message;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AR\Epistolary\Api\Data\MessageInterface;

/**
 * Class Collection
 * @package AR\Epistolary\Model\ResourceModel\Message
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = MessageInterface::ENTITY_ID;

    /**
     * Varien invention Constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            \AR\Epistolary\Model\Message::class,
            \AR\Epistolary\Model\ResourceModel\Message::class
        );
    }
}
