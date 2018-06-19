<?php

namespace Drupal\product_builder\Event;

use Symfony\Component\EventDispatcher\Event;
use Drupal\commerce_order\Entity\OrderItemInterface;

/**
 * Event that is fired when a user create new product builder.
 *
 * @see product_builder_commerce_add_to_cart()
 */
class ProductBuilderAddToCart extends Event {

  const EVENT_NAME = 'rules_product_builder_add_to_cart';

  /**
   * The commerce order item.
   */
  public $order_item;

  /**
   * ProductBuilderAddToCart constructor.
   *
   * @param OrderItemInterface $order_item
   */
  public function __construct(OrderItemInterface $order_item) {
    $this->order_item = $order_item;
  }

}
