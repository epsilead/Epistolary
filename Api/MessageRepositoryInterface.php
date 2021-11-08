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
namespace AR\Epistolary\Api;

/**
 * Message CRUD interface.
 *
 * @api
 */
interface MessageRepositoryInterface
{
    /**
     * Retrieve message.
     *
     * @param string $messageId
     * @return \AR\Epistolary\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($messageId);

    /**
     * Retrieve messages matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Save message.
     *
     * @param \AR\Epistolary\Api\Data\MessageInterface $message
     * @return \AR\Epistolary\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\MessageInterface $message);

    /**
     * Delete message.
     *
     * @param \AR\Epistolary\Api\Data\MessageInterface $message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\MessageInterface $message);
}
