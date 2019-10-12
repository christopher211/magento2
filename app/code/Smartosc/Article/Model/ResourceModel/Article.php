<?php

namespace Smartosc\Article\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Article extends AbstractDb
{
    /**
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sm_article', 'id');
    }
}
