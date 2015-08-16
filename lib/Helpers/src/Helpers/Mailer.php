<?php

namespace Helpers;

class Mailer {
  private $data;
  private $error;

  public function __construct($data) {
    $this->data = $data;
  }

  public function sendMail() {
    try {
      $this->mailWithAttachment();
      return true;
    } catch (\Exception $e) {
      $this->error = $e->getMessage();
      return false;
    }
  }

  public function getError() {
    return $this->error;
  }

  private function mailWithAttachment() {
    $data = $this->data;

    $mail = new \PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = $data['mail_username'];
    $mail->Password = $data['mail_password'];

    $mail->From = $data['mail_from'];
    $mail->FromName = 'WildVapor';
    $mail->AddAddress($data['mail_to_address'], $data['mail_to_name']);
    $mail->Subject = $data['subject'];
    $mail->MsgHTML($data['body']);
    $mail->AltBody = strip_tags($data['body']);


    if ($mail->Send()) {
      return true;
    } else {
      throw new \Exception('Mailer Error: ' . $mail->ErrorInfo);
    }
  }
}
