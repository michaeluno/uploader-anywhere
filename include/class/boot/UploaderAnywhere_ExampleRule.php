<?php
/**
 * Creates an example rule set by default.
 * 
 * @since   0.0.1
 */
class UploaderAnywhere_ExampleRule {

    /**
     * The internal flag that indicates it is a default example rule.
     * 
     * @since   0.0.1
     */
    private $_sInternalFlagMetaKey = '_uploader_anywhere_default_rule';

    /**
     * Sets up properties and hooks
     * @since   0.0.1
     */
    public function __construct() {
        
        // Find if the plugin default rule exists or not.
        if ( $this->_checkDefaultRuleExists() ) {
            return;
        }
        
        // Create example rules.
        // $this->_createExampleRules();
        
        $this->_createExample_InsertUploaderButtonInMenu();
        $this->_createExample_ReplaceAddNewWithUploaderButton();
                
        
    }
   
    /**
     * Checks whether the default example rule exits or not.
     * 
     * @since   0.0.1
     * @return boolean
     */
    private function _checkDefaultRuleExists() {
     
        // Retrieve posts that matches the stored(current) base url name such as edit.php or post.php.
        $_aQueryArgs = array(
            'post_type'      => UploaderAnywhere_Registry::PostType_Link,
            'post_status'    => array( 'any' ),
            'posts_per_page' => 1,          // -1 for all
            'fields'         => 'ids',      // return only post IDs by default.
            'meta_query' => array(
                array(
                    'key'     => $this->_sInternalFlagMetaKey,
                    'value'   => true,
                    'compare' => 'EXISTS',
                ),
            ),            
        );
        $_oResults      = new WP_Query( $_aQueryArgs );
        return ( $_oResults->post_count );       
        
    }
   
    /**
     * Creates a default example rule.
     * 
     * @since       0.0.1
     * @deprecated  0.0.2
     * @return      void
     */
    private function _createExampleRules() {
        
        // Insert the post into the database
        $_iPostID = wp_insert_post(
            array(
                'post_title'    => __( 'Example Rule', 'uploader-anywhere' ),
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => UploaderAnywhere_Registry::PostType_Link,
            )
        );   
        if ( ! $_iPostID ) {
            return;
        }
        update_post_meta( $_iPostID, $this->_sInternalFlagMetaKey, true );
        update_post_meta( $_iPostID, 'base_url_name', '*' );
        update_post_meta( $_iPostID, 'selector', 'li:has( > a:has( > .upload_anywhere_submenu_link ) )' );
        update_post_meta( $_iPostID, 'nth_item', 1 );
        update_post_meta( $_iPostID, 'file_type_filters', 'image' );
        update_post_meta( $_iPostID, 'label_button_use_this', __( 'Use This', 'uploader-anywhere' ) );
        
    }

    /**
     * Creates an example rule that inserts an upload link in the sidebar menu of the admin area.
     * 
     * @since   0.0.2
     */
    private function _createExample_InsertUploaderButtonInMenu() {
     
        // Insert the post into the database
        $_iPostID = wp_insert_post(
            array(
                'post_title'    => __( 'Example Rule - Inserts Upload Button in Sidebar Menu', 'uploader-anywhere' ),
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => UploaderAnywhere_Registry::PostType_Link,
            )
        );   
        if ( ! $_iPostID ) { return; }     
        update_post_meta( $_iPostID, $this->_sInternalFlagMetaKey, true );
        update_post_meta( $_iPostID, 'base_url_name', '*' );
        update_post_meta( $_iPostID, 'selector', 'li:has( > a:has( > .uploader_anywhere_setting_metnu ) )' );
        update_post_meta( $_iPostID, 'nth_item', 1 );
        update_post_meta( $_iPostID, 'insert_method', '.insert_method_insert' );
        update_post_meta( $_iPostID, 'inserting_html_element', '<li><a>Upload</a></li>' );
        update_post_meta( $_iPostID, 'insert_after_or_before', 'after' );
        update_post_meta( $_iPostID, 'label_button_use_this', __( 'Use This', 'uploader-anywhere' ) );
        
    }
 

    /**
     * Creates an example rule that replaces the Add New button of the post listing page with an upload link.
     * 
     * @since   0.0.2
     */ 
    private function _createExample_ReplaceAddNewWithUploaderButton() {
        
        // Insert the post into the database
        $_iPostID = wp_insert_post(
            array(
                'post_title'    => __( 'Example Rule - Replace the Add New button of rule listing page with an upload link', 'uploader-anywhere' ),
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => UploaderAnywhere_Registry::PostType_Link,
            )
        );   
        if ( ! $_iPostID ) { return; }    

        update_post_meta( $_iPostID, $this->_sInternalFlagMetaKey, true );
        update_post_meta( $_iPostID, 'base_url_name', 'edit.php' );
        update_post_meta( $_iPostID, 'url_query_key_values', array( array( 'key' => 'post_type', 'value' => UploaderAnywhere_Registry::PostType_Link ) ) );
        update_post_meta( $_iPostID, 'selector', 'a.add-new-h2' );
        update_post_meta( $_iPostID, 'nth_item', 1 );
        update_post_meta( $_iPostID, 'file_type_filters', 'image' );                
        update_post_meta( $_iPostID, 'insert_method', '.insert_method_replace' );        
        update_post_meta( $_iPostID, 'label_button_use_this', __( 'Use This', 'uploader-anywhere' ) );           
   
    }
        
    
}