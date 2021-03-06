<?php

namespace Drupal\person_profile\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the person profile entity edit forms.
 */
class PersonProfileForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      drupal_set_message($this->t('New person profile %label has been created.', $message_arguments));
      $this->logger('person_profile')->notice('Created new person profile %label', $logger_arguments);
    }
    else {
      drupal_set_message($this->t('The person profile %label has been updated.', $message_arguments));
      $this->logger('person_profile')->notice('Created new person profile %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.person_profile.canonical', ['person_profile' => $entity->id()]);
  }

}
