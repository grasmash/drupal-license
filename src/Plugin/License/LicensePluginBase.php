<?php
/**
 * @file
 * Description.
 *
 * @package LicensePluginBase.php
 */

namespace Drupal\license\Plugin\License;


use Drupal\Core\Plugin\ContextAwarePluginBase;

abstract class LicensePluginBase extends ContextAwarePluginBase implements LicenseInterface {

  /**
   * @var array
   */
  protected $configuration;

  public function getConfiguration() {
    return $this->configuration;
  }

  public function setConfiguration(array $configuration) {
    $this->configuration = $configuration;
  }

  public function defaultConfiguration() {
    return [];
  }

  public function calculateDependencies() {
    return [];
  }


}
