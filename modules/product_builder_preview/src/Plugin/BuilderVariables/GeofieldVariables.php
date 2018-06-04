<?php

namespace Drupal\product_builder_preview\Plugin\BuilderVariables;

use Drupal\product_builder_preview\Plugin\BuilderVariablesPluginBase;

/**
 * Provides a 'Request Path' condition.
 *
 * @BuilderVariables(
 *   id = "geofield",
 *   label = @Translation("Geofield"),
 * )
 */
class GeofieldVariables extends BuilderVariablesPluginBase {

  public function getFieldKeys() {
    return ['lat', 'lon'];
  }

}
