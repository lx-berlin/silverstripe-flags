<?php
/**
 * <code>
 * $action = new GridFieldFlag(array('Green','Blue')); // adds a Green and a Blue Flag Button
 * </code>
 *
 * @package silverstripe-flags
 */
class GridFieldFlag implements GridField_ColumnProvider, GridField_ActionProvider {
	
	protected $colors = false;
	
	public function __construct($colors = array('Red')) {
		// we want all colors with a first letter in Uppercase
        foreach ($colors AS $color) {
            $this->colors[] = ucfirst($color);    
        } 
	}
	
	/**
	 * Add a column 'Delete'
	 * 
	 * @param type $gridField
	 * @param array $columns 
	 */
	public function augmentColumns($gridField, &$columns) {
		if(!in_array('Actions', $columns)) {
			$columns[] = 'Actions';
		}
	}
	
	/**
	 * Return any special attributes that will be used for FormField::createTag()
	 *
	 * @param GridField $gridField
	 * @param DataObject $record
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnAttributes($gridField, $record, $columnName) {
		return array('class' => 'col-buttons');
	}
	
	/**
	 * Add the title 
	 * 
	 * @param GridField $gridField
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnMetadata($gridField, $columnName) {
		if($columnName == 'Actions') {
			return array('title' => '');
		}
	}
	
	/**
	 * Which columns are handled by this component
	 * 
	 * @param type $gridField
	 * @return type 
	 */
	public function getColumnsHandled($gridField) {
		return array('Actions');
	}
	
	/**
	 * Which GridField actions are this component handling
	 *
	 * @param GridField $gridField
	 * @return array 
	 */
	public function getActions($gridField) {
		return array('toggleFlag');
	}
	
	/**
	 *
	 * @param GridField $gridField
	 * @param DataObject $record
	 * @param string $columnName
	 * @return string - the HTML for the column 
	 */
	public function getColumnContent($gridField, $record, $columnName) {
        $html = "";
        foreach ($this->colors AS $color) {
            $property = $color."Flag";
            $icon = "flag_".$color;
            
            $field = GridField_FormAction::create($gridField, 'xxxxxxxtoggleFlag'.$record->ID, false, "toggleFlag", array('RecordID' => $record->ID, 'Color' => $color))->addExtraClass('gridfield-button-flag');
            if ($record->$property) $field->setAttribute('data-icon', $icon);
            else                    $field->setAttribute('data-icon', 'flag_disabled');
            
            $html.=$field->Field();                 
        }
        return $html;        
	}
	
	/**
	 * Handle the actions and apply any changes to the GridField
	 *
	 * @param GridField $gridField
	 * @param string $actionName
	 * @param mixed $arguments
	 * @param array $data - form data
	 * @return void
	 */
	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		
        // wich flag was clicked
        $color = $arguments["Color"];
        $property = $color."Flag";
        
        if($actionName == 'toggleflag') {
			$item = $gridField->getList()->byID($arguments['RecordID']);
			if(!$item) {
				return;
			}
            if ($item->$property) {
                $item->$property = 0;
            }
            else {
                $item->$property = 1;
            }
            $item->write();

		} 
	}
    
    
}
