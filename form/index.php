<?php
/* прием и проверка названия курса */
if (isset($_POST['sent_course'])) {
	if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\(\)\.\:\-\+, ]+$/u',$_POST['sent_course'])) {
		exit;
	}

	if (mb_strlen($_POST['sent_course'],'UTF-8') > 255) {
		exit;
	}
	
	$pre_course = $_POST['sent_course'];
}
/* конец описания приема и проверки */

require_once('../config.php');
global $CFG, $PAGE;

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('frontpage');
$PAGE->set_title('Оставьте заявку на обучение');
$PAGE->set_heading('Оставьте заявку на обучение');
$PAGE->set_url($CFG->wwwroot.'/form/index.php');
echo $OUTPUT->header();

if (!isset($_POST['sent_course'])) {
	echo '<p>Для выбора курса и оформления заявки перейдите, пожалуйста, <a href="'.$CFG->wwwroot.'/course">к списку курсов.</a></p>';
	echo $OUTPUT->footer();
	exit;
}
?>	
	<form method="post" name="course_request" action="person.php" style="float: left;">
		<input name="sent_course" type="hidden" value="<?php echo $pre_course; ?>">
		<input name="person" type="submit" value="Физическое лицо" class="open-form-button">
    </form>
	
	<form method="post" name="course_request" action="firm.php">
		<input name="sent_course" type="hidden" value="<?php echo $pre_course; ?>">
		<input name="firm" type="submit" value="Юридическое лицо" class="open-form-button">
    </form>
<?php
	echo $OUTPUT->footer();
?>