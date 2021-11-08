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
namespace AR\Epistolary\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use AR\Epistolary\Model\ResourceModel\Message\CollectionFactory;
use AR\Epistolary\Api\MessageRepositoryInterface;

/**
 * Class MassDelete
 * @package AR\Epistolary\Controller\Adminhtml\Message
 */
class MassDelete extends Action
{
    /**
     * Massactions filter.
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var MessageRepositoryInterface
     */
    protected MessageRepositoryInterface $messageRepository;

    /**
     * Controller Constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        MessageRepositoryInterface $messageRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->messageRepository = $messageRepository;
        parent::__construct($context);
    }

    /**
     * Controller executing.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $recordDeleted = 0;
        foreach ($collection->getItems() as $message) {
            $this->messageRepository->delete($message);
            $recordDeleted++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $recordDeleted));
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
