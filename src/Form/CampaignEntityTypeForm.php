<?php

namespace Drupal\campaign\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CampaignEntityTypeForm.
 */
class CampaignEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $campaign_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $campaign_type->label(),
      '#description' => $this->t("Label for the Campaign type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $campaign_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\campaign\Entity\CampaignEntityType::load',
      ],
      '#disabled' => !$campaign_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $campaign_type = $this->entity;
    $status = $campaign_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Campaign type.', [
          '%label' => $campaign_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Campaign type.', [
          '%label' => $campaign_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($campaign_type->toUrl('collection'));
  }

}
