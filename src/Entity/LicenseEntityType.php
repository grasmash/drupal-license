<?php

namespace Drupal\license\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the License entity type entity.
 *
 * @ConfigEntityType(
 *   id = "license_entity_type",
 *   label = @Translation("License entity type"),
 *   handlers = {
 *     "list_builder" = "Drupal\license\LicenseEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\license\Form\LicenseEntityTypeForm",
 *       "edit" = "Drupal\license\Form\LicenseEntityTypeForm",
 *       "delete" = "Drupal\license\Form\LicenseEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\license\LicenseEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "license_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "license_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/license_entity_type/{license_entity_type}",
 *     "add-form" = "/admin/structure/license_entity_type/add",
 *     "edit-form" = "/admin/structure/license_entity_type/{license_entity_type}/edit",
 *     "delete-form" = "/admin/structure/license_entity_type/{license_entity_type}/delete",
 *     "collection" = "/admin/structure/license_entity_type"
 *   }
 * )
 */
class LicenseEntityType extends ConfigEntityBundleBase implements LicenseEntityTypeInterface {

  /**
   * The License entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The License entity type label.
   *
   * @var string
   */
  protected $label;

}
