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

use Magento\Ui\DataProvider\AbstractDataProvider;
use AR\Epistolary\Model\ResourceModel\Message\CollectionFactory;;

/**
 * Class DataProvider
 * @package AR\Epistolary\Model
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * DataProvider Constructor.
     *
     * @param string $name
     * @param string  $primaryFieldName
     * @param string  $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data for UI form.
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        /** @var \AR\Epistolary\Model\Message[] $items */
        $items = $this->collection->getItems();
        foreach ($items as $message) {
            $this->loadedData[$message->getId()] = $message->getData();
        }
        return $this->loadedData;
    }
}
