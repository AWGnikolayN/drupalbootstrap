<?php

namespace Drupal\crudform\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CrudformBlock' block.
 *
 * @Block(
 *  id = "crudform_block",
 *  admin_label = @Translation("Crudform block"),
 * )
 */
class CrudformBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['crudform_block']['#markup'] = 'Implement CrudformBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\crudform\Form\CrudformForm');

    return $form;
  }

}
