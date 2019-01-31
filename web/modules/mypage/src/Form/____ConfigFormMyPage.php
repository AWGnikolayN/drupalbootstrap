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

    var_dump($form_state);die;
  }


  /**
   * {@inheritdoc}.
   */
  // Вместо hook_form.
  public function buildForm(array $form, FormStateInterface $form_state) {

    $headerQuery = array(
      // We make it sortable by name.
      array('data' => $this->t('Id'), 'field' => 'id', 'sort' => 'asc'),
      array('data' => $this->t('Title'), 'field' => 'title', 'sort' => 'asc'),
      array('data' => $this->t('Body'), 'field' => 'body', 'sort' => 'asc'),
    );

    $header = array(
      'id' => t('Id'),
      'title' => t('Title'),
      'body' => t('Body'),
    );

    $db = \Drupal::database();
    $query = $db->select('mypage','c');
    $query->fields('c', array('id', 'title', 'body'));

    // The actual action of sorting the rows is here.
    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->orderByHeader($headerQuery);
    // Limit the rows to 20 for each page.
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit(2);
    $result = $pager->execute();

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

    /*$form['submit'] = array
    (
      '#type' => 'submit',
      '#name' => 'import_from_csv',
      '#value' => t('Export in CSV'),
    );*/

    $form['sample1'] = array(
      '#type' => 'submit',
      '#value' => t('Sample Button1'),
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


    /*$form = parent::buildForm($form, $form_state);
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
    $db_logic = \Drupal::service('mypage.db_logic');
    $data = $db_logic->getAll();
    if ($data) {
      $form['data'] = array(
        '#type' => 'table',
        '#caption' => $this->t('Table Data'),
        '#header' => array($this->t('id'), $this->t('Title'), $this->t('Body')),
      );
      foreach ($data as $item) {
        // Пример создания ссылки.
        // Первым аргументом указывается нования роута, вторм аргументы его.
        $url = Url::fromRoute('mypage.view', array(
          'mypage_id' => $item->id,
        ));
        $form['data'][] = array(
          'id' => array(
            '#type' => 'markup',
            '#markup' => \Drupal::l($item->id, $url),
          ),
          'title' => array(
            '#type' => 'markup',
            '#markup' => $item->title,
          ),
          'body' => array(
            '#type' => 'markup',
            '#markup' => $item->body,
          ),
        );
      }
    }

    return $form;*/


    /*$header = array(
      // We make it sortable by name.
      array('data' => $this->t('Title'), 'field' => 'title', 'sort' => 'asc'),
      array('data' => $this->t('Body'), 'field' => 'body', 'sort' => 'asc'),
    );

    $db = \Drupal::database();
    $query = $db->select('mypage','c');
    $query->fields('c', array('title', 'body'));

    // The actual action of sorting the rows is here.
    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->orderByHeader($header);
    // Limit the rows to 20 for each page.
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit(1);
    $result = $pager->execute();

    // Populate the rows.
    $rows = array();
    foreach($result as $row) {
      $rows[] = array('data' => array(
        'title' => $row->title,
        'body' => $row->body, // This hardcoded [BLOB] is just for display purpose only.
      ));
    }

    // The table description.
    $form = array(
      '#markup' => t('List of All Configurations')
    );

    // Generate the table.
    $form['config_table'] = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    );

    // Finally add the pager.
    $form['pager'] = array(
      '#type' => 'pager'
    );

    return $form;*/
  }

  /**
   * {@inheritdoc}
   */
  // Вместо hook_form_validate.
  public function validateForm(array &$form, FormStateInterface $form_state) {
    var_dump($form['actions']);die;
    //var_dump($form_state);die;
    /*if (strpos($form_state->getValue('email'), '.com') === FALSE) {
      $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
    }*/
  }

  /**
   * {@inheritdoc}
   */
  // Вместо hook_form_submit.
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $db_logic = \Drupal::service('mypage.db_logic');
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