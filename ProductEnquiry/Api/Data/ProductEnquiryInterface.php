<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Api\Data;

interface ProductEnquiryInterface
{
    public const ENTITY_ID = 'entity_id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const ADDRESS = 'address';
    public const SKU = 'sku';
    public const QTY = 'qty';
    public const CREATED_AT = 'created_at';

    public function getName(): string;

    public function setName(string $name): ProductEnquiryInterface;

    public function getEmail(): string;

    public function setEmail(string $email): ProductEnquiryInterface;

    public function getAddress(): string;

    public function setAddress(string $address): ProductEnquiryInterface;

    public function getSku(): string;

    public function setSku(string $sku): ProductEnquiryInterface;

    public function getQty(): int;

    public function setQty(int $qty): ProductEnquiryInterface;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(string $createdAt): ProductEnquiryInterface;
}
