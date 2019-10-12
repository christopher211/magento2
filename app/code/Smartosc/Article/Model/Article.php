<?php

namespace Smartosc\Article\Model;

use Magento\Framework\Model\AbstractModel;

class Article extends AbstractModel
{
    /**
     * Initialize banner model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Article::class);
    }
}