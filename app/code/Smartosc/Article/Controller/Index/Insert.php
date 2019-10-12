<?php
namespace Smartosc\Article\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Smartosc\Article\Model\ArticleFactory;

class Insert extends Action
{
    protected $_pageFactory;
    protected $_articleFactory;

    public function __construct(Context $context, PageFactory $pageFactory, ArticleFactory $articleFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_articleFactory = $articleFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $articleFactory = $this->_articleFactory->create();
        $data = ['name'=>'ARTICLE','post_content'=>'THIS IS THE CONTENT OF ARTICLE', 'url_key' => 'url'];

        $articleFactory->setData($data);

        if ($articleFactory->save()) {
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        } else {
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('article/index/insert');
        return $resultRedirect;
    }
}
