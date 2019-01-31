<?php
/**
 * @file
 * Contains \Drupal\mypage\Controller\MyPageController.
 */

namespace Drupal\mypage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MyPageController extends ControllerBase {

  // Название переменной такоже как в роуте!!!
  public function content($mypage_id = NULL) {

    // Загрузка сервиса.
    /** @var \Drupal\mypage\MyPageDbLogic $db_logic */
    $db_logic = \Drupal::service('mypage.db_logic');
    if ($record = $db_logic->getById($mypage_id, TRUE)) {
      return array(
        // Работа с нашей темой.
        '#theme' => 'mypage_theme',
        '#data' => $record,
      );
    }
    // Вернет страница не найдена.
    throw new NotFoundHttpException();
  }

  public function all(){


    $form = \Drupal::formBuilder()
      ->getForm('Drupal\mypage\Form\PagerAndCheckboxForm');
    //return $form;

    return array(
      // Работа с нашей темой.
      '#theme' => 'mypage_theme_all',
      '#data' => $form,
    );



    /*$db_logic = \Drupal::service('mypage.db_logic');

    if ($records = $db_logic->getById()) {

      $header = array
      (
        'id' => t('SrNo'),
        'title' => t('Title'),
        'body' => t('Body'),
      );

      $rows = array();

      foreach($records as $record)
      {
        $url = Url::fromRoute('mypage.view', array(
          'mypage_id' => $record->id,
        ));
        $rows[] = array
        (
          'id' => \Drupal::l($record->id, $url),
          'title' => $record->title,
          'body' => $record->body,
        );
      }

      $form['table'] = array
      (
        '#type' => 'table',
        //'#type' => 'tableselect',
        '#header' => $header,
        //'#options' => $options,
        '#rows'   => $rows,
        '#empty' => t('No Text'),
      );

      $form['submit'] = array
      (
        '#type' => 'submit',
        '#value' => t('Export'),
      );
      return $form;
    }

    // Вернет страница не найдена.
    throw new NotFoundHttpException();*/


    /*$commentfield = array(
      '#type' => 'textfield',
      '#default_value' => '',
      '#title' => 'Comment',
      '#title_display' => 'invisible',
      '#name' => 'commentfield'
    );
    $options = array(
      array(
        'title' => 'How to Learn Drupal',
        'content_type' => 'Article',
        'status' => 'published',
        'comment' => array('data'=>$commentfield),
      ),
      array(
        'title' => 'Privacy Policy',
        'content_type' => 'Page',
        'status' => 'published',
        'comment' => array('data'=>$commentfield),
      ),
    );
    $header = array(
      'title' => t('Title'),
      'content_type' => t('Content type'),
      'status' => t('Status'),
      'comment' => t('Comment'),
    );
    $form['tableselect_element'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No content available.'),
    );

    return $form;*/

    /*$db_logic = \Drupal::service('mypage.db_logic');
    if ($record = $db_logic->getById()) {
      return array(
        // Работа с нашей темой.
        '#theme' => 'mypage_theme_all',
        '#data' => $record,
      );
    }
    // Вернет страница не найдена.
    throw new NotFoundHttpException();*/

  }

}
