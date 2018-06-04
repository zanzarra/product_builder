<?php

namespace Drupal\product_builder_preview\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * An interface for builder variables plugins.
 */
interface BuilderVariablesPluginInterface extends PluginInspectionInterface, ContainerFactoryPluginInterface {

  /**
   * Prepare field value for product builder template.
   *
   * @param mixed $value
   *   Field value.
   *
   * @return mixed
   */
  public function prepare($value);

  /**
   * Get field keys, which use for preparing variables.
   *
   * @return array
   */
  public function getFieldKeys();

}
