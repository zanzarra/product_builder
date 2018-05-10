<?php

/**
 * @file
 * Contains \Drupal\product_builder\Plugin\Field\FieldFormatter\ProductBuilderFormLinkFormatter.
 */

namespace Drupal\product_builder\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'product builder form link' formatter.
 *
 * @FieldFormatter(
 *   id = "product_builder_form_link",
 *   label = @Translation("Product builder form link"),
 *   description = @Translation("Display form's link of the product builder."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ProductBuilderFormLinkFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'builder_text' => 'Create your own @bundle',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $element['builder_text'] = [
      '#title' => t('Link text'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('builder_text'),
      '#description' => t('Label for product build form link. @bundle is builder label.'),
      '#required' => TRUE,
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->getSetting('builder_text');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $label = $this->getSetting('builder_text');
      $bundle = $entity->label();
      $label = str_replace('@bundle', $bundle, $label);
      $uri = $entity->toUrl('add-form', array('attributes' => array('target' => '_blank')));

      if (isset($uri) && !$entity->isNew()) {
        $elements[$delta] = [
          '#type' => 'link',
          '#title' => $label,
          '#url' => $uri,
          '#options' => $uri->getOptions(),
        ];

        if (!empty($items[$delta]->_attributes)) {
          $elements[$delta]['#options'] += ['attributes' => []];
          $elements[$delta]['#options']['attributes'] += $items[$delta]->_attributes;
          // Unset field item attributes since they have been included in the
          // formatter output and shouldn't be rendered in the field template.
          unset($items[$delta]->_attributes);
        }
      }
      else {
        $elements[$delta] = ['#plain_text' => $label];
      }
      $elements[$delta]['#cache']['tags'] = $entity->getCacheTags();
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity) {
    return $entity->access('view label', NULL, TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // this formatter are available for commerce product as parent and product_builder_type as reference.
    $field_config = $field_definition->getFieldStorageDefinition();
    $settings = $field_config->getSettings();
    if (($field_definition->getTargetEntityTypeId() == 'commerce_product') && ($settings['target_type'] == 'product_builder_type')) {
      return TRUE;
    }

    return FALSE;
  }
}
