<?php
/**
 * FORGE radio input library.
 *
 * $Id: Form_Radio.php 19215 2008-12-15 09:20:58Z bharat $
 *
 * @package    Forge
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Form_Radio_Core extends Form_Checkbox {

	protected $data = array
	(
		'type' => 'radio',
		'class' => 'radio',
		'value' => '1',
		'checked' => FALSE,
	);

} // End Form_Radio