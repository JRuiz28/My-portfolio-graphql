<?php

namespace Drupal\drupal_graphql;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistry;

/**
 * Interface for GraphQL entity types.
 */
interface EntitySchemaResolverInterface {

  /**
   * Resolve the default fields all GraphQL entity types must have.
   *
   * The default fields are the ones described on the NodeInterface interface in
   * the drupal_nodes.base.graphql schema.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistry $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   */
  public function resolveDefaultEntityFields(ResolverRegistry $registry, ResolverBuilder $builder): void;

}
