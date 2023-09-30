<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\user\UserInterface;
use GraphQL\Error\Error;

/**
 * Schema extension file for users.
 *
 * @SchemaExtension(
 *   id = "drupal_users",
 *   name = @Translation("User Schema Extension"),
 *   description = @Translation("Schema extension for users"),
 *   schema = "drupal_main"
 * )
 */
class UserSchemaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) : void {
    $builder = new ResolverBuilder();

    $this->addUserInterfaceTypeResolver($registry);
    $this->addUserFields($registry, $builder);

  }

  /**
   * Add UserInterface type resolver.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   */
  protected function addUserInterfaceTypeResolver(ResolverRegistryInterface $registry) : void {
    // Tell GraphQL how to resolve types of a common interface.
    $registry->addTypeResolver('UserInterface', function ($value) {
      if ($value instanceof UserInterface) {
        $user_roles = $value->getRoles(TRUE);
        if (in_array('portfolio_exporter', $user_roles)) {
          return 'User';
        }
      }
      throw new Error('Could not resolve user role.');
    });
  }

  /**
   * Add the User base fields resolvers.
   *
   * @param string $type
   *   The User type to add base fields.
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addUserBaseFields(string $type, ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {

    $registry->addFieldResolver($type, 'username',
      $builder->produce('entity_label')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver($type, 'email',
      $builder->callback(function ($user) {
        return $user->getEmail();
      }
    ));

  }

  /**
   * Add Landing page fields resolvers.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The registry interface.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The builder.
   */
  protected function addUserFields(ResolverRegistryInterface $registry, ResolverBuilder $builder) : void {
    $type = 'User';
    $this->addUserBaseFields($type, $registry, $builder);


    $registry->addFieldResolver($type, 'name',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_name.value'))
    );

    $registry->addFieldResolver($type, 'lastname',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_last_name.value'))
    );

    $registry->addFieldResolver($type, 'phone',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_phone_number.value'))
    );

    $registry->addFieldResolver($type, 'summary',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_description.summary'))
    );

    $registry->addFieldResolver($type, 'aboutme',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_description.value'))
    );

    $registry->addFieldResolver($type, 'location',
      $builder->produce('entity_reference')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_address'))
    );

    $registry->addFieldResolver($type, 'photo',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('user_picture.entity'))
    );

    $registry->addFieldResolver($type, 'resume',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_resume.entity'))
    );

    $registry->addFieldResolver($type, 'resume',
      $builder->produce('property_path')
        ->map('type', $builder->fromValue('entity:user'))
        ->map('value', $builder->fromParent())
        ->map('path', $builder->fromValue('field_resume.entity'))
    );

    $registry->addFieldResolver($type, 'testimonial',
      $builder->produce('entity_reference')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_testimonial_three_items'))
        ->map('bundles', $builder->fromValue(['testimonial']))
    );

    $registry->addFieldResolver($type, 'educations',
      $builder->produce('query_user_content')
        ->map('entity', $builder->fromParent())
        ->map('bundles', $builder->fromValue(['education']))
    );

    $registry->addFieldResolver($type, 'projects',
      $builder->produce('query_user_content')
        ->map('entity', $builder->fromParent())
        ->map('bundles', $builder->fromValue(['project']))
    );

    $registry->addFieldResolver($type, 'jobs',
      $builder->produce('query_user_content')
        ->map('entity', $builder->fromParent())
        ->map('bundles', $builder->fromValue(['job']))
    );
  }

}
