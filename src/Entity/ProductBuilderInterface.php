<?php

namespace Drupal\product_builder\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Product builder entities.
 *
 * @ingroup product_builder
 */
interface ProductBuilderInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Product builder name.
   *
   * @return string
   *   Name of the Product builder.
   */
  public function getName();

  /**
   * Sets the Product builder name.
   *
   * @param string $name
   *   The Product builder name.
   *
   * @return \Drupal\product_builder\Entity\ProductBuilderInterface
   *   The called Product builder entity.
   */
  public function setName($name);

  /**
   * Gets the Product builder creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Product builder.
   */
  public function getCreatedTime();

  /**
   * Sets the Product builder creation timestamp.
   *
   * @param int $timestamp
   *   The Product builder creation timestamp.
   *
   * @return \Drupal\product_builder\Entity\ProductBuilderInterface
   *   The called Product builder entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Product builder published status indicator.
   *
   * Unpublished Product builder are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Product builder is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Product builder.
   *
   * @param bool $published
   *   TRUE to set this Product builder to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\product_builder\Entity\ProductBuilderInterface
   *   The called Product builder entity.
   */
  public function setPublished($published);

}
