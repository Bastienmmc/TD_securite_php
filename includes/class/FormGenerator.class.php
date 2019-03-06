<?php

/**
 * Generator of differents forms
 * 
 */
class FormGenerator {
	protected $content;
	protected $inputType;
	protected $buttonType;

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	/**
	 * Constructor class
	 * @param string $action
	 * @param string $method
	 * @throws Exception
	 */
	public function __construct($action, $method) {
		if ( !is_string($action) ) {
			throw new Exception('Action required a string value', 1);
		}

		if ( $method !== self::METHOD_GET && $method !== self::METHOD_POST ) {
			throw new Exception('Method required a '.__CLASS__.' method constant', 2);
		}

		$this->listInputType();
		$this->listButtonType();

		$content = '<form action="'.$action.'" method="'.$method.'">'."\n"."%s\n</form>\n";
		$this->setContent( $content );
	}

	/**
	 * Delete %s mark in form
	 */
	private function deleteMark() {
		$content = $this->getContent();
		$content = sprintf($content, '');
		$this->setContent($content);
	}

	/**
	 * Add HTML structure in form
	 * @param string $name
	 */
	private function addStruct($name) {
		$struct = '';
		$struct .= "<!DOCTYPE html>\n";
		$struct .= "<html>\n<head>\n";
		$struct .= '<meta charset="utf-8">'."\n";
		$struct .= "<title>".$name."</title>\n";
		$struct .= "</head>\n<body>\n";
		$struct .= $this->getContent();
		$struct .= "</body>\n</html>\n";

		return $struct;
	}

	/**
	 * Display form
	 * @param string $name
	 * @param string $struct
	 */
	public function displayForm($name = '', $struct = false) {
		$this->deleteMark();

		if ( $struct ) {
			echo $this->addStruct($name);
		}
		else {
			echo $this->getContent();
		}
	}

	/**
	 * Return an string form
	 * @param string $name
	 * @param string $struct
	 * @return string
	 */
	public function returnForm($name = '', $struct = false) {
		if ( $struct ) {
			return $this->addStruct($name);
		}
		else {
			return $this->getContent();
		}
	}

	/**
	 * Insert list of input type
	 */
	protected function listInputType() {
		$list = 'button|checkbox|color|date|datetime|datetime-local|email';
		$list .= '|file|hidden|image|month|number|password|radio|range|reset';
		$list .= '|search|submit|tel|text|time|url|week';

		$this->setInputType($list);
	}

	/**
	 * Insert list of button type
	 */
	protected function listButtonType() {
		$list = 'button|reset|submit';

		$this->setButtonType($list);
	}

	/**
	 * Is field type exist in list
	 * @param string $fieldName
	 * @param string $typeField
	 * @throws Exception
	 * @return boolean
	 */
	protected function isFieldType($fieldName, $typeField) {
		switch ($fieldName) {
			case 'input':
				$type = $this->getInputType();
			break;

			case 'button':
				$type = $this->getButtonType();
			break;

			default:
				throw new Exception('Fieldtype is not valid');
			break;
		}

		$tok = strtok($type, '|');

		while ($tok !== false) {
			if ( $tok === $typeField ) {
				return true;
			}
			$tok = strtok('|');
		}

		return false;
	}

	/**
	 * add attributes in selected field
	 * @param array $list
	 * @return string
	 */
	protected function addAttributes($list) {
		$attributes = '';

		foreach ($list as $key => $val) {
			if ( $val === NULL ) {
				$attributes .= ' '.$key;
			}
			else {
				$attributes .= ' '.$key.'="'.$val.'"';
			}
		}

		return $attributes;
	}

	/**
	 * Add label field
	 * @param string $name
	 * @param string or numeric $text
	 * @throws Exception
	 */
	public function addLabel($name, $text) {
		if ( !is_string($name) ) {
			throw new Exception('Label name is required', 3);
		}

		if ( !is_string($text) && !is_numeric($text) ) {
			throw new Exception('Label required a string or numeric text', 4);
		}

		$content = sprintf($this->getContent(), '<label for="'.$name.'">'.$text."</label>\n%s");
		$this->setContent($content);
	}

