<?php
/**
 * @file
 * Contains \Drupal\drupalform\Form.
 */

namespace Drupal\drupalform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomFormInBlock extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_in_block';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['employee_name'] = [
      '#type'     => 'textfield',
      '#title'    => t('Employee Name:'),
      '#required' => TRUE,
    ];
    $form['employee_mail'] = [
      '#type'     => 'email',
      '#title'    => t('Email :'),
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type'        => 'submit',
      '#value'       => $this->t('Register'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage($this->t('@emp_name ,Your application is being submitted! You E-mail @emp_email',
      ['@emp_name' => $form_state->getValue('employee_name'), '@emp_email' => $form_state->getValue('employee_mail')]));

  }

}