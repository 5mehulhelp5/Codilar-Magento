<?php

namespace Codilar\ShowPrice\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddProductNoteToAllAttributeSets implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    private EavSetupFactory $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);

        $attributeCode = 'product_note';

        /*
         * Get Product Note attribute
         */
        $attribute = $eavSetup->getAttribute(
            Product::ENTITY,
            $attributeCode
        );

        if (!$attribute) {
            $this->moduleDataSetup->getConnection()->endSetup();
            return $this;
        }

        $attributeId = (int) $attribute['attribute_id'];

        /*
         * Get all Product Attribute Sets
         */
        $attributeSets = $eavSetup->getAllAttributeSetIds(
            Product::ENTITY
        );

        foreach ($attributeSets as $attributeSetId) {

            /*
             * Get default attribute group
             * of current attribute set
             */
            $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(
                Product::ENTITY,
                $attributeSetId
            );

            /*
             * Check whether Product Note
             * is already assigned to this set
             */
            $connection = $this->moduleDataSetup->getConnection();

            $select = $connection->select()
                ->from(
                    $connection->getTableName('eav_entity_attribute'),
                    ['entity_attribute_id']
                )
                ->where('attribute_set_id = ?', $attributeSetId)
                ->where('attribute_id = ?', $attributeId);

            $exists = $connection->fetchOne($select);

            /*
             * Add Product Note if not already assigned
             */
            if (!$exists) {
                $eavSetup->addAttributeToGroup(
                    Product::ENTITY,
                    $attributeSetId,
                    $attributeGroupId,
                    $attributeCode,
                    100
                );
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    public static function getDependencies()
    {
        return [
            AddProductNoteAttribute::class
        ];
    }

    public function getAliases()
    {
        return [];
    }
}
