<?php
class FlagExtension extends DataExtension {    
    
    public static $default_flags = array('Red');
        
    static $db = array(
        'RedFlag' => 'Boolean',
        'OrangeFlag' => 'Boolean',
        'YellowFlag' => 'Boolean',
        'GreenFlag' => 'Boolean',
        'BlueFlag' => 'Boolean',
    );
    
    // this will add flag "actions" to the cms
    public function updateCMSGridFieldConfig($gridfieldconfig) {
        $modelclass = $this->owner;
        if (isset($modelclass::$flags)) {
           $gridfieldconfig->addComponent(new GridFieldFlag($modelclass::$flags), 'GridFieldEditButton');     
        }
        else {
           $gridfieldconfig->addComponent(new GridFieldFlag(self::$default_flags), 'GridFieldEditButton'); 
        }                
    }

    // we also need a dropdown in Modeladmin, 
    // because after adding a record it might be hard to find the added record in the list to set the flag with the action
    // therefore the admin should be able to set all flags in add mode
    public function updateCMSFields(FieldList $fields) {
        
        // remove all scaffolded checkboxes
        foreach ((self::$db) AS $flag => $type) {
            $fields->removeByName($flag);
        }
        
        // adding all needed checkboxes to a "Flags" tab
        $modelclass = $this->owner;
        $flags = (isset($modelclass::$flags)) ? $modelclass::$flags : (self::$default_flags);
        foreach ($flags AS $color) {
            $property = $color."Flag";
            
            $title = $color." Flag"; // todo -o lx use _t instead
            
            $field_Flag[$color] = new CheckboxField($property, $title);
            $fields->addFieldToTab('Root.Flags', $field_Flag[$color]);    
        }

    }
    
}