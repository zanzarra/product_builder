<?php

namespace Drupal\product_builder\Plugin\RulesAction;

use Drupal\rules\Core\RulesActionBase;
use Drupal\commerce_price\Price;
use Drupal\commerce_order\Entity\OrderItemInterface;

/**
 * Provides a 'Order Item Set Unit Price' action.
 *
 * @RulesAction(
 *   id = "rules_product_builder_order_item_set_unit_price",
 *   label = @Translation("Set unit price for commerce order item(Product builder)"),
 *   category = @Translation("Order item"),
 *   context = {
 *     "entity" = @ContextDefinition("entity",
 *       label = @Translation("Commerce Order Item"),
 *       description = @Translation("Commerce Order Item.")
 *     ),
 *     "value" = @ContextDefinition("float",
 *       label = @Translation("Value"),
 *       description = @Translation("Float value which use for unit price")
 *     )
 *   }
 * )
 *
 */
class ProductBuilderOrderItemSetUnitPrice extends RulesActionBase {

  /**
   * Set order item unit price.\
   *
   * @param OrderItemInterface $order_item
   *   Commerce order item object.
   *
   * @param $value
   *   Value which use for order item unit price.
   */
  protected function doExecute(OrderItemInterface $order_item, $value) {
    $price = $order_item->getUnitPrice();
    $calculated_price = new Price(strval($value), $price->getCurrencyCode());
    $order_item->setUnitPrice($calculated_price);
  }
}
