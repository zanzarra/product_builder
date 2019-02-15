<?php

namespace Drupal\product_builder;

use Drupal\commerce_product\ProductLazyBuilders;
use Drupal\Core\Form\FormState;
use Drupal\product_builder\Entity\ProductBuilder;


/**
 * Provides #lazy_builder callbacks.
 */
class EmbedProductBuilderLazyBuilders extends ProductLazyBuilders {

  /**
   * Builds the add to cart form with product builder submit.
   */
  public function addToCartForm($product_id, $view_mode, $combine, $langcode) {

    $args = [func_get_args()];
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $this->entityTypeManager->getStorage('commerce_product')->load($product_id);
    // Load Product for current language.
    $product = $this->entityRepository->getTranslationFromContext($product, $langcode);

    $form_state = [
      'product' => $product,
      'view_mode' => $view_mode,
      'settings' => [
        'combine' => $combine,
      ],
      'builder_bundle' => $args[0][4],
      'builder_button_text' => $args[0][5],
      'builder_type' => 'embed',
    ];

    $values = ['type' => $args[0][4]];
    $product_builder_entity = ProductBuilder::create($values);
    $product_builder_form =  \Drupal::service('entity.form_builder')->getForm($product_builder_entity, 'add', $form_state);
    return $product_builder_form;
  }

}
