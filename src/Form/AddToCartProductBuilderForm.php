<?php

namespace Drupal\product_builder\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_cart\Form\AddToCartForm;

/**
 * Provides the order item add to cart form with product builder submit.
 */
class AddToCartProductBuilderForm extends AddToCartForm {

  /**
   * {@inheritdoc}
   */
  public function getBaseFormId() {
    return $this->entity->getEntityTypeId() . '_add_to_cart_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);

    $storage = $form_state->getStorage();
    $builder_bundle = $storage['builder_bundle'];
    $button_text = $storage['builder_button_text'];

    $builder_bundles = \Drupal::service('entity_type.bundle.info')->getBundleInfo('product_builder');
    $bundle_label = $builder_bundles[$builder_bundle]['label'];
    $button_text = t($button_text, array('@bundle' => $bundle_label));

    $actions['builder_redirect'] = [
      '#type' => 'submit',
      '#value' => $button_text,
      '#submit' => array('product_builder_add_to_cart_builder_form_redirect'),
      '#weight' => 100,
    ];

    return $actions;
  }

}
