<?php

namespace Drupal\path_prefix_rewrite\PathProcessor;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rewrites outbound requests to account for path prefix.
 */
class OutboundPathProcessor implements OutboundPathProcessorInterface {

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
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    $options['prefix'] = $this->config->get('path_prefix') . '/';
    return $path;
  }

}
