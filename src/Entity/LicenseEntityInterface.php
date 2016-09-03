<?php

namespace Drupal\license\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining License entity entities.
 *
 * @ingroup license
 */
interface LicenseEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the License entity type.
   *
   * @return string
   *   The License entity type.
   */
  public function getType();

  /**
   * Gets the License entity name.
   *
   * @return string
   *   Name of the License entity.
   */
  public function getName();

  /**
   * Sets the License entity name.
   *
   * @param string $name
   *   The License entity name.
   *
   * @return \Drupal\license\Entity\LicenseEntityInterface
   *   The called License entity entity.
   */
  public function setName($name);

  /**
   * Gets the License entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the License entity.
   */
  public function getCreatedTime();

  /**
   * Sets the License entity creation timestamp.
   *
   * @param int $timestamp
   *   The License entity creation timestamp.
   *
   * @return \Drupal\license\Entity\LicenseEntityInterface
   *   The called License entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the License entity published status indicator.
   *
   * Unpublished License entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the License entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a License entity.
   *
   * @param bool $published
   *   TRUE to set this License entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\license\Entity\LicenseEntityInterface
   *   The called License entity entity.
   */
  public function setPublished($published);

}
