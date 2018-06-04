<?php

namespace Drupal\product_builder_preview\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a basis for template variables plugin.
 *
 * @ingroup plugin_api
 */
abstract class BuilderVariablesPluginBase extends PluginBase implements BuilderVariablesPluginInterface {

  /**
   * Field definition object, for which prepare template variables.
   */
  protected $field_definition;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * Set field definition.
   */
  public function setFieldDefinition($definition) {
    $this->field_definition = $definition;
  }

  /**
   * {@inheritdoc}
   */
  public function prepare($value) {
    if (!$value) {
      if (count($this->getFieldKeys()) === 1) {
        return '';
      }

      return array_fill_keys($this->getFieldKeys(), '');
    }
    if (is_array($value)) {
      return array_intersect_key($value, array_fill_keys($this->getFieldKeys(), ''));
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldKeys() {
    return ['value'];
  }

}
