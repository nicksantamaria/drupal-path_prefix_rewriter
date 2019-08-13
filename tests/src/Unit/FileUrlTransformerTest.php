<?php

namespace Drupal\Tests\path_prefix_rewrite\Unit;

use Drupal\path_prefix_rewrite\FileUrlTransformer;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\path_prefix_rewrite\FileUrlTransformer
 */
class FileUrlTransformerTest extends UnitTestCase {

  /**
   * @covers ::transform
   *
   * @dataProvider transformTestCases
   */
  public function testTransform($url, $expected) {
    $this->assertEquals($expected, (new FileUrlTransformer())->transform($url));
  }

  /**
   * Test cases for ::transform.
   */
  public function transformTestCases() {
    return [
      [
        // Do not replace these URls, they should be replaced with the
        // 'file_public_base_url' setting.
        'public://css/css_etLg7ag8nFbax0Ht-HaO_0NhelfHgLCMQP-RJQKesKI.css',
        'public://css/css_etLg7ag8nFbax0Ht-HaO_0NhelfHgLCMQP-RJQKesKI.css',
      ],
      [
        // Local assets should be replaced.
        'themes/example_theme/css/components/promotion-block/promotion-block.css',
        'example-prefix/themes/example_theme/css/components/promotion-block/promotion-block.css',
      ],
      [
        // Existing processed should not be replaced, these should have already
        // been replaced by the 'file_public_base_url' setting.
        'http://localhost/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
        'http://localhost/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
      ],
      [
        'https://example.com/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
        'https://example.com/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
      ],
      [
        // Relative local file paths in the public file system should already
        // have been replaced.
        '/sites/default/files/styles/content_mobile_1x/public/promo-banner.jpg?itok=C9tkSVuC',
        '/sites/default/files/styles/content_mobile_1x/public/promo-banner.jpg?itok=C9tkSVuC',
      ],
      [
        'themes/example_theme/logo.svg',
        'example-prefix/themes/example_theme/logo.svg',
      ],
      [
        'core/misc/favicon.ico',
        'example-prefix/core/misc/favicon.ico',
      ],
      [
        'core/themes/stable/images/core/throbber-active.gif',
        'example-prefix/core/themes/stable/images/core/throbber-active.gif',
      ],
      [
        // Already replaced public file paths.
        '/example-prefix/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
        '/example-prefix/sites/default/files/styles/card/public/homepage-banner.jpg?itok=y4Or2qB5',
      ],
    ];
  }

}
