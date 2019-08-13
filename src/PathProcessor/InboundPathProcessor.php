<?php

namespace Drupal\path_prefix_rewrite\PathProcessor;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rewrites inbound requests to account for path prefix.
 */
class InboundPathProcessor implements InboundPathProcessorInterface {

  /**
   * The config.
   *
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * OutboundPathProcessor constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   *   The configuration factory.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->config = $configFactory->get('path_prefix_rewrite.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function processInbound($path, Request $request) {
    $path_prefix = $this->config->get('path_prefix');
    $path = str_replace('/' . $path_prefix, '', $path);
    if ($path === '') {
      $path = '/';
    }
    return $path;
  }

}
