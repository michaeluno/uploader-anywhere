<?php
/**
 * The base class of the plugin meta box classes.
 * 
 * @since            0.0.2
 */
class UploaderAnywhere_MetaBox_Base extends UploaderAnywhere_AdminPageFramework_MetaBox {
                
    /**
     * The method which is called right before the setUp() method.
     * 
     */ 
    protected function _setUp() {
        
        // Register custom field types
        new UploaderAnywhere_MultipleTextFieldType( $this->oProp->sClassName );        
        new UploaderAnywhere_RevealerCustomFieldType( $this->oProp->sClassName );
      
        parent::_setUp();
      
    }
    
    
}