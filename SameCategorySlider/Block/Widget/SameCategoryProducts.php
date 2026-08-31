<?php

namespace Codilar\SameCategorySlider\Block\Widget;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class SameCategoryProducts extends Template implements BlockInterface
{
    protected $_template = 'Codilar_SameCategorySlider::widget/same-category-products.phtml';
    private RequestInterface $request;
    private ProductRepositoryInterface $productRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private CollectionFactory $productCollectionFactory;
    private ImageHelper $imageHelper;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        CollectionFactory $productCollectionFactory,
        ImageHelper $imageHelper,
        array $data = []
    ) {
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;

        parent::__construct($context, $data);
    }

    /**
     * Get current product.
     */
    public function getCurrentProduct(): ?Product
    {
        $productId = (int) $this->request->getParam('id');

        if (!$productId) {
            return null;
        }

        try {
            return $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getCurrentCategoryId(): ?int
    {
        $currentProduct = $this->getCurrentProduct();

        if (!$currentProduct || !$currentProduct->getId()) {
            return null;
        }

        $categoryIds = $currentProduct->getCategoryIds();

        if (empty($categoryIds)) {
            return null;
        }

        $deepestCategoryId = null;
        $deepestLevel = -1;

        foreach ($categoryIds as $categoryId) {
            try {
                $category = $this->categoryRepository->get((int) $categoryId);
                if ((int) $category->getLevel() > $deepestLevel) {
                    $deepestLevel = (int) $category->getLevel();
                    $deepestCategoryId = (int) $category->getId();
                }
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }

        return $deepestCategoryId;
    }

    /**
     * Get products from the same deepest category.
     */
    public function getProducts(): Collection
    {
        $currentProduct = $this->getCurrentProduct();

        $collection = $this->productCollectionFactory->create();

        if (!$currentProduct || !$currentProduct->getId()) {
            return $collection;
        }

        $categoryId = $this->getCurrentCategoryId();

        if (!$categoryId) {
            return $collection;
        }

        /*
         * Select required product attributes.
         */
        $collection->addAttributeToSelect([
            'name',
            'price',
            'special_price',
            'image',
            'small_image',
            'thumbnail',
            'url_key',
            'status',
            'visibility'
        ]);

        $collection->addCategoriesFilter([
            'in' => [$categoryId]
        ]);

        /*
         * Exclude current product.
         */
        $collection->addFieldToFilter(
            'entity_id',
            [
                'neq' => $currentProduct->getId()
            ]
        );

        /*
         * Only enabled products.
         */
        $collection->addAttributeToFilter(
            'status',
            \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED
        );

        /*
         * Only visible products.
         */
        $collection->addAttributeToFilter(
            'visibility',
            [
                'in' => [
                    Visibility::VISIBILITY_IN_CATALOG,
                    Visibility::VISIBILITY_IN_SEARCH,
                    Visibility::VISIBILITY_BOTH
                ]
            ]
        );

        /*
         * Maximum 8 products.
         */
        $collection->setPageSize(8);

        return $collection;
    }

    /**
     * Get product image URL.
     */
    public function getProductImageUrl(Product $product): string
    {
        return $this->imageHelper
            ->init($product, 'product_page_image_small')
            ->setImageFile($product->getSmallImage())
            ->getUrl();
    }
}
