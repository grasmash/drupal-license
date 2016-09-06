<?php
/**
 * @file
 * Description.
 *
 * @package EntityAccessLicense.php
 */

namespace Drupal\license\Plugin\License;


use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\license\Entity\License;

/**
 * @License(
 *   id = "entity_access",
 *   label = @Translation("Entity Access License"),
 *   context = {
 *     "license" = @ContextDefinition("entity:license")
 *   }
 */
class EntityAccessLicense extends LicensePluginBase implements PluginFormInterface {

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['test'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Test field')
    ];
    return $form;
  }

  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement validateConfigurationForm() method.
  }

  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['test'] = $form_state->getValue('test');
  }


  public function applies(array $args) {
    if ($args[0] instanceof EntityInterface) {
      /** @var EntityInterface $entity */
      $entity = $args[0];
      $configuration = $this->getConfiguration();
      $op = $args[1];
      return $entity->getEntityTypeId() == $configuration['entity_type_id'] && $entity->bundle() == $configuration['bundle'] && $op == $configuration['op'];
    }
  }

  public function access(array $args) {
    /** @var License $license */
    $license = $this->getContextValue('license');
    /** @var EntityInterface $entity */
    $entity = $args[0];
    return $entity->id() == $license->get('licensed_entitiy')->getValue();
  }

}
