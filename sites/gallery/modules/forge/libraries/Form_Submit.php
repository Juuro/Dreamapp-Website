<?php
/**
 * FORGE submit input library.
 *
 * $Id: Form_Submit.php 19730 2009-01-12 07:37:34Z bharat $
 *
 * @package    Forge
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Form_Submit_Core extends Form_Input {

	protected $data = array
	(
		'type'  => 'submit',
		'class' => 'submit'
	);

	protected $protect = array('type');

	public function render()
	{
		$data = $this->data;
		unset($data['label']);

		return form::submit($data);
	}

} // End Form Submit