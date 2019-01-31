<?php

namespace Drupal\drupaltext\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;

use Drupal\Core\Form\FormInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "drupaltext_first_block_block",
 *   admin_label = @Translation("My first block"),
 * )
 */
class FirstBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {


        /*
         * Пример работы с формой
         *
         * */
        /*$form = \Drupal::formBuilder()->getForm('Drupal\drupaltext\Form\CustomFormInBlockForm');
        return $form;*/

        $user_name  = \Drupal::currentUser()->getAccountName();

        $config = $this->getConfiguration();

        if (!empty($config['drupaltext_first_block_settings'])) {

            $text = $this->t('Hello @name in block!', ['@name' => $config['drupaltext_first_block_settings']]);

        } elseif (isset($user_name)){

            $text = $this->t('Hello @name in block!', ['@name' => $user_name]);

        } else {
            $text = $this->t('Hello World in block!');
        }

        return [
            '#markup' => $text,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $config = $this->getConfiguration();

        $form['drupaltext_first_block_settings'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#description' => $this->t('Who do you want to say hello to?'),
            '#default_value' => !empty($config['drupaltext_first_block_settings']) ? $config['drupaltext_first_block_settings'] : '',
        ];

      $form['drupaltext_first_block_checkbox'] = array(
        '#type' => 'checkbox',
        '#title' => $this->t('Static name enabled'),
        //'#description' => $this->t('Static name enabled'),
        '#default_value' => !empty($config['drupaltext_first_block_checkbox']) ? $config['drupaltext_first_block_checkbox'] : '',
      );


      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['drupaltext_first_block_settings'] = $form_state->getValue('drupaltext_first_block_settings');
        $this->configuration['drupaltext_first_block_checkbox'] = $form_state->getValue('drupaltext_first_block_checkbox');
    }
}