<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\paragraphs\ParagraphInterface;
use GraphQL\Error\Error;
use Drupal\Core\Url;

/**
 * Schema extension file for paragraphs.
 *
 * @SchemaExtension(
 *   id = "drupal_paragraphs",
 *   name = @Translation("Paragraph Schema Extension"),
 *   description = @Translation("Schema extension for paragraphs"),
 *   schema = "drupal_main"
 * )
 */
class ParagraphSchemaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) : void {
    $builder = new ResolverBuilder();

    $this->addParagraphTestimonialFields($registry, $builder);
    $this->addParagraphLinkFields($registry, $builder);
  }

  /**
   * Add ParagraphInterface type resolver.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   */
  protected function addParagraphInterfaceTypeResolver(ResolverRegistryInterface $registry) : void {
    $registry->addTypeResolver('ParagraphInterface', function ($entity) {
      if ($entity instanceof ParagraphInterface) {
        switch ($entity->bundle()) {
          case 'testimonial':
            return 'ParagraphTestimonial';

          case 'link':
            return 'ParagraphLink';
        }
      }
      throw new Error('Could not resolve paragraph type.');
    });
  }

  /**
   * Add the Media base fields resolvers.
   *
   * @param string $type
   *   The Media type to add base fields.
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addParagraphBaseFields(string $type, ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {

    $registry->addFieldResolver($type, 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );
  }

  /**
   * Add ParagraphLink fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addParagraphLinkFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $this->addParagraphBaseFields('ParagraphLink', $registry, $builder);

    $registry->addFieldResolver('ParagraphLink', 'linkURL',
      $builder->compose(
        $builder->produce('property_path')
          ->map('type', $builder->fromValue('entity:paragraph'))
          ->map('value', $builder->fromParent())
          ->map('path', $builder->fromValue('field_link.uri')),
        $builder->callback(function ($uri) {
          if ($uri) {
            return Url::fromUri($uri);
          }
          return NULL;
        }),
        $builder->produce('url_path')
          ->map('url', $builder->fromParent())
      )
    );

    $registry->addFieldResolver('ParagraphLink', 'linkTitle',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:paragraph'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_link.title'))
    );
  }

  /**
   * Add ParagraphTestimonial fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addParagraphTestimonialFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $this->addParagraphBaseFields('ParagraphTestimonial', $registry, $builder);

    $registry->addFieldResolver('ParagraphTestimonial', 'name',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:paragraph'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_name.value'))
    );

    $registry->addFieldResolver('ParagraphTestimonial', 'subtitle',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:paragraph'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_subtitle.value'))
    );

    $registry->addFieldResolver('ParagraphTestimonial', 'photo',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:paragraph'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_photo.entity'))
    );

    $registry->addFieldResolver('ParagraphTestimonial', 'testimonial',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:paragraph'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_description.processed'))
    );
  }

}
