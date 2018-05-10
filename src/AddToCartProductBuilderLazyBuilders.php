<?php

namespace Drupal\product_builder;

use Drupal\commerce_product\ProductLazyBuilders;
use Drupal\Core\Form\FormState;


/**
 * Provides #lazy_builder callbacks.
 */
class AddToCartProductBuilderLazyBuilders extends ProductLazyBuilders {

  /**
   * Builds the add to cart form with product builder submit.
   */
  public function addToCartForm($product_id, $view_mode, $combine, $langcode) {

    $args = [func_get_args()];

    /** @var \Drupal\commerce_order\OrderItemStorageInterface $order_item_storage */
    $order_item_storage = $this->entityTypeManager->getStorage('commerce_order_item');
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $this->entityTypeManager->getStorage('commerce_product')->load($product_id);
    // Load Product for current language.
    $product = $this->entityRepository->getTranslationFromContext($product, $langcode);

    $default_variation = $product->getDefaultVariation();
    if (!$default_variation) {
      return [];
    }

    $order_item = $order_item_storage->createFromPurchasableEntity($default_variation);
    /** @var \Drupal\commerce_cart\Form\AddToCartFormInterface $form_object */
    $form_object = $this->entityTypeManager->getFormObject('commerce_order_item', 'add_to_cart_product_builder');
    $form_object->setOperation('add_to_cart');

    $form_object->setEntity($order_item);
    // The default form ID is based on the variation ID, but in this case the
    // product ID is more reliable (the default variation might change between
    // requests due to an availability change, for example).
    $form_object->setFormId($form_object->getBaseFormId() . '_commerce_product_' . $product_id);
    $form_state = (new FormState())->setFormState([
      'product' => $product,
      'view_mode' => $view_mode,
      'settings' => [
        'combine' => $combine,
      ],
      'builder_bundle' => $args[0][4],
      'builder_button_text' => $args[0][5],
    ]);

    return $this->formBuilder->buildForm($form_object, $form_state);
  }

}
