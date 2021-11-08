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
namespace AR\Epistolary\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use AR\Epistolary\Api\Data\MessageInterface;

/**
 * Class Message
 * @package AR\Epistolary\Model\ResourceModel
 */
class Message extends AbstractDb
{
    /**
     * Message Constructor.
     *
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Varien invention Constructor.
     */
    protected function _construct()
    {
        $this->_init(MessageInterface::TABLE, MessageInterface::ENTITY_ID);
    }
}
