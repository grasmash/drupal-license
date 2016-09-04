<?php

namespace Drupal\license\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining License entities.
 *
 * @ingroup license
 */
interface LicenseInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the License type.
   *
   * @return string
   *   The License type.
   */
  public function getType();

  /**
   * Gets the License name.
   *
   * @return string
   *   Name of the License.
   */
  public function getName();

  /**
   * Sets the License name.
   *
   * @param string $name
   *   The License name.
   *
   * @return \Drupal\license\Entity\LicenseInterface
   *   The called License entity.
   */
  public function setName($name);

  /**
   * Gets the License creation timestamp.
   *
   * @return int
   *   Creation timestamp of the License.
   */
  public function getCreatedTime();

  /**
   * Sets the License creation timestamp.
   *
   * @param int $timestamp
   *   The License creation timestamp.
   *
   * @return \Drupal\license\Entity\LicenseInterface
   *   The called License entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the License published status indicator.
   *
   * Unpublished License are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the License is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a License.
   *
   * @param bool $published
   *   TRUE to set this License to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\license\Entity\LicenseInterface
   *   The called License entity.
   */
  public function setPublished($published);

}
