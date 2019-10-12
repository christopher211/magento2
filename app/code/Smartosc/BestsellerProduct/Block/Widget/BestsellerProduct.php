<?php

namespace Smartosc\BestsellerProduct\Block\Widget;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Checkout\Helper\Cart;
use Magento\Framework\App\Http\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Pricing\Render;
use Magento\Framework\View\Element\Template;
use Magento\Reports\Helper\Data;
use Magento\Reports\Model\ResourceModel\Report\Collection\Factory;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory;
use Magento\Widget\Block\BlockInterface;

class BestsellerProduct extends Template implements BlockInterface
{
    protected $_template = 'widget/bestsellerproduct.phtml';

    const DEFAULT_PRODUCTS_COUNT = 10;
    const DEFAULT_IMAGE_WIDTH = 240;
    const DEFAULT_IMAGE_HEIGHT = 300;

    /**
     * Products count
     *
     * @var int
     */
    protected $productsCount;
    /**
     * @var Context
     */
    protected $httpContext;
    protected $resourceCollection;
    protected $productLoader;
    protected $resourceFactory;
    /**
     * Catalog product visibility
     *
     * @var Visibility
     */
    protected $catalogProductVisibility;

    /**
     * Product collection factory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * Image helper
     *
     * @var Magento\Catalog\Helper\Image
     */
    protected $imageHelper;
    /**
     * @var Cart
     */
    protected $cartHelper;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param Factory $resourceFactory
     * @param \Magento\Reports\Model\Grouped\CollectionFactory $collectionFactory
     * @param Data $reportsData
     * @param CollectionFactory $resourceCollection
     * @param ProductFactory $productLoader
     * @param array $data
     */

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        Factory $resourceFactory,
        \Magento\Reports\Model\Grouped\CollectionFactory $collectionFactory,
        Data $reportsData,
        CollectionFactory $resourceCollection,
        ProductFactory $productLoader,
        array $data = []
    ) {
        $this->resourceFactory = $resourceFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_reportsData = $reportsData;
        $this->imageHelper = $context->getImageHelper();
        $this->productLoader = $productLoader;
        $this->cartHelper = $context->getCartHelper();
        $this->resourceCollection = $resourceCollection;
        parent::__construct($context, $data);
    }
    /**
     * Image helper Object
     */
    public function imageHelperObj()
    {
        return $this->imageHelper;
    }
    /**
     * get featured product collection
     */
    public function getBestsellerProduct()
    {
        $limit = $this->getProductLimit();
        $resourceCollection = $this->resourceCollection->create();
        $resourceCollection->setPageSize($limit);
        return $resourceCollection;
    }
    /**
     * Get the configured limit of products
     * @return int
     */
    public function getProductLimit()
    {
        if ($this->getData('productCount')=='') {
            return self::DEFAULT_PRODUCTS_COUNT;
        }
        return $this->getData('productCount');
    }
    /**
     * Get the widht of product image
     * @return int
     */
    public function getProductImageWidth()
    {
        if ($this->getData('imageWidth')=='') {
            return self::DEFAULT_IMAGE_WIDTH;
        }
        return $this->getData('imageWidth');
    }
    /**
     * Get the height of product image
     * @return int
     */
    public function getProductImageHeight()
    {
        if ($this->getData('imageHeight')=='') {
            return self::DEFAULT_IMAGE_HEIGHT;
        }
        return $this->getData('imageHeight');
    }

    /**
     * Get the add to cart url
     * @param $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = [])
    {
        return $this->cartHelper->getAddUrl($product, $additional);
    }

    /**
     * Return HTML block with price
     *
     * @param Product $product
     * @param string $priceType
     * @param string $renderZone
     * @param array $arguments
     * @return string
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws LocalizedException
     */
    public function getProductPriceHtml(
        Product $product,
        $priceType = null,
        $renderZone = Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }
        $arguments['zone'] = isset($arguments['zone'])
            ? $arguments['zone']
            : $renderZone;
        $arguments['price_id'] = isset($arguments['price_id'])
            ? $arguments['price_id']
            : 'old-price-' . $product->getId() . '-' . $priceType;
        $arguments['include_container'] = isset($arguments['include_container'])
            ? $arguments['include_container']
            : true;
        $arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
            ? $arguments['display_minimal_price']
            : true;
        /** @var Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                FinalPrice::PRICE_CODE,
                $product,
                $arguments
            );
        }
        return $price;
    }
    public function loadProduct($id)
    {
        return $this->productLoader->create()->load($id);
    }
}
