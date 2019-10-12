<?php

namespace Smartosc\Article\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;
use Smartosc\Article\Model\ResourceModel\Article\CollectionFactory;

class Detail extends Template
{
    public $_pageFactory;
    public $_articleCollectionFactory;
    public $_request;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CollectionFactory $articleCollectionFactory,
        Http $request
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_articleCollectionFactory = $articleCollectionFactory;
        $this->_request = $request;
        return parent::__construct($context);
    }

    public function getId()
    {
        return $this->_request->getParam('id');
    }

    public function getDetailArticle()
    {
        $collection = $this->_articleCollectionFactory->create()->addFieldToFilter(['id'], [$this->getId()]);
        return $collection;
    }

    protected function _prepareLayout()
    {
//        parent::_prepareLayout();
//        $this->pageConfig->getTitle()->set(__('Article'));
//
//        if ($this->getArticle()) {
//            $pager = $this->getLayout()->createBlock(
//                'Magento\Theme\Block\Html\Pager',
//                'smartosc.article'
//            )
//                ->setAvailableLimit([5=>5,10=>10])
//                ->setShowPerPage(true)
//                ->setCollection($this->getArticle());
//
//            $this->setChild('pager', $pager);
//            $this->getArticle()->load();
//        }
//
//        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
