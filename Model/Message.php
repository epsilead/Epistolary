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

use \Magento\Framework\Model\AbstractModel;
use AR\Epistolary\Api\Data\MessageInterface;

/**
 * Class Message
 * @package AR\Epistolary\Model
 */
class Message extends AbstractModel implements MessageInterface
{
    const CACHE_TAG = 'ar_epistolary_message';

    protected $_cacheTag = 'ar_epistolary_message';

    protected $_eventPrefix = 'ar_epistolary_message';

    protected function _construct()
    {
        $this->_init(\AR\Epistolary\Model\ResourceModel\Message::class);
    }

    /**
     * Retrieve Message id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Retrieve Message Status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Retrieve Message Subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * Retrieve Customer Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Retrieve Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Retrieve Creation Time
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Message id.
     *
     * @param int|mixed $id
     * @return MessageInterface|Message
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set Message Status.
     *
     * @param int $value
     * @return MessageInterface|Message
     */
    public function setStatus(int $value)
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * Set Message Subject.
     *
     * @param string $value
     * @return MessageInterface|Message
     */
    public function setSubject(string $value)
    {
        return $this->setData(self::SUBJECT, $value);
    }

    /**
     * Set Customer Email.
     *
     * @param string $value
     * @return MessageInterface|Message
     */
    public function setEmail(string $value)
    {
        return $this->setData(self::EMAIL, $value);
    }

    /**
     * Set Message.
     *
     * @param string $value
     * @return MessageInterface|Message
     */
    public function setMessage(string $value)
    {
        return $this->setData(self::MESSAGE, $value);
    }

    /**
     * Set Creation Time.
     *
     * @param string $value
     * @return MessageInterface|Message
     */
    public function setCreatedAt(string $value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }
}
