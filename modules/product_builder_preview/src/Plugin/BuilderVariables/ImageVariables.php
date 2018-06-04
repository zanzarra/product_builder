<?php

namespace Drupal\product_builder_preview\Plugin\BuilderVariables;

use Drupal\product_builder_preview\Plugin\BuilderVariablesPluginBase;

/**
 * Provides a 'Image' builder variables.
 *
 * @BuilderVariables(
 *   id = "image",
 *   label = @Translation("Image"),
 * )
 */
class ImageVariables extends BuilderVariablesPluginBase {

  /**
   * {@inheritdoc}
   */
  public function prepare($value) {
    if (!$value || !$image = \Drupal::entityTypeManager()->getStorage('file')->load($value['target_id'])) {
      return parent::prepare($value);
    }

    return file_create_url($image->getFileUri());
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldKeys() {
    return ['link'];
  }

}
