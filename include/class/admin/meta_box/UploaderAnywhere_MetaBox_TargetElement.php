<?php
/**
 * Creates a meta box for the basic options.
 * 
 * @since            0.0.2
 */
class UploaderAnywhere_MetaBox_TargetElement extends UploaderAnywhere_MetaBox_Base {
                
    /**
     * Adds form fields for the basic options.
     * 
     */ 
    public function setUp() {
                
        // Add fields.
        $this->addSettingFields( 
            array(  // 0.0.2+
                'field_id'          => 'insert_method',
                'title'             => __( 'Insert Method', 'uploader-anywhere' ),
                'type'              => 'revealer',
                'select_type'       => 'radio',
                'label'             => array(
                    '.insert_method_replace'    => __( 'Replace', 'uploader-anywhere' ) 
                        . ' - ' . __( 'replaces specified existing element(s) with the uploader link.', 'uploader-anywhere' ),                        
                    '.insert_method_insert'     => __( 'Insert', 'uploader-anywhere' )
                        . ' - ' . __( 'inserts the uploader link before/after the specified element(s).', 'uploader-anywhere' ),                        
                ),
                'default'           => '.insert_method_replace',
                'label_min_width'   => '100%',
            ),
            array(  // 0.0.2+
                'field_id'          => 'inserting_html_element',
                'title'             => __( 'Inserting HTML Element', 'uploaer-anywhere' ),
                'type'              => 'textarea',
                'class'             => array( 
                    'fieldrow'  => 'insert_method_insert',
                ),
                'hidden'            => true,
            ),
            array(  // 0.0.2+
                'field_id'          => 'insert_after_or_before',
                'title'             => __( 'Insert', 'uploaer-anywhere' ),
                'type'              => 'radio',
                'label'             => array(
                    'before'    => __( 'Before', 'uploaer-anywhere' ),
                    'after'     => __( 'After', 'uploaer-anywhere' ),
                ),
                'default'           => 'after',
                'class'             => array( 
                    'fieldrow'  => 'insert_method_insert',
                ),
                'hidden'            => true,
            ),    
            array(
                'field_id'          => 'selector',
                'title'             => __( 'CSS Selector', 'uploader-anywhere' ) 
                    . ' ' . '(' . __( 'required', 'uploader-anywhere' ). ')',
                'type'              => 'text',
                'description'       => array( 
                    __( 'Set here the selector that applies to the replacing element(s).', 'uploader-anywhere' )
                    . ' ' . __( 'For the <code>Add New</code> button, set <code>.add-new-h2</code>', 'uploader-anywhere' )
                    . ' ' . __( 'It accepts jQuery selectors for advanced users such as <code>li:has( > a:has( > .my_custom_css_class ) )</code>.', 'uploader-anywhere' ),
                ),
                'attributes'        => array(
                    'size'      => 40,
                    'required'  => 'required',
                ),
            ),
            array(
                'field_id'          => 'nth_item',
                'title'             => __( 'Nth Item', 'uploader-anywhere' ),
                'type'              => 'number',
                'default'           => 1,
                'description'       => __( 'Indicates the nth element of the found items. Set <code>0</code> to apply to all the found ones.', 'uploader-anywhere' ),
            ),            
            array()
        );    
    
    }
    
    /**
     * Adds heading information in the meta box.
     * 
     * do_{instantiated class name}
     * @since   0.0.1
     */
    public function do_UploaderAnywhere_MetaBox_TargetElement() {
        echo '<p>' 
                . __( 'Define what/which HTML element should server as the uploader link.', 'uploader-anywhere' ) 
            . '</p>';
    }
  
    /*
     * Validation methods
     * 
     * @since   0.0.1
     */
    public function validation_UploaderAnywhere_MetaBox_TargetElement( $aInput, $aOldInput, $oMetBox ) {    // validation_ + instantiated class name
            
        $_bIsValid  = true;
        $_aErrors   = array();                    
        
        // Check required keys.

        $aInput['selector'] = trim( $aInput['selector'] );
        if ( ! $aInput['selector'] ) {
            $_bIsValid = false;        
            $_aErrors['selector'] = __( 'Base page name cannot be empty.', 'uploader-anywhere' );
            unset( $aInput['selector'] );
        }
                
        if ( ! $_bIsValid ) {
            
            $this->setFieldErrors( $_aErrors );
            $this->setSettingNotice( __( 'There was an error in your input in meta box form fields', 'uploader-anywhere' ) );    
            return $aInput;
            
        }      
                         
        return $aInput;
        
    }
    
}