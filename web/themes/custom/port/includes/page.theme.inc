<?php

use Drupal\Core\Site\Settings;

/**
 * @file
 * Functions to support theming pages.
 */

/**
 * Prepares variables for profile templates.
 *
 * Default template: user.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing rendered fields.
 *   - attributes: HTML attributes for the containing element.
 */
function port_preprocess_user(&$variables) {
  /** @var \Drupal\user\Entity\User $user */
  $user = $variables['elements']['#user'];

  // Looking for user has content type.
  $hasJobContent = _userHasContentType($user, 'job');
  $hasProjectContent = _userHasContentType($user, 'project');
  $hasEducationContent = _userHasContentType($user, 'education');

  $variables['user_has_job_content'] = $hasJobContent;
  $variables['user_has_project_content'] = $hasProjectContent;
  $variables['user_has_education_content'] = $hasEducationContent;

  // Get url and endpoint graphql.
  $current_url = \Drupal::request()->getUri();
  $url = parse_url($current_url, PHP_URL_HOST);

  $config = \Drupal::config('graphql.graphql_servers.main');
  $endpoint = $config->get('endpoint');

  $variables['endpoint'] = $url . $endpoint;

}

/**
 * Validate if user has specific content type.
 *
 * @param \Drupal\user\Entity\User $user
 *   Validate user.
 * @param string $contentTypeMachineName
 *   Name machine of content type for search.
 *
 * @return bool
 */
function _userHasContentType($user, $contentTypeMachineName) {
  // Get entity manager.
  $entityTypeManager = \Drupal::entityTypeManager();

  $query = $entityTypeManager->getStorage('node')
    ->getQuery()
    ->condition('type', $contentTypeMachineName)
    ->condition('uid', $user->id());
  $query->accessCheck(FALSE);

  $result = $query->execute();

  return !empty($result);
}
