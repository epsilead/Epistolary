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
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use AR\Epistolary\Model\ResourceModel\Message\CollectionFactory;

/**
 * Class Mail
 * @package AR\Epistolary\Controller\Adminhtml\Message
 */
class Mail extends Action
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;

    /**
     * @var StateInterface
     */
    protected StateInterface $inlineTranslation;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Controller Constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        LoggerInterface $logger = null
    ) {
        parent::__construct($context);
//        $this->context = $context;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;

        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
    }

    /**
     * Controller executing.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $resultJson = new DataObject();
            if (is_array($request = $this->validatedParams())) {
            try {
                $this->sendEmail($request);
                $resultJson->setData([
                    'message' => 'Your Mail is sended',
                    'error' => false,
                ]);
                } catch (LocalizedException $e) {
                    $this->logger->debug($e);
                    $resultJson->setData([
                        'message' => 'Backend Exeption',
                        'error' => true,
                    ]);
                } catch (\Exception $e) {
                    $this->logger->critical($e);
                }
        } else {
                $resultJson->setData([
                    'message' => $request,
                    'error' => true,
                ]);
            }
            return $this->resultJsonFactory->create()->setJsonData($resultJson->toJson());
        } else {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
    }

    /**
     * @param $data
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function sendEmail($data)
    {
        $originalMessage = $this->getOriginalMessage();
        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId());
        $templateVars = array(
            'subject' => $data['subject'],
            'message'   => $data['message'],
            'original' => $originalMessage['message']
        );
        $this->inlineTranslation->suspend();

        $from = $this->getEmailValues();
        $to = array($originalMessage['email']);
        $transport = $this->transportBuilder->setTemplateIdentifier('message_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    /**
     * @return array
     */
    protected function getEmailValues()
    {
        $email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
        $name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);
        return array('email' => $email, 'name' => $name);
    }

    /**
     * @return array|\Magento\Framework\Phrase
     */
    protected function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('message')) === '') {
            return __('Message is missing');
        }
        if (trim($request->getParam('subject')) === '') {
            return __('Subject is missing');
        }

        return $request->getParams();
    }

    /**
     * @return DataObject|void
     */
    protected function getOriginalMessage()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        if ($entityId) {
            $message = $this->collectionFactory->create();
            $message->addFieldToFilter('entity_id', $entityId);
            $item = $message->getFirstItem();
            return $item;
        }
    }
}
