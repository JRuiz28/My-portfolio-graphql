<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistry;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\node\NodeInterface;
use GraphQL\Error\Error;

/**
 * Schema extension file for nodes.
 *
 * @SchemaExtension(
 *   id = "drupal_nodes",
 *   name = @Translation("Node Schema Extension"),
 *   description = @Translation("Schema extension for nodes"),
 *   schema = "drupal_main"
 * )
 */
class NodeSchemaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry): void {
    $builder = new ResolverBuilder();

    $this->addNodeInterfaceTypeResolver($registry);
    $this->addNodeJobFields($registry, $builder);
    $this->addNodeProjectFields($registry, $builder);
    $this->addNodeEducationFields($registry, $builder);
  }

  /**
   * Resolves the type of node passed down from the parent.
   *
   * This needs to be resolved in order to know which data resolver to use.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   *
   * @throws \GraphQL\Error\Error
   *   Exception when the node interface couldn't be resolved.
   */
  protected function addNodeInterfaceTypeResolver(ResolverRegistryInterface $registry): void {
    $registry->addTypeResolver('NodeInterface', function ($entity) {
      if ($entity instanceof NodeInterface) {
        switch ($entity->bundle()) {

          case 'job':
            return 'NodeJob';

          case 'education':
            return 'NodeEducation';

          case 'project':
            return 'NodeProject';
        }
      }

      throw new Error('Could not resolve content type.');
    });
  }

  /**
   * {@inheritdoc}
   */
  public function addNodeBaseFields(string $type, ResolverRegistry $registry, ResolverBuilder $builder): void {

    $registry->addFieldResolver($type, 'title',
      $builder->produce('entity_label')
        ->map('entity', $builder->fromParent())
    );

  }

  /**
   * Add job field resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistry $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   */
  protected function addNodeJobFields(ResolverRegistry $registry, ResolverBuilder $builder): void {
    $this->addNodeBaseFields($type = 'NodeJob', $registry, $builder);

    $registry->addFieldResolver($type, 'companyName',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_subtitle.value'))
    );

    $registry->addFieldResolver($type, 'description',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('body.value'))
    );

        $registry->addFieldResolver($type, 'startDate',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_time_range.start_date'))
    );

    $registry->addFieldResolver($type, 'endDate',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_time_range.end_date'))
    );

    $registry->addFieldResolver($type, 'currently',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_currently.value'))
    );

  }

  /**
   * Add Project field resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistry $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   */
  protected function addNodeProjectFields(ResolverRegistry $registry, ResolverBuilder $builder): void {
    $this->addNodeBaseFields($type = 'NodeProject', $registry, $builder);

    $registry->addFieldResolver($type, 'subtitle',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_subtitle.value'))
    );

    $registry->addFieldResolver($type, 'description',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('body.value'))
    );

    $registry->addFieldResolver($type, 'image',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_image_project.entity'))
    );

    $registry->addFieldResolver($type, 'technology',
      $builder->produce('entity_reference')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_technology_unlimited'))
    );

    $registry->addFieldResolver($type, 'links',
      $builder->produce('entity_reference_revisions')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_cta_two_items'))
        ->map('bundles', $builder->fromValue(['link']))
    );
  }

  /**
   * Add education field resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistry $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   */
  protected function addNodeEducationFields(ResolverRegistry $registry, ResolverBuilder $builder): void {
    $this->addNodeBaseFields($type = 'NodeEducation', $registry, $builder);

    $registry->addFieldResolver($type, 'institution',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_university_name.value'))
    );

    $registry->addFieldResolver($type, 'description',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('body.value'))
    );

    $registry->addFieldResolver($type, 'specialization',
      $builder->produce('entity_reference')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_specialization'))
    );

    $registry->addFieldResolver($type, 'startDate',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_time_range.start_date'))
    );

    $registry->addFieldResolver($type, 'endDate',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:node'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_time_range.end_date'))
    );

  }

}

