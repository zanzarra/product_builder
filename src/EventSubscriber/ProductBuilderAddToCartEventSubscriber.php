<?php

namespace Drupal\product_builder\EventSubscriber;

use Drupal\product_builder\Event\ProductBuilderAddToCart;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ProductBuilderAddToCartEventSubscriber.
 */
class ProductBuilderAddToCartEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [
      'rules_product_builder_add_to_cart' => ['alterQuantity', -100],
    ];

    return $events;
  }

  /**
   * Fired before the product builder item added to cart.
   */
  public function alterQuantity(ProductBuilderAddToCart $event) {
    $form_state = $event->getFormState();

    if ($form_state->hasValue('product_quantity')) {
      $quantity = $form_state->getValue('product_quantity');
      if (!is_numeric($quantity) || $quantity < 1) {
        return;
      }

      $order_item = $event->getOrderItem();
      $order_item->setQuantity($quantity);
    }
  }

}
