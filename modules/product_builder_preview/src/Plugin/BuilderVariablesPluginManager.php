<?php

namespace Drupal\product_builder_preview\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Provides the Builder Variables manager.
 */
class BuilderVariablesPluginManager extends DefaultPluginManager {

  /**
   * Constructor for BuilderVariablesPluginManager objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    $this->alterInfo('builder_variables_info');
    $this->setCacheBackend($cache_backend, 'builder_variables_plugins');

    parent::__construct('Plugin/BuilderVariables', $namespaces, $module_handler,
      'Drupal\product_builder_preview\Plugin\BuilderVariablesPluginInterface',
      'Drupal\product_builder_preview\Annotation\BuilderVariables');

  }

}
