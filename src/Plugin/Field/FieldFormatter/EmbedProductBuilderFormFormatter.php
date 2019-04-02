<?php

namespace Drupal\product_builder\Plugin\Field\FieldFormatter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\commerce_product\Plugin\Field\FieldFormatter\AddToCartFormatter;

/**
 * Plugin implementation of the 'embed_product_builder_add_to_cart' formatter.
 *
 * @FieldFormatter(
 *   id = "embed_product_builder_add_to_cart",
 *   label = @Translation("Embed Product Builder form"),
 *   field_types = {
 *     "entity_reference",
 *   },
 * )
 */
class EmbedProductBuilderFormFormatter extends AddToCartFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'builder_text' => 'Create your own @bundle',
        'builder_bundle' => NULL,
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    $form['builder_text'] = [
      '#title' => t('Link text'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('builder_text'),
      '#description' => t('Label for product build form link. @bundle is builder label.'),
      '#required' => TRUE,
    ];

    $builder_bundles = \Drupal::service('entity_type.bundle.info')->getBundleInfo('product_builder');
    $options = [];
    foreach ($builder_bundles as $bundle_name => $bundle) {
      $options[$bundle_name] = $bundle['label'];
    }
    $form['builder_bundle'] = [
      '#type' => 'radios',
      '#title' => t('Product Builder Bundle'),
      '#options' => $options,
      '#required' => TRUE,
      '#default_value' => $this->getSetting('builder_bundle'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $builder_bundle = $this->getSetting('builder_bundle');
    $label = $this->getSetting('builder_text');
    $elements = [];
    $elements[0]['add_to_cart_form'] = [
      '#lazy_builder' => [
        'product_builder.product_builder_lazy_builders:addToCartForm', [
          $items->getEntity()->id(),
          $this->viewMode,
          $this->getSetting('combine'),
          $langcode,
          $builder_bundle,
          $label,
          'embed_customization'
        ],
      ],
      '#create_placeholder' => TRUE,
    ];

    return $elements;
  }

}
