<?php
class ModelAdminFlagExtension extends Extension {
    
    function updateEditForm(&$form) {
        $modelclass = $this->owner->modelClass;
        $gridfieldconfig = $form->Fields()->fieldByName($modelclass)->getConfig();   
        
        if (singleton($modelclass)->hasExtension("FlagExtension")) {
            
            if (isset($modelclass::$flags)) {
               $gridfieldconfig->addComponent(new GridFieldFlag($modelclass::$flags), 'GridFieldEditButton');     
            }
            else {
               $gridfieldconfig->addComponent(new GridFieldFlag(FlagExtension::$default_flags), 'GridFieldEditButton'); 
            }
            
        }
    }
    
}