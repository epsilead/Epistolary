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
use AR\Epistolary\Api\MessageRepositoryInterface;

/**
 * Class Save
 * @package AR\Epistolary\Controller\Adminhtml\Message
 */
class Save extends Action
{
    /**
     * @var MessageRepositoryInterface
     */
    protected MessageRepositoryInterface $messageRepository;

    /**
     * Controller Constructor.
     *
     * @param Context $context
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Context $context,
        MessageRepositoryInterface $messageRepository
    ) {
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
    }

    /**
     * Controller executing.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $entityId = $data['entity_id'];
        if (isset($entityId)) {
            $message = $this->messageRepository->getById($entityId);
            $message->setStatus($data['status']);
            $this->messageRepository->save($message);
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } else {
                $this->messageManager->addErrorMessage(__('Row data not Saved'));
            }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
