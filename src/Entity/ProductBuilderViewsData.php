<?php

namespace Drupal\product_builder\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Product builder entities.
 */
class ProductBuilderViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
