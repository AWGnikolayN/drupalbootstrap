<?php

/**
 * @file
 * Contains \Drupal\mypage\Form\ConfigFormMyPage.
 */

namespace Drupal\mypage\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\SafeMarkup;

class ConfigFormMyPage extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  // Метод для котороый возвращает ид формы.
  public function getFormId() {
    return 'configform_mypage_form';
  }



  public function newSubmissionHandlerOne(array &$form, FormStateInterface $form_state) {
    // Get the form values here as $form_state->getValue(array('sample_field'))
    // and process it.

    if(is_array($form['tableselect_element']['#value'])){
      // Get checked element this form
      foreach ($form['tableselect_element']['#value'] as $bundle_id => $checked) {
        if ($checked) {
          \Drupal::messenger()->addMessage('Checked: ' . $bundle_id . ' -> ' . $checked);
        }
        else {
          \Drupal::messenger()->addMessage('No Checked: ' . $bundle_id . ' -> ' . $checked);
        }

      }
    }

  }


  /**
   * {@inheritdoc}.
   */
  // Вместо hook_form.
  public function buildForm(array $form, FormStateInterface $form_state) {



    /** @var \Drupal\mypage\MyPageDbLogicFromAdmin $db_logic */
    $db_logic = \Drupal::service('mypage.db_logic_from_admin');


    $header = array(
      'id'    => array('data' => t('Id'), 'field' => 'id'),
      'title' => array('data' => t('Title'), 'field' => 'title'),
      'body'  => array('data' => t('Body'), 'field' => 'body'),
    );

    $result = $db_logic->getAllDataPaginationFromAdmin();

    // Populate the rows.
    $options = array();
    foreach($result as $row) {

      $url = Url::fromRoute('mypage.view', array(
        'mypage_id' => $row->id,
      ));

      $options[$row->id] = array(
        'id' => \Drupal::l($row->id, $url),
        'title' => $row->title,
        'body' => $row->body,
      );
    }

    // The table description.
    $form = array(
      '#markup' => t('<h1>This is custom pager</h1>')
    );

    $form['tableselect_element'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No content available.'),
    );

    // This Button skip validation error
    $form['import_from_csv'] = array(
      '#type' => 'submit',
      '#name' => 'name_import_from_csv',
      '#value' => t('Export in CSV'),
      '#limit_validation_errors' => array(),
      '#submit' => array('::newSubmissionHandlerOne'),
    );

    // Finally add the pager.
    $form['pager'] = array(
      '#type' => 'pager'
    );

    // Return E-mail from config
    $config = $this->config('configform_mypage.settings');

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Your .com email address.'),
      '#default_value' => $config->get('email_address'),
    );
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
    );
    $form['body'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#rows' => 5,
      '#required' => TRUE,
    );

    $form = parent::buildForm($form, $form_state);

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  // Вместо hook_form_validate.
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strpos($form_state->getValue('email'), '.com') === FALSE) {
      $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  // Вместо hook_form_submit.
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $db_logic = \Drupal::service('mypage.db_logic_from_admin');
    $title = SafeMarkup::checkPlain($form_state->getValue('title'));
    $body = SafeMarkup::checkPlain($form_state->getValue('body'));

    //var_dump($form_state->getButtons());die;

    $db_logic->add($title, $body);
    // На замену variable_set/get пришли config.
    // Пример работы с ними.
    $config = $this->config('configform_mypage.settings');
    $config->set('email_address', $form_state->getValue('email'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  // Массив имен объектов конфигурации, которые доступны для редактирования.
  protected function getEditableConfigNames() {
    return ['configform_mypage.settings'];
  }

}