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

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use AR\Epistolary\Api\MessageRepositoryInterface;
use AR\Epistolary\Api\Data\MessageInterface;
use AR\Epistolary\Api\Data\MessageInterfaceFactory;
use AR\Epistolary\Model\ResourceModel\Message as MessageResource;
use AR\Epistolary\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;

/**
 * Class MessageRepository
 * @package AR\Epistolary\Model
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageResource
     */
    protected MessageResource $resource;

    /**
     * @var MessageInterfaceFactory
     */
    protected MessageInterfaceFactory $messageFactory;

    /**
     * @var MessageCollectionFactory
     */
    protected MessageCollectionFactory $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * MessageRepository Constructor.
     *
     * @param MessageInterfaceFactory $messageFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param MessageResource $messageResource
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsInterfaceFactory
     */
    public function __construct(
        MessageInterfaceFactory $messageFactory,
        MessageCollectionFactory $messageCollectionFactory,
        MessageResource $messageResource,
        SearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->messageFactory = $messageFactory;
        $this->collectionFactory = $messageCollectionFactory;
        $this->resource = $messageResource;
        $this->searchResultsFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get Entity by Id.
     *
     * @param string $id
     * @return MessageInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        /** @var MessageInterface $message */
        $message = $this->messageFactory->create();
        $this->resource->load($message, $id);
        if (! $message->getId()) {
            throw new NoSuchEntityException(__('Unable to find Message with ID "%1"', $id));
        }
        return $message;
    }

    /**
     * Save Entity.
     *
     * @param MessageInterface $message
     * @return MessageInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(MessageInterface $message)
    {
        $this->resource->save($message);
        return $message;
    }

    /**
     * Delete Entity.
     *
     * @param MessageInterface $message
     * @return bool|void
     * @throws \Exception
     */
    public function delete(MessageInterface $message)
    {
        $this->resource->delete($message);
    }

    /**
     * Delete Message by given Identity.
     *
     * @param $entityId
     * @return bool|void
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * Get Items.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
