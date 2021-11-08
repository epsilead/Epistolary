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
namespace AR\Epistolary\Plugin;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use AR\Epistolary\Api\MessageRepositoryInterface;
use AR\Epistolary\Api\Data\MessageInterfaceFactory;

/**
 * Class ContactControllerPostPlugin
 * @package AR\Epistolary\Plugin
 */
class ContactControllerPostPlugin
{
    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $resultRedirectFactory;

    /**
     * @var MessageManager
     */
    protected MessageManager $messageManager;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var MessageRepositoryInterface
     */
    protected MessageRepositoryInterface $messageRepository;

    /**
     * @var MessageInterfaceFactory
     */
    protected MessageInterfaceFactory $messageFactory;

    /**
     * ContactControllerPostPlugin Constructor.
     *
     * @param RedirectFactory $resultRedirectFactory
     * @param MessageManager $messageManager
     * @param DataPersistorInterface $dataPersistor
     * @param MessageRepositoryInterface $messageRepository
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        RedirectFactory $resultRedirectFactory,
        MessageManager $messageManager,
        DataPersistorInterface $dataPersistor,
        MessageRepositoryInterface $messageRepository,
        MessageInterfaceFactory $messageFactory
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        $this->dataPersistor = $dataPersistor;
        $this->messageRepository = $messageRepository;
        $this->messageFactory = $messageFactory;
    }

    /**
     * Around execute of the Magento\Contact\Controller\Index\Post Controller.
     *
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function aroundExecute(\Magento\Contact\Controller\Index\Post $subject)
    {
        $post = $subject->getRequest()->getPostValue();
        if (!$post) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        try {
            $error = false;

            if (!\Zend_Validate::is(trim($post['subject']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['message']), 'NotEmpty')) {
                $error = true;
            }
            if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                $error = true;
            }
            if (!$error) {
                $message = $this->messageFactory->create();
                $message->setData($post);
                $this->messageRepository->save($message);
                $this->dataPersistor->clear('contact_us');
            } else {
                throw new \Exception();
            }
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            return $this->resultRedirectFactory->create()->setPath('contact/index');
        } catch (\Exception $e) {
            $this->dataPersistor->set('contact_us', $post);
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
            return $this->resultRedirectFactory->create()->setPath('contact/index');
        }
    }
}
