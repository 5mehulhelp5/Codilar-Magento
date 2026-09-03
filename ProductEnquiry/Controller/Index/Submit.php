<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Controller\Index;

use Codilar\ProductEnquiry\Api\ProductEnquiryRepositoryInterface;
use Codilar\ProductEnquiry\Logger\Logger;
use Codilar\ProductEnquiry\Model\ProductEnquiryFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Validator\EmailAddress;

class Submit implements HttpPostActionInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ProductEnquiryFactory $productEnquiryFactory,
        private readonly ProductEnquiryRepositoryInterface $productEnquiryRepository,
        private readonly JsonFactory $resultJsonFactory,
        private readonly Logger $logger,
        private readonly ManagerInterface $messageManager
    ) {
    }

    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();

        try {
            $name = trim((string) $this->request->getParam('name'));
            $email = trim((string) $this->request->getParam('email'));
            $address = trim((string) $this->request->getParam('address'));
            $sku = trim((string) $this->request->getParam('sku'));
            $qty = (int) $this->request->getParam('qty');

            if ($name === '') {
                throw new LocalizedException(
                    __('Name is required.')
                );
            }

            if (!(new EmailAddress())->isValid($email)) {
                throw new LocalizedException(
                    __('Please enter a valid email address.')
                );
            }

            if ($address === '') {
                throw new LocalizedException(
                    __('Address is required.')
                );
            }

            if ($sku === '') {
                throw new LocalizedException(
                    __('SKU is required.')
                );
            }

            if ($qty <= 0) {
                throw new LocalizedException(
                    __('Quantity must be greater than zero.')
                );
            }

            $productEnquiry = $this->productEnquiryFactory->create();

            $productEnquiry->setName($name);
            $productEnquiry->setEmail($email);
            $productEnquiry->setAddress($address);
            $productEnquiry->setSku($sku);
            $productEnquiry->setQty($qty);

            $this->productEnquiryRepository->save($productEnquiry);

            $this->logger->info(
                'Product enquiry submitted successfully.',
                ['sku' => $sku]
            );

            /*
             * Add success message to Magento's
             * standard message manager.
             */
            $this->messageManager->addSuccessMessage(
                __('Product enquiry submitted successfully.')
            );

            return $result->setData([
                'success' => true
            ]);
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage());

            return $result->setHttpResponseCode(400)->setData([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        } catch (\Throwable $exception) {
            $this->logger->error(
                'Product enquiry submission failed.',
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );

            return $result->setHttpResponseCode(500)->setData([
                'success' => false,
                'message' => __(
                    'Something went wrong. Please try again later.'
                )
            ]);
        }
    }
}
