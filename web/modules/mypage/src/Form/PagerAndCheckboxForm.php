<?php
/**
 * @file
 * Contains \Drupal\mypage\Form\PagerAndCheckboxForm.
 */

namespace Drupal\mypage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PagerAndCheckboxForm extends FormBase{


  public function getFormId() {
    return 'pager_and_checkbox';
  }


  public function buildForm(array $form, FormStateInterface $form_state)
  {

    /** @var \Drupal\mypage\MyPageDbLogic $db_logic */
    $db_logic = \Drupal::service('mypage.db_logic');

    if ($result = $db_logic->getAllDataPagination()) {

//      $header = array(
//        'id' => t('Id'),
//        'title' => t('Title'),
//        'body' => t('Body'),
//      );

      $header = array(
        'id'    => array('data' => t('Id'), 'field' => 'id'),
        'title' => array('data' => t('Title'), 'field' => 'title'),
        'body'  => array('data' => t('Body'), 'field' => 'body'),
      );


      $options = array();
      foreach($result as $row) {
        $url = Url::fromRoute('mypage.view', array(
          'mypage_id' => $row->id,
        ));
        $options[$row->id] = array(
          'id' => $row->id,
          'title' => \Drupal::l($row->title, $url),
          'body' => $row->body,
        );
      }
      $form['tableselect_element'] = array(
        '#type' => 'tableselect',
        '#header' => $header,
        '#options' => $options,
        '#empty' => t('No content available.'),
        //'#multiple' => FALSE,
      );

      $form['submit'] = array
      (
        '#type' => 'submit',
        '#value' => t('Export'),
      );

      // Finally add the pager.
      $form['pager'] = array(
        '#type' => 'pager'
      );


      return $form;

    }

    // Вернет страница не найдена.
    throw new NotFoundHttpException();

  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
    $values = $form_state->getValues();

    // Get checked element this form
    foreach ($form_state->getValue('tableselect_element') as $bundle_id => $checked) {
      if ($checked) {
        \Drupal::messenger()->addMessage('Checked: ' . $bundle_id . ' -> ' . $checked);
      }
      else {
        \Drupal::messenger()->addMessage('No Checked: ' . $bundle_id . ' -> ' . $checked);
      }
    }



    // Get id from selected table
    //var_dump($form['tableselect_element']['#value']);die;

//    foreach ($values as $key => $value) {
//      $label = isset($form[$key]['#title']) ? $form[$key]['#title'] : $key;
//
//      // Many arrays return 0 for unselected values so lets filter that out.
//      if (is_array($value)) {
//        $value = array_filter($value);
//      }
//
//      // Only display for controls that have titles and values.
//      if ($value && $label) {
//        $display_value = is_array($value) ? preg_replace('/[\n\r\s]+/', ' ', print_r($value, 1)) : $value;
//        $message = $this->t('Value for %title: %value', array('%title' => $label, '%value' => $display_value));
//        \Drupal::messenger()->addMessage($message);
//      }
//    }
  }


}