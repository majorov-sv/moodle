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
$PAGE->set_url($CFG->wwwroot.'/form/firm.php');
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
	
	/* АДРЕС */
	if (isset($_POST['adress']) && !empty($_POST['adress'])) {
		$adress = $_POST['adress'];
		
		$adress = strip_tags($adress);
		$adress = stripslashes($adress);
		$adress = trim($adress);
		$adress = htmlspecialchars($adress, ENT_QUOTES);
		
		$mistake_adress = "";
	
		if (mb_strlen($adress,'UTF-8') < 3) {
			$mistake_adress .= "Введено слишком мало символов в строку &laquo;Адрес&raquo;. Минимальное количество символов: 3.<br>";
		}	
		if (mb_strlen($adress,'UTF-8') > 255) {
			$mistake_adress .= "Длина адреса не может превышать 255 символов.<br>";
		}	
		if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9№\(\)\.\-, ]+$/u',$adress)) {
			$mistake_adress .= "В строку &laquo;Адрес&raquo; можно вводить буквы, цифры и следующие символы:<br> точка, запятая, пробел, дефис, знак № и скобки.<br>";
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
	
	/* Ф.И.О. */
	if (isset($_POST['fio']) && !empty($_POST['fio'])) {
		$fio = $_POST['fio'];
		
		$fio = strip_tags($fio);
		$fio = stripslashes($fio);
		$fio = trim($fio);
		$fio = htmlspecialchars($fio, ENT_QUOTES);
	
		$mistake_fio = "";
		
		if (mb_strlen($fio,'UTF-8') < 3) {
			$mistake_fio .= "Введено слишком мало символов в строку &laquo;Ф.И.О.&raquo;. Минимальное количество символов: 3.<br>";
		}
		if (mb_strlen($fio,'UTF-8') > 63) {
			$mistake_fio .= "Введен слишком длинный текст в поле &laquo;Ф.И.О.&raquo;.<br>";
		}
		if (!preg_match('/^[а-яА-ЯёЁa-zA-Z\-\. ]+$/u',$fio)) {
			$mistake_fio .= "В строку &laquo;Ф.И.О.&raquo; можно вводить буквы и следующие символы: пробел, точка, дефис.";
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
		<div class="label">Адрес (полный адрес)</div>
		<div class="input"><input name="adress" type="text" value="<?php if (isset($adress)) echo $adress; ?>"></div>
		<?php 
			if (!empty($mistake_adress)) {
				echo '<span class="error_msg">';
				echo $mistake_adress;
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
		<div class="label">Ф.И.О.</div>
		<div class="input"><input name="fio" type="text" value="<?php if (isset($fio)) echo $fio; ?>"></div>
		<?php 
			if (!empty($mistake_fio)) {
				echo '<span class="error_msg">';
				echo $mistake_fio;
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
			if (isset($checked) && empty($mistake_org) && empty($mistake_adress) && empty($incor_email) && empty($mistake_tel) && empty($mistake_fio)) {
				/* Готовим и отправляем письмо в учеб_центр */
				$to = "majorov_sv@skc-fmba.ru, kryilova_oo@skc-fmba.ru";
				$subject = "Заявка на дистанционное обучение - юр. лицо";
				$message = "
					\r\nКурс: $course
					\r\nОрганизация: $org
					\r\nАдрес: $adress
					\r\nE-mail: $email
					\r\nТелефон: $tel
					\r\nФИО: $fio
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