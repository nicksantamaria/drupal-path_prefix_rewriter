<?php

namespace Drupal\path_prefix_rewrite;

/**
 * Transform file urls.
 */
class FileUrlTransformer {

  /**
   * Transform a file URI to the path prefix subpath version.
   *
   * @param string $uri
   *   The URI.
   *
   * @return string
   *   The return URI.
   */
  public function transform($uri) {
    $config = \Drupal::config("path_prefix_rewrite.settings");
    $prefix = $config->get("path_prefix");
    if (empty($prefix)) {
      return $uri;
    }

    $ignore_files_starting_with = [
      '/',
      'http',
      'public:',
    ];
    foreach ($ignore_files_starting_with as $ignore_files_starting_with_path) {
      if (strpos($uri, $ignore_files_starting_with_path) === 0) {
        return $uri;
      }
    }

    return sprintf('%s/%s', $prefix, $uri);
  }

}
