<?php

namespace Drupal\dcb\Plugin\DCBField;

use Drupal\Component\Plugin\PluginBase;

class DCBFieldBase extends PluginBase implements DCBFieldInterface {

  public $form_state = array();
  public $field;
  public $display;

  public function init($form_state) {
    $this->form_state = $form_state;
    $this->field = array(
      'handler' => array(
        '#type' => 'hidden',
        '#value' => get_called_class(),
      ),
    );
  }

  /**
   * Return the id of the Widget.
   *
   * @return string
   */
  function getId() {
    return $this->pluginDefinition['id'];
  }

  /**
   * Return the name of the Widget.
   *
   * @return string
   */
  function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * Method for creating fields.
   * @see https://api.drupal.org/api/drupal/developer!topics!forms_api_reference.html/7
   * @param $properties
   *  An array of field properties. eg: array('#title' => t('Link'))
   * @return $field
   *  A form render array.
   */
  function form($properties = array()) {}

  /**
   * Called when a widget using this field is being rendered.
   * @param $value
   *  An array containing the field values.
   * @param $settings
   *  An array of settings that may be used in the building of the fields display.
   * @return $display
   *  An render array containing the fields output.
   */
  function render($value, $settings = array()) {}

  /**
   * Called when a widget is saved.
   * - Note: this is not always called. The widget itself must call this explicitly.
   *    One use case example is when a widget has an image field.
   *    The widget would call this method so it could save the image permanently.
   * @param $value
   *  An array containing the field values.
   * @param $value
   *  an array containing the fields value(s) or $form_state['values'].
   */
  function onSubmit() {}
  function onAjax() {}
  function validate() {}

  function setFormElement($values = array()) {
    $this->field['value'] = $values;
  }

}