<?php

namespace Drupal\product_builder\Event;

use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\commerce_order\Entity\OrderItemInterface;

/**
 * Defines the Product Builder add to cart events.
 */
class ProductBuilderAddToCart extends Event {

  const EVENT_NAME = 'rules_product_builder_add_to_cart';

  /**
   * The commerce order item.
   *
   * @var \Drupal\commerce_order\Entity\OrderItemInterface
   */
  public $order_item;

  /**
   * Form state object.
   *
   * @var \Drupal\Core\Form\FormStateInterface
   */
  protected $form_state;

  /**
   * ProductBuilderAddToCart constructor.
   *
   * @param \Drupal\commerce_order\Entity\OrderItemInterface $order_item
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function __construct(OrderItemInterface $order_item, FormStateInterface $form_state) {
    $this->order_item = $order_item;
    $this->form_state = $form_state;
  }

  /**
   * Get commerce order item.
   *
   * @return \Drupal\commerce_order\Entity\OrderItemInterface
   */
  public function getOrderItem() {
    return $this->order_item;
  }

  /**
   * Get form state.
   *
   * @return \Drupal\Core\Form\FormStateInterface
   */
  public function getFormState() {
    return $this->form_state;
  }

}
