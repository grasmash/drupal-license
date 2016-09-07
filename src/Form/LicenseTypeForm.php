<?php

namespace Drupal\license\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LicenseTypeForm.
 *
 * @package Drupal\license\Form
 */
class LicenseTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $license_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $license_type->label(),
      '#description' => $this->t("Label for the License type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $license_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\license\Entity\LicenseType::load',
      ],
      '#disabled' => !$license_type->isNew(),
    ];

    $target_entity_type = $license_type->get('target_entity_type');
    // @todo Make this more accurate. It might not have data.
    $has_data = (bool) $target_entity_type;
    $form['target_entity_type'] = array(
      '#type' => 'select',
      '#title' => t('Type of entity that can be licensed'),
      '#description' => t('Once you have selected an entity type, it cannot be changed!'),
      '#options' => \Drupal::entityManager()->getEntityTypeLabels(TRUE),
      '#default_value' => $license_type->get('target_entity_type'),
      '#required' => TRUE,
      // Disable if a license has already been created.
      //'#disabled' => $has_data,
      '#size' => 1,
      '#ajax' => array(
        'callback' => array($this, 'bundlesAjaxCallback'),
        'effect' => 'fade',
        'event' => 'change',
        'progress' => array(
          'type' => 'throbber',
          'message' => NULL,
        ),
      ),
    );

    $form['target_bundles'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Bundles that can be licensed'),
      '#description' => t('This value only affects new licenses. It will not change existing licenses.'),
      '#options' => !empty($target_entity_type) ? $this->getBundleOptions($target_entity_type) : [],
      '#default_value' => $license_type->get('target_bundles') ? $license_type->get('target_bundles') : [],
      '#required' => TRUE,
      '#size' => 1,
      '#states' => array(
        'invisible' => array(
          ':input[name="target_entity_type"]' => array('value' => ''),
        ),
      ),
    );

    /** @var \Drupal\user\RoleInterface[] $roles */
    $roles = user_roles(TRUE);
    $role_options = [];
    foreach ($roles as $rid => $role) {
      $role_options[$rid] = $role->label();
    }
    $form['roles'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Restricted roles'),
      '#description' => t('Roles whose entity access are restricted by license ownership. If no roles are selected, all roles will be restricted.'),
      '#options' => $role_options,
      '#default_value' => $license_type->get('roles') ? $license_type->get('roles') : array(),
    );

    return $form;
  }

  public function getBundleOptions($entity_type) {
    $bundles = \Drupal::entityManager()->getBundleInfo($entity_type);
    $options = [];
    foreach ($bundles as $bundle_machine_name => $values) {
      // The label does not need sanitizing since it is used as an optgroup
      // which is only supported by select elements and auto-escaped.
      $bundle_label = (string) $values['label'];
      $options[$bundle_machine_name] = $bundle_label;
    }

    return $options;
  }

  public function bundlesAjaxCallback(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $target_entity_type = $values['target_entity_type'];
    $form['target_bundle']['#options'] = $this->getBundleOptions($target_entity_type);
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#edit-target-bundles--wrapper', $form['target_bundles']));

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $license_type = $this->entity;
    $status = $license_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label License type.', [
          '%label' => $license_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label License type.', [
          '%label' => $license_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($license_type->urlInfo('collection'));
  }

}
