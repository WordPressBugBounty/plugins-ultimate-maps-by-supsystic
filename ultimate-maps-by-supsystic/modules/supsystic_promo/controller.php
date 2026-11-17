<?php
class supsystic_promoControllerUms extends controllerUms
{
  /**
   * Saves the answer to the review card (models/review.php): rate, done, later, support or close.
   */
  public function umsSaveReviewAnswer()
  {
    $res = new responseUms();
    $answer = reqUms::getVar('answer', 'post');
    $model = $this->getModel('review');
    if (!$model || !$model->saveAnswer(get_current_user_id(), is_string($answer) ? $answer : '')) {
      $res->pushError(__('Unknown answer.', UMS_LANG_CODE));
    }
    $res->ajaxExec();
  }
  public function getNoncedMethods()
  {
    return ['umsSaveReviewAnswer'];
  }
  /**
   * The card is shown to the users allowed to use the plugin (the access roles of the settings), not only to admins.
   */
  public function getPermissions()
  {
    return [
      UMS_METHODS => [
        'umsSaveReviewAnswer' => [UMS_ADMIN, UMS_LOGGED],
      ],
    ];
  }
}
