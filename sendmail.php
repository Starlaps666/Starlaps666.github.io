<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

   require 'phpmailer/src/Exception.php';
   require 'phpmailer/src/PHPMailer.php';

   $mail = new PHPMailer(true);
   $mail ->CharSet = 'UTF-8';
   $mail ->setLanguage ('ru', 'phpmailer/language');
   $mail ->IsHTML(true);

   //от кого письмо
   $mail->setFrom('garkavetsanuar@gmail.com', 'Новая заявка');
   $mail->addAddress('starlaps8@gmail.com');
   $mail->Subject = 'Новый отклик с сайта';

   //тело письма
   $body = '<h1>Письмо</h1>';

   if(trim(!empty($_POST['name']))){
   	$body.='<p><strong>Имя:</strong>'.$_POST['name'].'/p';
   }

   if(trim(!empty($_POST['phone']))){
   	$body.='<p><strong>Телефон:</strong>'.$_POST['phone'].'/p';
   }

   if(trim(!empty($_POST['massage']))){
   	$body.='<p><strong>Сообщение</strong>'.$_POST['massage'].'/p';
   }

   //прикрепить файл
   if (!empty($_FILES['image']['tmp_name'])) {
   	  //путь загрузки файла
   	  $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
   	  //грузим файл
   	  if (copy($_FILES['image']['tmp_name'], $filePath)){
   		 $fileAttach = $filePath;
   		 $body.='<p><strong>Фото в приложении</strong></p>';
   		 $mail->addAttachment($fileAttach);
   	  }
   }

   $mail->Body = $body;

   //Отправляем
   if (!mail->send()) {
   	  $message = 'Ошибка';
   } else {
   	  $message = 'Данные отправлены!';
   }

   $response = ['message' => $message];

   header('Content-type: application/json');
   echo json_encode($response);
?>
