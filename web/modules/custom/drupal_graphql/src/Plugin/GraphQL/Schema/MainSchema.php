<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\Schema;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistry;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\Schema\SdlSchemaPluginBase;

/**
 * The entry point to the main schema.
 *
 * @Schema(
 *   id = "drupal_main",
 *   name = @Translation("Main Schema"),
 *   description = @Translation("The main schema entrypoint")
 * )
 */
class MainSchema extends SdlSchemaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getResolverRegistry(): ResolverRegistryInterface {
    $builder = new ResolverBuilder();
    $registry = new ResolverRegistry();

    $this->addQueryFields('Query', $registry, $builder);

    return $registry;
  }

  /**
   * Add query field resolvers.
   *
   * @param string $type_name
   *   The GraphQL schema type name to resove fields to.
   * @param \Drupal\graphql\GraphQL\ResolverRegistry $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   */
  protected function addQueryFields(string $type_name, ResolverRegistry $registry, ResolverBuilder $builder): void {

    $registry->addFieldResolver($type_name, 'routeUser',
      $builder->compose(
        $builder->produce('route_load')
          ->map('path', $builder->fromArgument('username')),
        $builder->produce('route_entity')
          ->map('url', $builder->fromParent())
      )
    );

  }

}
