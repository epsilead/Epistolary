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
use AR\Epistolary\Model\MessageRepository;

/**
 * Class Delete
 * @package AR\Epistolary\Controller\Adminhtml\Message
 */
class Delete extends Action
{
    /**
     * @var MessageRepository
     */
    protected MessageRepository $messageRepository;

    /**
     * Controller Constructor.
     *
     * @param Context $context
     * @param MessageRepository $messageRepository
     */
    public function __construct(
        Context $context,
        MessageRepository $messageRepository
    ) {
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
    }

    /**
     * Controller executing.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        if (isset($entityId)) {
            try {
                $this->messageRepository->deleteById($entityId);
                $this->messageManager->addSuccessMessage(__('Row data has been successfully Deleted'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
                $this->resultRedirectFactory->create()->setPath('*/*/edit', ['entity_id' => $entityId]);
            }
        } else {
            $this->messageManager->addErrorMessage(__('Message is not Exists!'));
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
