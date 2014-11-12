<?php
/**
 * Creates a meta box for the basic options.
 * 
 * @since            0.0.1
 */
class UploaderAnywhere_MetaBox_Main extends UploaderAnywhere_MetaBox_Base {
                
    /**
     * Adds form fields for the basic options.
     * 
     */ 
    public function setUp() {
                
        // Add fields.
        $this->addSettingFields( 
            array(
                'field_id'          => 'base_url_name',
                'type'              => 'text',
                'title'             => __( 'Base URL Name', 'uploader-anywhere' ) 
                    . ' ' . '(' . __( 'required', 'uploader-anywhere' ). ')',
                'attributes' => array(
                    // 'size'      => 20,
                    'required'  => 'required',
                ),
                'description'       => array(
                    __( 'Set the base name of the target url such as <code>post.php</code> and <code>edit.php</code>' )
                        . ' ' . __( 'To apply to all pages in the admin area, set <code>*</code>.', 'uploader-anywhere' ),
                    sprintf( __( 'For example, if you want to place uploader link(s) in <code>%1$s</code>, set the above input <code>edit.php</code> and <code>post_type</code>to the below Key and <code>my_cpt</code> to the Value option.', 'uploader-anywhere' ), admin_url( 'edit.php?post_type=my_cpt' ) ),
                ),
            ),  
            array(
                'field_id'          => 'url_query_key_values',
                'title'             => __( 'URL Query Key Values', 'uploader-anywhere' ) 
                    . ' ' . '(' . __( 'optional', 'uploader-anywhere' ). ')',
                'type'              => 'multiple_text',
                'label'             => array(
                    'key'      => __( 'Key', 'uploader-anywhere' ),
                    'value'    => __( 'Value', 'uploader-anywhere' ),
                ),
                'repeatable'        => true,
                'description'       => array(
                    __( 'Set the url query key-value pairs such as key:<code>post_type</code>, value:<code>my_cpt</code>', 'uploader-anywhere' )
                    . ' ' . __( 'If the both are left empty, it applies to any query.', 'uploader-anywhere' ),
                ),
            ),
            // array(
                // 'field_id'          => 'selector',
                // 'title'             => __( 'CSS Selector', 'uploader-anywhere' ) 
                    // . ' ' . '(' . __( 'required', 'uploader-anywhere' ). ')',
                // 'type'              => 'text',
                // 'description'       => array( 
                    // __( 'Set here the selector that applies to the replacing element(s).', 'uploader-anywhere' )
                    // . ' ' . __( 'For the <code>Add New</code> button, set <code>.add-new-h2</code>', 'uploader-anywhere' )
                    // . ' ' . __( 'It accepts jQuery selectors for advanced users such as <code>li:has( > a:has( > .my_custom_css_class ) )</code>.', 'uploader-anywhere' ),
                // ),
                // 'attributes'        => array(
                    // 'size'      => 40,
                    // 'required'  => 'required',
                // ),
            // ),
            // array(
                // 'field_id'          => 'nth_item',
                // 'title'             => __( 'Nth Item', 'uploader-anywhere' ),
                // 'type'              => 'number',
                // 'default'           => 1,
                // 'description'       => __( 'Indicates the nth element of the found items. Set <code>0</code> to apply to all the found ones.', 'uploader-anywhere' ),
            // ),    
            array()
        );    
    
    }
    
    /**
     * Adds heading information in the meta box.
     * 
     * @since   0.0.1
     */
    public function do_UploaderAnywhere_MetaBox_Main() {
        echo '<p>' 
                . __( 'Define which pages and query key-values that uploader links should be embedded.', 'uploader-anywhere' ) 
            . '</p>';
    }
  
    /*
     * Validation methods
     * 
     * @since   0.0.1
     */
    public function validation_UploaderAnywhere_MetaBox_Main( $aInput, $aOldInput, $oMetBox ) {    // validation_ + extended class name
                    
        $_bIsValid  = true;
        $_aErrors   = array();                    
        
        // Check required keys.

        
        $aInput['base_url_name'] = trim( $aInput['base_url_name'] );
        if ( ! $aInput['base_url_name'] ) {
            $_bIsValid = false;        
            $_aErrors['base_url_name'] = __( 'Base page name cannot be empty.', 'uploader-anywhere' );
            unset( $aInput['base_url_name'] );
        }
        // $aInput['selector'] = trim( $aInput['selector'] );
        // if ( ! $aInput['selector'] ) {
            // $_bIsValid = false;        
            // $_aErrors['selector'] = __( 'Base page name cannot be empty.', 'uploader-anywhere' );
            // unset( $aInput['selector'] );
        // }
                
        if ( ! $_bIsValid ) {
            
            $this->setFieldErrors( $_aErrors );
            $this->setSettingNotice( __( 'There was an error in your input in meta box form fields', 'uploader-anywhere' ) );    
            return $aInput;
            
        }      
                         
        return $aInput;
        
    }
    
}