<?php

namespace Drupal\license\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the License entity entity.
 *
 * @ingroup license
 *
 * @ContentEntityType(
 *   id = "license_entity",
 *   label = @Translation("License entity"),
 *   bundle_label = @Translation("License entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\license\LicenseEntityListBuilder",
 *     "views_data" = "Drupal\license\Entity\LicenseEntityViewsData",
 *     "translation" = "Drupal\license\LicenseEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\license\Form\LicenseEntityForm",
 *       "add" = "Drupal\license\Form\LicenseEntityForm",
 *       "edit" = "Drupal\license\Form\LicenseEntityForm",
 *       "delete" = "Drupal\license\Form\LicenseEntityDeleteForm",
 *     },
 *     "access" = "Drupal\license\LicenseEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\license\LicenseEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "license_entity",
 *   data_table = "license_entity_field_data",
 *   translatable = TRUE,
  *   admin_permission = "administer license entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/license_entity/{license_entity}",
 *     "add-page" = "/admin/structure/license_entity/add",
 *     "add-form" = "/admin/structure/license_entity/add/{license_entity_type}",
 *     "edit-form" = "/admin/structure/license_entity/{license_entity}/edit",
 *     "delete-form" = "/admin/structure/license_entity/{license_entity}/delete",
 *     "collection" = "/admin/structure/license_entity",
 *   },
 *   bundle_entity_type = "license_entity_type",
 *   field_ui_base_route = "entity.license_entity_type.edit_form"
 * )
 */
class LicenseEntity extends ContentEntityBase implements LicenseEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the License entity entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setRequired(TRUE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner'))
      ->setDescription(t('The user ID of author of license owner.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 1,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 1,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('list_integer')
      ->setLabel(t('Status'))
      ->setDescription(t('The license status.'))
      ->setDefaultValue(LICENSE_CREATED)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 2,
      ))
      ->setRequired(TRUE)
      ->setSetting('allowed_values', [
        LICENSE_CREATED => t('Created'),
        LICENSE_PENDING => t('Pending'),
        LICENSE_ACTIVE => t('Active'),
        LICENSE_EXPIRED => t('Expired'),
        LICENSE_SUSPENDED => t('Suspended'),
        LICENSE_REVOKED => t('Revoked'),
      ]);

    $fields['expires_automatically'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Expires automatically'))
      ->setDescription(t('If true, the license will expire automatically at the expiry date and time.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'boolean_checkbox',
        'weight' => 3,
        'settings' => array(
          'display_label' => TRUE,
        ),
      ))
      ->setDefaultValue(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['expiry'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Expiry'))
      ->setDescription(t('The license expiration date and time.'))
      // @todo Make the default value configurable
      ->setDefaultValue(date('Y-m-d', strtotime('+1 month')))
      ->setDisplayOptions('form', array(
        'type' => 'datetime_default',
        'weight' => 4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['licensed_entity_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Licensed entity'))
      ->setDescription(t('The entity to which this license grants the owner access.'))
      ->setRevisionable(TRUE)
      // @todo Make this configurable on the entity type form.
      ->setSetting('target_type', 'node')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 1,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 1,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
