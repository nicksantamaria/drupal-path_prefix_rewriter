<?php

namespace Drupal\path_prefix_rewrite\EventSubscriber;

use Drupal\Core\Site\Settings;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * An event subscriber for setting the public base URL variable.
 */
class PublicBaseUrlSetSubscriber implements EventSubscriberInterface {

  /**
   * Authenticates user on request.
   */
  public function onRequest(GetResponseEvent $event) {
    // The file_public_base_url must include a protocol for it to be compatible
    // with certain parts of the site, like AJAX file uploads. Unless the URL
    // for each environment is hard coded, this must be set from the request
    // which calculates it from globals and respects the reverse proxy
    // configuration.
    $base_url = \Drupal::request()->getSchemeAndHttpHost();
    $settings = Settings::getAll();

    $config = \Drupal::config("path_prefix_rewrite.settings");
    $prefix = $config->get("path_prefix");
    if (!empty($prefix)) {
        $settings['file_public_base_url'] = sprintf("%s/%s/sites/default/files", $base_url, $prefix);
        new Settings($settings);
    }


  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onRequest', 300];
    return $events;
  }

}
