<?php

namespace Drupal\product_builder;

use Drupal\commerce_product\ProductLazyBuilders;
use Drupal\product_builder\Entity\ProductBuilder;

/**
 * Provides #lazy_builder callbacks.
 */
class ProductBuilderLazyBuilders extends ProductLazyBuilders {

  /**
   * Builds the add to cart form with product builder submit.
   */
  public function addToCartForm($product_id, $view_mode, $combine, $langcode) {
    list(
      $product_id,
      $view_mode,
      $combine,
      $langcode,
      $builder_bundle,
      $builder_button_text,
      $builder_type
    ) = func_get_args();

    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $this->entityTypeManager->getStorage('commerce_product')->load($product_id);
    $product = $this->entityRepository->getTranslationFromContext($product, $langcode);

    $form_state = [
      'product' => $product,
      'view_mode' => $view_mode,
      'builder_bundle' => $builder_bundle,
      'builder_button_text' => $builder_button_text,
      'builder_type' => $builder_type,
      'settings' => [
        'combine' => $combine,
      ],
    ];

    $values = ['type' => $builder_bundle];
    $product_builder_entity = ProductBuilder::create($values);
    $product_builder_form = \Drupal::service('entity.form_builder')->getForm(
      $product_builder_entity,
      $view_mode,
      $form_state
    );

    return $product_builder_form;
  }

}
