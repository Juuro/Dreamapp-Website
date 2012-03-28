<?php
/**
 * FORGE hidden input library.
 *
 * $Id: Form_Hidden.php 19215 2008-12-15 09:20:58Z bharat $
 *
 * @package    Forge
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Form_Hidden_Core extends Form_Input {

	protected $data = array
	(
		'name'  => '',
		'value' => '',
	);

	public function render()
	{
		return form::hidden($this->data['name'], $this->data['value']);
	}

} // End Form Hidden