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
    $entity_list = &drupal_static('pb_entity_reference_variables', []);
    $tree = &drupal_static('pb_entity_reference_variables_tree', []);

    $entity_type = $this->field_definition->getSetting('target_type');
    $handler_settings = $this->field_definition->getSetting('handler_settings');

    $id = $value ? $value : 'new';
    $tree_id = $entity_type . '_' . $id;

    //if there is an entity in entity tree position
    if (array_search($tree_id, $tree) !== FALSE) {
      return;
    }

    //If there is prepared variables for for this entity
    if (isset($entity_list[$entity_type][$id])) {
      return $entity_list[$entity_type][$id];
    }

    $tree[] = $tree_id;

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

    if ($value) {
      $value = parent::prepare($value);
      $referenced_entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($value);
      if (method_exists($referenced_entity, 'getFields')) {
        $prepared += product_builder_preview_entity_get_prepared_fields($referenced_entity);
      }
      else {
        $prepared = $value;
      }
    }
    else {
      $prepared = $value;
    }

    $entity_list[$entity_type][$id] = $prepared;
    array_pop($tree);

    return $prepared;
  }

  public function getFieldKeys() {
    return ['target_id'];
  }

}
