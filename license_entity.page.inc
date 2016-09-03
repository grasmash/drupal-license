<?php

/**
 * @file
 * Contains license_entity.page.inc.
 *
 * Page callback for License entity entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for License entity templates.
 *
 * Default template: license_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_license_entity(array &$variables) {
  // Fetch LicenseEntity Entity Object.
  $license_entity = $variables['elements']['#license_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
