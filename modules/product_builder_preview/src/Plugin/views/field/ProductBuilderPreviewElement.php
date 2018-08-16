<?php

namespace Drupal\product_builder_preview\Plugin\views\field;

use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\field\FieldPluginBase;

/**
 * A handler to provide proper displays for product builder preview element.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("product_builder_preview_element_field")
 */
class ProductBuilderPreviewElement extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {

  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $entities = $values->_relationship_entities;
    if (!empty($entities['product_builder_id'])) {
      return product_builder_preview_element_build($entities['product_builder_id']);
    }

    return [];
  }

}