	/**
	 * Add input field
	 * @param string $type
	 * @param string $name
	 * @param array $otherAttributes
	 * @throws Exception
	 */
	public function addInput($type, $name, $otherAttributes = array()) {
		$field = array();

		if ( !is_string($type) ) {
			throw new Exception('Input required a string type', 5);
		}

		if ( !is_string($name) ) {
			throw new Exception('Input required a string name', 6);
		}

		$attributes = $this->addAttributes($otherAttributes);

		if ( $this->isFieldType('input', $type) ) {
			$field['name'] = ( $type === 'submit' ) ? '' : 'name="'.$name.'"';
			$content = sprintf($this->getContent(), '<input type="'.$type.'" '.$field['name'].$attributes.' >'."\n%s");
			$this->setContent($content);
		}
	}

	/**
	 * Add TextArea field
	 * @param string $name
	 * @param string $text
	 * @param array $otherAttributes
	 * @throws Exception
	 */
	public function addTextArea($name, $text = '', $otherAttributes = array()) {
		if ( !is_string($name) ) {
			throw new Exception('TextArea required a string name');
		}

		$attributes = $this->addAttributes($otherAttributes);

		$content = sprintf($this->getContent(),
				'<textarea name="'.$name.'" '.$attributes.">".$text."</textarea>\n%s");
		$this->setContent($content);
	}

	/**
	 * Add button field
	 * @param string $type
	 * @param string $text
	 * @param array $otherAttributes
	 */
	public function addButton($type = 'button', $text = '', $otherAttributes = array()) {
		if ( $this->isFieldType('button', $type ) ) {
			$attributes = $this->addAttributes($otherAttributes);
			$content = sprintf($this->getContent(), '<button type="'.$type.'" '.$attributes.' >'.$text."</button>\n%s");
			$this->setContent($content);
		}
	}

	/**
	 * Add select field in form with name and options array
	 * @param string $name
	 * @param array $options
	 * @throws Exception
	 */
	public function addSelect( $name, $options = array() ) {
		if ( !is_string($name) ) {
			throw new Exception('Select required a string name');
		}

		$select = '<select name="'.$name.'">'."\n";
		foreach ($options as $key => $val) {
			$select .= $val."\n";
		}

		$select .= "</select>%s\n";
		$content = sprintf($this->getContent(), $select);
		$this->setContent($content);
	}

	/**
	 * Add select options in form
	 * The options param required an double array (array in array)
	 * @param array $options
	 * @param array $group
	 * @throws Exception
	 * @return options for adding in select
	 */
	public function addOptions($options, $group) {
		if ( !is_array($options) ) {
			throw new Exception('Options required an array');
		}

		if ( !is_array($group) ) {
			throw new Exception('Options required an array');
		}

		$lstOptions = '';
		$attributes = '';

			/* if ( !empty($group['disabled']) && $group['disabled'] === NULL ) {
				$disabled = 'disabled';
			}
			else if ( isset($group['disabled']) && $group['disabled'] === 'disabled' ) {
				$disabled = 'disabled="disabled"';
			}
			else {
				$disabled = '';
			} */

		foreach ($group as $key => $val) {
			if ( $key === 'disabled' && $val === NULL ) {
				$disabled = 'disabled';
			}
			else if ( $key === 'disabled' && $val === 'disabled' ) {
				$disabled = 'disabled="disabled"';
			}
			else {
				$disabled = '';
			}
		}

			if ( !empty($group) ) {
				$lstOptions.= '<optgroup label="'.$group['label'].'" '.$disabled." >\n";
			}

			for ($i = 0; $i < count($options); $i++) {
				$attributes = ( isset($options[$i]['attributes']) ) ? $this->addAttributes($options[$i]['attributes']) : '';
				$lstOptions .= '<option value="'.$options[$i]['value'].'" '.$attributes.' >'.$options[$i]['label']."</option>\n";
			}

			$lstOptions .= (!empty($group)) ? "</optgroup>\n" : '';

		return $lstOptions;
	}

	/**
	 * Add <br> new line tag
	 */
	public function addNewLine() {
		$this->setContent( sprintf($this->getContent(), "<br>\n%s") );
	}

	/**
	 * Get content of actual generate form
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set content of form
	 * @param string $content
	 */
	protected function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Set list input type
	 * @param array $inputType
	 */
	protected function setInputType($inputType) {
		$this->inputType = $inputType;
	}

	/**
	 * Get list of input type
	 * @return string
	 */
	protected function getInputType() {
		return $this->inputType;
	}

	/**
	 * Get list of button type
	 * @return string
	 */
	protected function getButtonType() {
		return $this->buttonType;
	}

	/**
	 * Set list of button type
	 * @param string $buttonType
	 */
	protected function setButtonType($buttonType) {
		$this->buttonType = $buttonType;
	}
}
