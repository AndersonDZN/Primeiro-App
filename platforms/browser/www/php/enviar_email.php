<?php

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: *");

	require_once("src/PHPMailer.php");
	require_once("src/Exception.php");
	require_once("src/SMTP.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
		$telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
		$dia = filter_input(INPUT_POST, "dia", FILTER_SANITIZE_STRING);
		$horario = filter_input(INPUT_POST, "horario", FILTER_SANITIZE_STRING);
		$num_paticipante = filter_input(INPUT_POST, "num_paticipante", FILTER_SANITIZE_NUMBER_INT);
		$proposito = filter_input(INPUT_POST, "proposito", FILTER_SANITIZE_STRING);

		// Dados do e-mail que vai receber todos os agendamento de visita
		$email_fixo = "anderson.worst@gmail.com";
		$nome_fixo = "Anderson";

		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com"; // Host
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "anderson@gmail.com"; // E-mail
		$mail->Password = "darkfuneral1995"; // Senha
		$mail->Port = 465;

		$mail->setFrom("anderson.worst@gmail.com", "Solicitação de Agendamento");
		$mail->addAddress($email_fixo, $nome_fixo);

		$mail->isHTML(true);
		$mail->CharSet = "UTF-8";

		$assunto = "Agendamento de Visita";

		$conteudo = "
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<p><strong>Nome:</strong> $nome</p>
			<p><strong>Telefone:</strong> $telefone</p>
			<p><strong>E-mail:</strong> $email</p>
			<p><strong>Dia:</strong> $dia</p>
			<p><strong>Horário:</strong> $horario</p>
			<p><strong>Número de Paticipante:</strong> $num_paticipante</p>
			<p><strong>Propósito:</strong> $proposito</p>
		";

		$mail->Subject = $assunto;
		$mail->Body = $conteudo;

		$status = $mail->Send();

		if ($status) {
			echo json_encode(["status" => true]);
		}
		else{
			echo json_encode(["status" => false]);
		}

	}

?>
