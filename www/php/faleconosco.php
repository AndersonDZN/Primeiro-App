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
		$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
		$mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_STRING);

		// Dados do e-mail que vai receber todos os agendamento de visita
		$email_fixo = " EMAIL";
		$nome_fixo = "	NOME";

		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com"; // Host
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "EMAIL"; // E-mail
		$mail->Password = "dPASSOWORD"; // Senha
		$mail->Port = 465;

		$mail->setFrom("EMAIL", "fale conosco");
		$mail->addAddress($email_fixo, $nome_fixo);

		$mail->isHTML(true);
		$mail->CharSet = "UTF-8";

		$assunto = "fale conosco";

		$conteudo = "
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<p><strong>Nome:</strong> $nome</p>
			<p><strong>E-mail:</strong> $email</p>
			<p><strong>Mensagem:</strong> $mensagem</p>
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
