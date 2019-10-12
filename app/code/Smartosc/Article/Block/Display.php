<?php

namespace Smartosc\Article\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;
use Smartosc\Article\Model\ResourceModel\Article\CollectionFactory;
use Smartosc\Article\Helper\Config;

class Display extends Template
{
    public $_pageFactory;
    public $_articleCollectionFactory;
    public $_helper;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CollectionFactory $articleCollectionFactory,
        Config $helper
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_articleCollectionFactory = $articleCollectionFactory;
        $this->_helper = $helper;
        return parent::__construct($context);
    }

    public function getArticle()
    {
        $limit = (
            $this->getRequest()
                ->getParam('limit')
        ) ? $this->getRequest()->getParam('limit') : $this->_helper->getArticleConfig();

        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;

        $collection = $this->_articleCollectionFactory->create();
        $collection->setPageSize($limit);
        $collection->setCurPage($page);

        return $collection;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Article'));

        if ($this->getArticle()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'smartosc.article'
            )
                ->setAvailableLimit([
                    $this->_helper->getArticleConfig() => $this->_helper->getArticleConfig(),
                    $this->_helper->getArticleConfig()*2 => $this->_helper->getArticleConfig()*2,
                    $this->_helper->getArticleConfig()*3 => $this->_helper->getArticleConfig()*3
                ])
                ->setShowPerPage(true)
                ->setCollection($this->getArticle());

            $this->setChild('pager', $pager);
            $this->getArticle()->load();
        }

        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getArticleUrl($id)
    {
        return "/article/index/detail?id=$id";
    }
}
