<?php
namespace Smartosc\Article\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Module\Manager;
use Magento\Framework\View\Result\PageFactory;

class Display extends Action
{
    protected $_pageFactory;
    protected $_moduleManager;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Manager $moduleManager
    ) {
        $this->_pageFactory = $pageFactory;
//        $this->_moduleManager = $moduleManager;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
