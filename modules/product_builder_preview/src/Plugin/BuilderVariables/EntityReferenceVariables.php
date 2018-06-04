<?php

namespace Drupal\product_builder_preview\Plugin\BuilderVariables;

use Drupal\product_builder_preview\Plugin\BuilderVariablesPluginBase;

/**
 * Provides a 'EntityReference' builder variables.
 *
 * @BuilderVariables(
 *   id = "entity_reference",
 *   label = @Translation("EntityReference"),
 * )
 */
class EntityReferenceVariables extends BuilderVariablesPluginBase {

  public function prepare($value) {

    $entity_type = $this->field_definition->getSetting('target_type');
    $handler_settings = $this->field_definition->getSetting('handler_settings');

    $multiple_bundles = FALSE;
    if (!empty($handler_settings['target_bundles'])) {
      $multiple_bundles = (count($handler_settings['target_bundles']) > 1) ? TRUE : FALSE;
    }

    $prepared = [];

    if (!$value || $multiple_bundles) {
      $bundle_key = \Drupal::entityTypeManager()->getStorage($entity_type)->getEntityType()->getKey('bundle');

      if (!empty($handler_settings['target_bundles'])) {
        foreach ($handler_settings['target_bundles'] as $bundle) {
          $referenced_entity = \Drupal::entityTypeManager()->getStorage($entity_type)->create([$bundle_key => $bundle]);
          if (method_exists($referenced_entity, 'getFields')) {
            $prepared += product_builder_preview_entity_get_prepared_fields($referenced_entity);
          }
        }
      }
      elseif (!$bundle_key) {
        $referenced_entity = \Drupal::entityTypeManager()->getStorage($entity_type)->create();
        if (method_exists($referenced_entity, 'getFields')) {
          $prepared = product_builder_preview_entity_get_prepared_fields($referenced_entity);
        }
      }

    }

    if (!$value) {
      return $prepared;
    }

    $referenced_entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($value);
    if (method_exists($referenced_entity, 'getFields')) {
      return $prepared + product_builder_preview_entity_get_prepared_fields($referenced_entity);
    }

    return $value;
  }

  public function getFieldKeys() {
    return ['target_id'];
  }

}
