<?php

namespace Drupal\dcb;

/**
 * Class DCBComponentTheme.
 *
 * @package Drupal\dynoblock
 */
abstract class DCBComponentTheme {

  public $form_state = array();
  public $plugin;

  /**
   * DCBComponentTheme constructor.
   *
   * @param array $form_state
   * @param DCBComponentInterface $plugin
   */
  public function __construct(&$form_state = array(), DCBComponentInterface $plugin) {
    $this->plugin = $plugin;
    $this->form_state = $form_state;
  }

  /**
   * This is used for adding theme specific form elements to the widgets form.
   *
   * @param $widget_form
   *  The widgets form
   * @param $settings
   *  an array of settings to be used in creating/adding form elements.
   */
  abstract public function form(&$widget_form, $settings = array());

  /**
   * Called when a widget using this theme needs displayed.
   *
   * @param $values
   *  and array of field values or $form_state['values']
   * @param $settings
   *  an array of settings to be used when building the widgets display.
   */
  abstract public function display($values = array(), $settings = array());

  /**
   * Gets called when the widgets form is built.
   * This displays in the widget UI showing what the theme they have seleted looks like.
   *
   * @param $file
   *  a filename string that will be used to display its preview.
   */
  public function preview($file = '') {
    if ($file) {
      $file = file_create_url($this->plugin->directory . '/' . $file);
      $preview = array(
        '#type' => 'markup',
        '#markup' => '<img src="'. $file. '"/>',
      );
      return render($preview);
    }
  }
}