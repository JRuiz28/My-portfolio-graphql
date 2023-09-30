<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;

/**
 * Schema extension file for taxonomies.
 *
 * @SchemaExtension(
 *   id = "drupal_taxonomies",
 *   name = @Translation("Taxonomy Schema Extension"),
 *   description = @Translation("Schema extension for taxonomies"),
 *   schema = "drupal_main"
 * )
 */
class TaxonomySchemaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) : void {
    $builder = new ResolverBuilder();

    $this->addTaxonomyTermParentsFields($registry, $builder);
    $this->addTaxonomyTermFields($registry, $builder);
  }

  /**
   * Add TaxonomyTermParents fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addTaxonomyTermParentsFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $registry->addFieldResolver('TaxonomyTermParents', 'taxonomyTerms',
      $builder->produce('taxonomy_load_all_parents')
        ->map('tid', $builder->produce('entity_id')
          ->map('entity', $builder->fromParent()))
    );
  }

  /**
   * Add TaxonomyTermParents fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addTaxonomyTermFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $registry->addFieldResolver('TaxonomyTerm', 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver('TaxonomyTerm', 'label',
      $builder->produce('entity_label')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver('TaxonomyTerm', 'children',
      $builder->compose(
        $builder->produce('taxonomy_load_tree')
          ->map('vid', $builder->produce('entity_bundle')
            ->map('entity', $builder->fromParent()))
          ->map('parent', $builder->produce('entity_id')
            ->map('entity', $builder->fromParent()))
          ->map('max_depth', $builder->fromValue(1))
      )
    );
  }

}
