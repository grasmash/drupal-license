<?php

namespace Drupal\license;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the License entity entity.
 *
 * @see \Drupal\license\Entity\LicenseEntity.
 */
class LicenseEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\license\Entity\LicenseEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished license entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published license entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit license entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete license entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add license entity entities');
  }

}
