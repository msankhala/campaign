<?php

namespace Drupal\campaign\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Campaign type entity.
 *
 * @ConfigEntityType(
 *   id = "campaign_type",
 *   label = @Translation("Campaign type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\campaign\CampaignEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\campaign\Form\CampaignEntityTypeForm",
 *       "edit" = "Drupal\campaign\Form\CampaignEntityTypeForm",
 *       "delete" = "Drupal\campaign\Form\CampaignEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\campaign\CampaignEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "campaign_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "campaign",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/campaigns/campaign_type/{campaign_type}",
 *     "add-form" = "/admin/campaigns/campaign_type/add",
 *     "edit-form" = "/admin/campaigns/campaign_type/{campaign_type}/edit",
 *     "delete-form" = "/admin/campaigns/campaign_type/{campaign_type}/delete",
 *     "collection" = "/admin/campaigns/campaign_type"
 *   }
 * )
 */
class CampaignEntityType extends ConfigEntityBundleBase implements CampaignEntityTypeInterface {

  /**
   * The Campaign type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Campaign type label.
   *
   * @var string
   */
  protected $label;

}
