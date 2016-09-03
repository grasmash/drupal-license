<?php

namespace Drupal\license\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for License entity entities.
 */
class LicenseEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['license_entity']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('License entity'),
      'help' => $this->t('The License entity ID.'),
    );

    return $data;
  }

}
