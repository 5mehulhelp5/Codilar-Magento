<?php

declare(strict_types=1);

namespace Codilar\BuyNow\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;

class Buy implements HttpPostActionInterface
{
    public function __construct(
        private readonly Cart $cart,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly RequestInterface $request,
        private readonly RedirectFactory $resultRedirectFactory,
        private readonly ManagerInterface $messageManager
    ) {
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $productId = (int) $this->request->getParam('product');

        try {
            $product = $this->productRepository->getById($productId);

            if (!$product->isSalable()) {
                throw new LocalizedException(
                    __('This product is not available.')
                );
            }

            $buyRequest = $this->request->getParams();

            $this->cart->addProduct($product, $buyRequest);
            $this->cart->save();

            $this->messageManager->addSuccessMessage(
                __('Product was added to your shopping cart.')
            );

            return $resultRedirect->setPath('checkout/index/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                $e->getMessage()
            );
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(
                __('Unable to add the product to the cart.')
            );
        }

        return $resultRedirect->setPath(
            'catalog/product/view',
            ['id' => $productId]
        );
    }
}
