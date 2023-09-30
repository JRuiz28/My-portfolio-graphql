<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;

/**
 * Schema extension files.
 *
 * @SchemaExtension(
 *   id = "drupal_files",
 *   name = @Translation("Files Schema Extension"),
 *   description = @Translation("Schema extension for files"),
 *   schema = "drupal_main"
 * )
 */
class FileSchemaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) : void {
    $builder = new ResolverBuilder();

    $this->addFileFields($registry, $builder);
  }


  /**
   * Add File fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addFileFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $registry->addFieldResolver('File', 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver('File', 'label',
      $builder->produce('entity_label')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver('File', 'fileURL',
      $builder->produce('image_url')
        ->map('entity', $builder->fromParent())
    );
  }

}
