<?php

namespace Drupal\dynoblock\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\HtmlResponse;

class DynoController extends ControllerBase {

  function __construct() {

  }

  function generate($type, $rid, $nid) {

  }

  function selectorModal() {

  }

  function save($method) {

  }

  function remove($rid, $bid) {

  }

  function edit($rid, $bid, $nid) {

  }

  function ajaxLoad($type = 'blocks', $id) {

  }

  function update($rid, $bid) {

  }

  function testpage() {
    //$content['dynoblocks_test_region'] = DynoBlocks::dynoRegion('dynoblocks-test', NULL, 'Test Region');
    //$content['dynoblocks_test_region']['blocks'] = DynoBlocks::renderDynoBlocks('dynoblocks-test');

    $manager = \Drupal::service('plugin.manager.dynoblock');
    $plugins = $manager->getDefinitions();
    $instance = $manager->createInstance($plugins['page_title']['id']);
    //kint($instance->getId());

    $manager = \Drupal::service('plugin.manager.dynofield');
    $plugins = $manager->getDefinitions();
    $instance = $manager->createInstance($plugins['text_field']['id']);
    //kint($instance->getId());

    $build = array(
      '#type' => 'markup',
      '#markup' => t('Hello World!'),
    );

    return $build;
  }

/*  function create() {

  }*/

}