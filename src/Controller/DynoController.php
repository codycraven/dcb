<?php

namespace Drupal\dynoblock\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AjaxResponseAttachmentsProcessor;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\HtmlResponse;
use Drupal\dynoblock\DynoBlockForms;
use Drupal\dynoblock\DynoblockWidgetModal;
use Drupal\Component\Serialization\Json;
use Drupal\dynoblock\Service\DynoblockCore;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class DynoController extends ControllerBase {

  /**
   * Dynoblock core.
   *
   * @var \Drupal\dynoblock\Service\DynoblockCore
   */
  public $dynoblockCore;

  /**
   * {@inheritdoc}
   */
  public function __construct(DynoblockCore $dynoblockCore) {
    $this->dynoblockCore = $dynoblockCore;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('dynoblock.core')
    );
  }

  /**
   * @param $type
   * @param $rid
   * @param $nid
   * @return JsonResponse
   */
  function generate($type, $rid, $nid) {
    $form = DynoBlockForms::generateForm($type, $rid, $nid);
    $form['html'] = render($form['form']);
    return new JsonResponse(Json::encode($form));
  }

  /**
   * @return JsonResponse
   */
  function selectorModal() {
    $modal = new DynoblockWidgetModal();
    $modal->init();
    $response = array(Json::encode(array(
      'html' => render($modal->modal),
      'sections' => $modal->build(),
      'widgets' => $modal->widgets,
      'themes' => $modal->themes,
      'default_active' => $modal->default_active,
    )));
    return new JsonResponse($response);
  }

  /**
   * @param $method
   * @return JsonResponse
   */
  function save($method) {
    $result = $this->dynoblockCore->saveBlock($method);
    return new JsonResponse(Json::encode($result));
  }

  /**
   * @param $rid
   * @param $bid
   *
   * @return JsonResponse
   */
  function remove($rid, $bid) {
    $result = $this->dynoblockCore->removeBlock($rid, $bid);
    return new JsonResponse(Json::encode($result));
  }

  /**
   * @param $rid
   * @param $bid
   * @param $nid
   *
   * @return JsonResponse
   */
  function edit($rid, $bid, $nid) {
    $form = $this->dynoblockCore->editBlock($rid, $bid, $nid);
    $form['html'] = render($form['form']);
    return new JsonResponse(Json::encode($form));
  }

  /**
   * @param string $type
   * @param $id
   */
  function ajaxLoad($type = 'blocks', $id) {

  }

  /**
   * @param $rid
   * @param $bid
   */
  function update($rid, $bid) {

  }

  /**
   * @return array
   */
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

}
