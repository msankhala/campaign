<?php

namespace Drupal\campaign\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Campaign entity.
 *
 * @ingroup campaign
 *
 * @ContentEntityType(
 *   id = "campaign",
 *   label = @Translation("Campaign"),
 *   bundle_label = @Translation("Campaign type"),
 *   label_collection = @Translation("Campaigns"),
 *   label_singular = @Translation("Campaign"),
 *   label_plural = @Translation("Campaigns"),
 *   label_count = @PluralTranslation(
 *     singular = "@count campaign",
 *     plural = "@count campaigns",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\campaign\ListBuilder\CampaignEntityListBuilder",
 *     "views_data" = "Drupal\campaign\Entity\CampaignEntityViewsData",
 *     "translation" = "Drupal\campaign\Translation\CampaignEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\campaign\Form\CampaignEntityForm",
 *       "add" = "Drupal\campaign\Form\CampaignEntityForm",
 *       "edit" = "Drupal\campaign\Form\CampaignEntityForm",
 *       "delete" = "Drupal\campaign\Form\CampaignEntityDeleteForm",
 *       "settings" = "Drupal\campaign\Form\CampaignEntitySettingsForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\campaign\Routing\CampaignEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\campaign\Access\CampaignEntityAccessControlHandler",
 *   },
 *   base_table = "campaign",
 *   data_table = "campaign_field_data",
 *   translatable = TRUE,
 *   permission_granularity = "bundle",
 *   admin_permission = "administer campaign entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/campaigns/campaign/{campaign}",
 *     "add-page" = "/admin/campaigns/campaign/add",
 *     "add-form" = "/admin/campaigns/campaign/add/{campaign_type}",
 *     "edit-form" = "/admin/campaigns/campaign/{campaign}/edit",
 *     "delete-form" = "/admin/campaigns/campaign/{campaign}/delete",
 *     "collection" = "/admin/campaigns",
 *     "settings" = "/admin/campaigns/campaign/{campaign}/settings",
 *   },
 *   bundle_entity_type = "campaign_type",
 *   field_ui_base_route = "entity.campaign_type.edit_form"
 * )
 */
class CampaignEntity extends ContentEntityBase implements CampaignEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Campaign entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Campaign entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Campaign is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
