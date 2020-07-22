<?php

namespace Metadrop\Behat\Cores\Traits;

/**
 * Trait UsersTrait.
 */
trait UsersTrait {

  /**
   * Gets user property by name.
   *
   * This function tries to figure out which kind to identificator is refering to
   * in an "smart" way.
   *
   * @param string $name
   *   The identifier
   *   Examples: "admin", "12", "example@example.com".
   *
   * @return string
   *   The property
   */
  public function getUserPropertyByName($name) {
    if (\Drupal::service('email.validator')->isValid($name)) {
      $property = 'mail';
    }
    elseif (is_numeric($name)) {
      $property = 'uid';
    }
    else {
      $property = 'name';
    }
    return $property;
  }

  /**
   * {@inheritdoc}
   */
  public function loadUserByMail($mail) {
    $user = $this->loadUserByProperty('mail', $mail);
    Assert::notEq($user, FALSE, 'User with mail "' . $mail . '" exists.');
    return $user;
  }

  /**
   * Get user by specific property.
   *
   * @param string $property
   *   User property.
   * @param string $value
   *   Value.
   * @param string $reset
   *   Don't use cache to get user.
   *
   * @return mixed
   *   User loaded.
   */
  abstract protected function loadUserByProperty($property, $value, $reset = TRUE);

}
