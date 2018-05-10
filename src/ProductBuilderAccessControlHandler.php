<?php

namespace Drupal\product_builder;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Product builder entity.
 *
 * @see \Drupal\product_builder\Entity\ProductBuilder.
 */
class ProductBuilderAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\product_builder\Entity\ProductBuilderInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished product builder entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published product builder entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit product builder entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete product builder entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add product builder entities');
  }

}
