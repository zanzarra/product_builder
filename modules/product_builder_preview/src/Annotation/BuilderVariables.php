<?php

namespace Drupal\product_builder_preview\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a condition plugin annotation object.
 *
 * @ingroup plugin_api
 *
 * @Annotation
 */
class BuilderVariables extends Plugin {

  /**
   *
   */
  public $id;

  /**
   *
   */
  public $label;

}
