<?php

namespace Drupal\product_builder\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ProductBuilderTypeForm.
 */
class ProductBuilderTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $product_builder_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $product_builder_type->label(),
      '#description' => $this->t("Label for the Product builder type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $product_builder_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\product_builder\Entity\ProductBuilderType::load',
      ],
      '#disabled' => !$product_builder_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $product_builder_type = $this->entity;
    $status = $product_builder_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Product builder type.', [
          '%label' => $product_builder_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Product builder type.', [
          '%label' => $product_builder_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($product_builder_type->toUrl('collection'));
  }

}
