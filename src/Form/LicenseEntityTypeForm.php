<?php

namespace Drupal\license\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LicenseEntityTypeForm.
 *
 * @package Drupal\license\Form
 */
class LicenseEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $license_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $license_entity_type->label(),
      '#description' => $this->t("Label for the License entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $license_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\license\Entity\LicenseEntityType::load',
      ],
      '#disabled' => !$license_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $license_entity_type = $this->entity;
    $status = $license_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label License entity type.', [
          '%label' => $license_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label License entity type.', [
          '%label' => $license_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($license_entity_type->urlInfo('collection'));
  }

}
