<?php

namespace Drupal\product_builder\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Product builder type entity.
 *
 * @ConfigEntityType(
 *   id = "product_builder_type",
 *   label = @Translation("Product builder type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\product_builder\ProductBuilderTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\product_builder\Form\ProductBuilderTypeForm",
 *       "edit" = "Drupal\product_builder\Form\ProductBuilderTypeForm",
 *       "delete" = "Drupal\product_builder\Form\ProductBuilderTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\product_builder\ProductBuilderTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "product_builder_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "product_builder",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/product_builder_type/{product_builder_type}",
 *     "add-form" = "/admin/structure/product_builder_type/add",
 *     "edit-form" = "/admin/structure/product_builder_type/{product_builder_type}/edit",
 *     "delete-form" = "/admin/structure/product_builder_type/{product_builder_type}/delete",
 *     "collection" = "/admin/structure/product_builder_type"
 *   }
 * )
 */
class ProductBuilderType extends ConfigEntityBundleBase implements ProductBuilderTypeInterface {

  /**
   * The Product builder type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Product builder type label.
   *
   * @var string
   */
  protected $label;

}
