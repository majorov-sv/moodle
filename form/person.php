<?php
/* поле phone для ботов */
if (isset($_POST['phone']) && !empty($_POST['phone'])) {
	exit;
}

/* прием и проверка названия курса */
if (isset($_POST['sent_course'])) {
	if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\(\)\.\:\-\+, ]+$/u',$_POST['sent_course'])) {
		exit;
	}

	if (mb_strlen($_POST['sent_course'],'UTF-8') > 255) {
		exit;
	}
	
	$pre_course = $_POST['sent_course'];
} ELSE {
	$pre_course = "";	
}
/* конец описания приема и проверки */

require_once('../config.php');
global $CFG, $PAGE;

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('frontpage');
$PAGE->set_title('Заявка на обучение');
$PAGE->set_heading('Заявка на обучение');
$PAGE->set_url($CFG->wwwroot.'/form/person.php');
echo $OUTPUT->header();

if (isset($_POST['submit'])) {
	
	/* КУРС */
	if (isset($_POST['course']) && !empty($_POST['course'])) {
		$course = $_POST['course'];
		
		$course = strip_tags($course);
		$course = stripslashes($course);
		$course = htmlspecialchars($course, ENT_QUOTES);
		
		if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\(\)\.\:\-\+, ]+$/u',$course) OR mb_strlen($course,'UTF-8') > 255) {
			unset($course);
			unset($_POST['course']);
		}
    } else {
		$empty_field = 1;
	}
	
	/* ОРГАНИЗАЦИЯ */
	if (isset($_POST['org']) && !empty($_POST['org'])) {
		$org = $_POST['org'];
		
		$org = strip_tags($org);
		$org = stripslashes($org);
		$org = trim($org);
		
		$mistake_org = "";
				
		if (mb_strlen($org,'UTF-8') < 3) {
			$mistake_org .= "Введено слишком мало символов в строку &laquo;Организация&raquo;. Минимальное количество символов: 3.<br>";
		}		
		if (mb_strlen($org,'UTF-8') > 82) {
			$mistake_org .= "Введено слишком длинное название организации \ места работы.<br>";
		}		
		if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9№\., \-\+\"]+$/u',$org)) {
			$mistake_org .= "В строку &laquo;Организация&raquo; можно вводить буквы, цифры и следующие символы:<br> точка, запятая, пробел, дефис, знак плюс, знак № и двойные кавычки.<br>";			
		}
				
		$org = htmlspecialchars($org, ENT_QUOTES);
    } else {
		$empty_field = 1;
	}
	
	/* ФАМИЛИЯ */
	if (isset($_POST['lastname']) && !empty($_POST['lastname'])) {
		$lastname = $_POST['lastname'];
		
		$lastname = strip_tags($lastname);
		$lastname = stripslashes($lastname);
		$lastname = trim($lastname);
		$lastname = htmlspecialchars($lastname, ENT_QUOTES);
		
		$mistake_lastname = "";
	
		if (mb_strlen($lastname,'UTF-8') < 2) {
			$mistake_lastname .= "Введено слишком мало символов в строку &laquo;Фамилия&raquo;. Минимальное количество символов: 2.<br>";
		}	
		if (mb_strlen($lastname,'UTF-8') > 35) {
			$mistake_lastname .= "Длина фамилии не может превышать 35 символов.<br>";
		}	
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z\-]+$/u',$lastname)) {
			$mistake_lastname .= "В строку &laquo;Фамилия&raquo; можно вводить только буквы и символ дефиса.<br>";
		}
    } else {
		$empty_field = 1;
	}
	
	/* ИМЯ */
	if (isset($_POST['name']) && !empty($_POST['name'])) {
		$name = $_POST['name'];
		
		$name = strip_tags($name);
		$name = stripslashes($name);
		$name = trim($name);
		$name = htmlspecialchars($name, ENT_QUOTES);
		
		$mistake_name = "";
	
		if (mb_strlen($name,'UTF-8') < 2) {
			$mistake_name .= "Введено слишком мало символов в строку &laquo;Имя&raquo;. Минимальное количество символов: 2.<br>";
		}
		if (mb_strlen($name,'UTF-8') > 25) {
			$mistake_name .= "Длина имени не может превышать 25 символов.<br>";
		}
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z\-]+$/u',$name)) {
			$mistake_name .= "В строку &laquo;Имя&raquo; можно вводить только буквы и символ дефиса.<br>";
		}
    } else {
		$empty_field = 1;
	}
	
	/* ОТЧЕСТВО */
	if (isset($_POST['otch']) && !empty($_POST['otch'])) {
		$otch = $_POST['otch'];
		
		$otch = strip_tags($otch);
		$otch = stripslashes($otch);
		$otch = trim($otch);
		$otch = htmlspecialchars($otch, ENT_QUOTES);
		
		$mistake_otch = "";
		
		if (mb_strlen($otch,'UTF-8') < 3) {
			$mistake_otch .= "Введено слишком мало символов в строку &laquo;Отчество&raquo;. Минимальное количество символов: 3.<br>";
		}
		if (mb_strlen($otch,'UTF-8') > 25) {
			$mistake_otch .= "Длина отчества не может превышать 25 символов.<br>";
		}
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z\-]+$/u',$otch)) {
			$mistake_otch .= "В строку &laquo;Отчество&raquo; можно вводить только буквы и символ дефиса.<br>";
		}
    } else {
		$empty_field = 1;
	}
	
	/* ДОЛЖНОСТЬ */
	if (isset($_POST['dolzh']) && !empty($_POST['dolzh'])) {
		$dolzh = $_POST['dolzh'];
		
		$dolzh = strip_tags($dolzh);
		$dolzh = stripslashes($dolzh);
		$dolzh = trim($dolzh);
		$dolzh = htmlspecialchars($dolzh, ENT_QUOTES);
		
		$mistake_dolzh = "";
	
		if (mb_strlen($dolzh,'UTF-8') < 3) {
			$mistake_dolzh .= "Введено слишком мало символов в строку &laquo;Должность&raquo;. Минимальное количество символов: 3.<br>";
		}
		if (mb_strlen($dolzh,'UTF-8') > 130) {
			$mistake_dolzh .= "Длина должности не может превышать 130 символов.<br>";
		}
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z0-9, \.\-]+$/u',$dolzh)) {
			$mistake_dolzh .= "В строку &laquo;Должность&raquo; можно вводить буквы, цифры и следующие символы:<br> точка, запятая, пробел, дефис.<br>";
		}
    } else {
		$empty_field = 1;
	}
	
	/* ТЕЛЕФОН */
	if (isset($_POST['tel']) && !empty($_POST['tel'])) {
		$tel = $_POST['tel'];
		
		$tel = strip_tags($tel);
		$tel = stripslashes($tel);
		$tel = trim($tel);
		$tel = htmlspecialchars($tel, ENT_QUOTES);
		
		$mistake_tel = "";
	
		if (mb_strlen($tel,'UTF-8') < 5) {
			$mistake_tel .= "Введен слишком короткий номер телефона. Минимальное количество символов: 5.<br>";
		}
		if (mb_strlen($tel,'UTF-8') > 39) {
			$mistake_tel .= "Введен слишком длинный номер телефона.<br>";
		}
		if (!preg_match('/^[0-9+, \(\)-]+$/u',$tel)) {
			$mistake_tel .= "Номер введен некорректно. Пример номера: 8(923)310-22-11.<br> Если необходимо ввести несколько номеров, перечислите их через запятую.";
		}
    } else {
		$empty_field = 1;
	}
	
	
	/* E-MAIL */
	if (isset($_POST['email']) && !empty($_POST['email'])) {
		$email = $_POST['email'];
		
		$email = strip_tags($email);
		$email = stripslashes($email);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		$mistake_email = "";
	
		if (mb_strlen($email,'UTF-8') < 6) {
			$mistake_email .= "Введен слишком короткий адрес электронной почты.<br>";
		}
		if (mb_strlen($email,'UTF-8') > 80) {
			$mistake_email .= "Введен слишком длинный адрес электронной почты.<br>";
		}
    } else {
		$empty_field = 1;
	}
	
	/* ОБРАЗОВАНИЕ */
	if (isset($_POST['obr']) && !empty($_POST['obr'])) {
		$obr = $_POST['obr'];
		
		$obr = strip_tags($obr);
		$obr = stripslashes($obr);
		$obr = trim($obr);
		$obr = htmlspecialchars($obr, ENT_QUOTES);
	
		$mistake_obr = "";
		
		if (mb_strlen($obr,'UTF-8') < 3) {
			$mistake_obr .= "Введено слишком мало символов в строку &laquo;Образование&raquo;. Минимальное количество символов: 3.<br>";
		}
		if (mb_strlen($obr,'UTF-8') > 85) {
			$mistake_obr .= "Введен слишком длинный текст в поле &laquo;Образование&raquo;.<br>";
		}
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z0-9, \.\-]+$/u',$obr)) {
			$mistake_obr .= "В строку &laquo;Образование&raquo; можно вводить буквы, цифры и следующие символы:<br> точка, запятая, пробел, дефис.<br>";
		}
    } else {
		$empty_field = 1;
	}
}
?>	
	<form method="post" class="zakaz" name="form1">
    <div class="submit-row">		
		<div class="label">Курс</div>
		<div class="input">
			<input name="course" type="text" 
				value="<?php if (empty($course)) {echo $pre_course;} else {echo $course;}?>" 
				title="<?php if (empty($course)) {echo $pre_course;} else {echo $course;}?>" readonly>
		</div>		
	</div>
	
	<div class="submit-row">
		<div class="label">Организация \ место работы</div>
		<div class="input"><input name="org" type="text" value="<?php if (isset($org)) echo $org; ?>"></div>
		<?php 
			if (!empty($mistake_org)) {
				echo '<span class="error_msg">';
				echo $mistake_org;
				echo '</span>';
			}				
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">Фамилия</div>
		<div class="input"><input name="lastname" type="text" value="<?php if (isset($lastname)) echo $lastname; ?>"></div>
		<?php 
			if (!empty($mistake_lastname)) {
				echo '<span class="error_msg">';
				echo $mistake_lastname;
				echo '</span>';
			}
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">Имя</div>
		<div class="input"><input name="name" type="text" value="<?php if (isset($name)) echo $name; ?>"></div>
		<?php 
			if (!empty($mistake_name)) {
				echo '<span class="error_msg">';
				echo $mistake_name;
				echo '</span>';
			}
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">Отчество</div>
		<div class="input"><input name="otch" type="text" value="<?php if (isset($otch)) echo $otch; ?>"></div>
		<?php 
			if (!empty($mistake_otch)) {
				echo '<span class="error_msg">';
				echo $mistake_otch;
				echo '</span>';
			}
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">Должность</div>
		<div class="input"><input name="dolzh" type="text" value="<?php if (isset($dolzh)) echo $dolzh; ?>"></div>
		<?php 
			if (!empty($mistake_dolzh)) {
				echo '<span class="error_msg">';
				echo $mistake_dolzh;
				echo '</span>';
			}
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">Телефон</div>
		<div class="input"><input name="tel" type="text" value="<?php if (isset($tel)) echo $tel; ?>"></div>
		<?php 
			if (!empty($mistake_tel)) {
				echo '<span class="error_msg">';
				echo $mistake_tel;
				echo '</span>';
			}			
		?>
	</div>
	
	
	<div class="submit-row">
		<div class="label">E-mail</div>
		<div class="input"><input name="email" type="text" value="<?php if (isset($email)) echo $email; ?>"></div>
		<?php 
			if(isset($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo '<p class="error_msg">Введите, пожалуйста, корректный адрес электронной почты.</p>';
				$incor_email = "true";
			}
			
			if (!empty($mistake_email)) {
				echo '<span class="error_msg">';
				echo $mistake_email;
				echo '</span>';
			}
		?>
	</div>
		
	<div class="submit-row">
		<div class="label">Образование</div>
		<div class="input"><input name="obr" type="text" value="<?php if (isset($obr)) echo $obr; ?>"></div>
		<?php 
			if (!empty($mistake_obr)) {
				echo '<span class="error_msg">';
				echo $mistake_obr;
				echo '</span>';
			}
		?>
	</div>
	
	<input name="phone" type="text" class="simple-field">
	
	<div class="checkbox-and-text">
	<?php		
		if (isset($_POST['confirm']) && $_POST['confirm'] == "on") {
			echo '<input type="checkbox" name="confirm" value="on" checked>';
			$checked = "yes";			
		} else {
			echo '<input type="checkbox" name="confirm" value="on">';			
		}
	?> Я подтверждаю своё согласие на передачу информации в электронной форме уведомления (в том числе персональных данных) по открытым каналам связи сети Интернет.
	</div>	
	
	<?php
	if (isset($_POST['submit']) && empty($_POST['phone'])) {
		if (!isset($checked)) {
			echo '<p class="error_msg">Необходимо подтвердить своё согласие на передачу информации по открытым каналам связи сети Интернет.</p>';
		}
		
		if (!isset($empty_field)) {
			if (isset($checked) && empty($incor_email) && empty($mistake_org) && empty($mistake_lastname) && empty($mistake_name) && empty($mistake_otch) && empty($mistake_dolzh) && empty($mistake_tel) && empty($mistake_obr)) {
				/* Готовим и отправляем письмо в учеб_центр */
				$to = "majorov_sv@skc-fmba.ru, kryilova_oo@skc-fmba.ru";
				$subject = "Заявка на дистанционное обучение - физ. лицо";
				$message = "
					\r\nКурс: $course
					\r\nОрганизация: $org
					\r\nФамилия: $lastname
					\r\nИмя: $name
					\r\nОтчество: $otch
					\r\nДолжность: $dolzh
					\r\nТелефон: $tel
					\r\nE-mail: $email
					\r\nОбразование: $obr
				";
										
				if (mail($to, "$subject", "$message", "Content-type:text/plain; charset = utf-8\r\nFrom:Дистанционное обучение")) {
					echo "<p><strong>Заявка отправлена.</strong></p>";
				} else {
					echo "<p><strong>К сожалению, во время отправки произошла ошибка. Попробуйте, пожалуйста, позже. Либо сообщите о проблеме по электронной почте: <span style='white-space: nowrap'>kryilova_oo@skc-fmba.ru</span></strong></p>";
				}
				/* //Готовим и отправляем письмо в учеб_центр */
					
				$email = htmlspecialchars($email, ENT_QUOTES);
			}
		}
		else {
			echo '<p class="error_msg">Заполните, пожалуйста, все поля формы.</p>';			
		}
	}
	?>
	
	<p><input name="submit" type="submit" value="Отправить заявку"></p>
    </form>
<?php
	echo $OUTPUT->footer();
?>