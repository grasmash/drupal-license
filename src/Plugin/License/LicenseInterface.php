<?php
/**
 * @file
 * Description.
 *
 * @package LIcenseInterface.php
 */

namespace Drupal\license\Plugin\License;


use Drupal\Component\Plugin\ConfigurablePluginInterface;

interface LicenseInterface extends ConfigurablePluginInterface {

  public function applies(array $args);

  public function access(array $args);

}
