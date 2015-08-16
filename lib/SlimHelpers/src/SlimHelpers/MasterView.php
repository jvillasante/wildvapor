<?php

namespace SlimHelpers;

class MasterView extends \Slim\View {
  private $masterTemplate;

  public function __construct($masterTemplate) {
    parent::__construct();
    $this->masterTemplate = $masterTemplate;
  }

  public function render($template) {
    $this->setData('childView', $template);
    $template = $this->masterTemplate;
    return parent::render($template);
  }

  public function set_template($template) {
    $this->masterTemplate = $template;
  }

  public function path($path) {
    return BASE_URL . $path;
  }

  public function uploads($path) {
    return BASE_URL . 'images/uploads/' . $path;
  }

  public function uploads_small($path = '') {
    return BASE_URL . 'images/uploads/small/' . $path;
  }

  public function uploads_big($path) {
    return BASE_URL . 'images/uploads/big/' . $path;
  }

  public function uploads_thumb($path) {
    return BASE_URL . 'images/uploads/thumb/' . $path;
  }

  public function out($data, $flags = ENT_QUOTES) {
    return htmlspecialchars($data, $flags, 'UTF-8');
  }

}
