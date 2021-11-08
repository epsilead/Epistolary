<?php
/**
 * AR_Epistolary module
 *
 * @category  AR
 * @package   AR_Epistolary
 * @copyright 2021 Artem Rotmistrenko
 * @license
 * @author    Artem Rotmistrenko
 */
namespace AR\Epistolary\Api\Data;

/**
 * Message Data Model Interface.
 *
 * @api
 */
interface MessageInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TABLE         = 'ar_epmessage';
    const ENTITY_ID     = 'entity_id';
    const STATUS        = 'status';
    const SUBJECT       = 'subject';
    const EMAIL         = 'email';
    const MESSAGE       = 'message';
    const CREATED_AT    = 'created_at';

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Status.
     *
     * @return int
     */
    public function getStatus();

    /**
     * Get Subject.
     *
     * @return string
     */
    public function getSubject();

    /**
     * Get Email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get Message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get Creation Time.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set ID.
     *
     * @param int $id
     * @return MessageInterface
     */
    public function setId(int $id);

    /**
     * Set Status.
     *
     * @param int $value
     * @return MessageInterface
     */
    public function setStatus(int $value);

    /**
     * Set Subject.
     *
     * @param string $value
     * @return MessageInterface
     */
    public function setSubject(string $value);

    /**
     * Set Email.
     *
     * @param string $value
     * @return MessageInterface
     */
    public function setEmail(string $value);

    /**
     * Set Message.
     *
     * @param string $value
     * @return MessageInterface
     */
    public function setMessage(string $value);

    /**
     * Set Creation Time.
     *
     * @param string $value
     * @return MessageInterface
     */
    public function setCreatedAt(string $value);
}
