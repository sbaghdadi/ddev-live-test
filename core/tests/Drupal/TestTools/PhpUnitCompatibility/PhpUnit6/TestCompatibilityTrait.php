<?php

namespace Drupal\TestTools\PhpUnitCompatibility\PhpUnit6;

/**
 * Makes Drupal's test API forward compatible with multiple versions of PHPUnit.
 */
trait TestCompatibilityTrait {

  /**
   * @todo deprecate this method override in
   *   https://www.drupal.org/project/drupal/issues/2742585
   *
   * @see \Drupal\simpletest\TestBase::assertTrue()
   */
  public static function assertTrue($actual, $message = '') {
    if (is_bool($actual)) {
      parent::assertTrue($actual, $message);
    }
    else {
      parent::assertNotEmpty($actual, $message);
    }
  }

  /**
   * @todo deprecate this method override in
   *   https://www.drupal.org/project/drupal/issues/2742585
   *
   * @see \Drupal\simpletest\TestBase::assertFalse()
   */
  public static function assertFalse($actual, $message = '') {
    if (is_bool($actual)) {
      parent::assertFalse($actual, $message);
    }
    else {
      parent::assertEmpty($actual, $message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function assertEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE) {
    // Cast objects implementing MarkupInterface to string instead of
    // relying on PHP casting them to string depending on what they are being
    // comparing with.
    if (method_exists(self::class, 'castSafeStrings')) {
      $expected = self::castSafeStrings($expected);
      $actual = self::castSafeStrings($actual);
    }
    parent::assertEquals($expected, $actual, $message, $delta, $maxDepth, $canonicalize, $ignoreCase);
  }

}
