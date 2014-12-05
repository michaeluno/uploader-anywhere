<?php
/**
 * Defines the custom post type of Uploader Anywhere.
 * 
 * @since   0.0.1
 */
class UploaderAnywhere_PostType_Link extends UploaderAnywhere_AdminPageFramework_PostType {
    
    /**
     * This method is called at the end of the constructor.
     * 
     * Use this method to set post type arguments and add custom taxonomies as those need to be done in the front-end as well.
     * Also, to add custom taxonomies, the setUp() method is too late.
     * 
     * ALternatevely, you may use the start_{instantiated class name} method, which also is called at the end of the constructor.
     */
    public function start() {    

        $this->setArguments(
            array( // argument - for the array structure, refer to http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
                'labels' => array(
                    'name'               => 'Uploader Link',
                    'all_items'          => __( 'Uploader Links', 'uploader-anywheere' ),
                    'singular_name'      => __( 'Uploader Link', 'uploader-anywheere' ),
                    'add_new'            => __( 'Add Link', 'uploader-anywheere' ),
                    'add_new_item'       => __( 'Add New Uploader Link', 'uploader-anywheere' ),
                    'edit'               => __( 'Edit', 'uploader-anywheere' ),
                    'edit_item'          => __( 'Edit Link', 'uploader-anywheere' ),
                    'new_item'           => __( 'New Uploader Link', 'uploader-anywheere' ),
                    'view'               => __( 'View', 'uploader-anywheere' ),
                    'view_item'          => __( 'View Uploader Link', 'uploader-anywheere' ),
                    'search_items'       => __( 'Search Uploader Link', 'uploader-anywheere' ),
                    'not_found'          => __( 'No Uploader link found', 'uploader-anywheere' ),
                    'not_found_in_trash' => __( 'No Uploader link found in Trash', 'uploader-anywheere' ),
                    'parent'             => __( 'Parent Uploader Link', 'uploader-anywheere' ),
                    'plugin_listing_table_title_cell_link' => __( 'Uploader Links', 'uploader-anywheere' ), // framework specific key. [3.0.6+]
                ),
                'public'            => false,
                'show_ui'           => true,  
                'show_in_menu'      => true, // Whether to show post type in the admin menu. 'show_ui' must be true for this to work. bool (defaults to 'show_ui')
                'can_export'        => true,
                'hierarchical'      => false,
                'menu_position'     => 110,
                'supports'          => array( 'title' ), // e.g. array( 'title', 'editor', 'comments', 'thumbnail' ),    
                'taxonomies'        => array( '' ), 
                'has_archive'       => false,
                'show_admin_column' => false, // this is for custom taxonomies to automatically add the column in the listing table.
                'menu_icon'         => $this->oProp->bIsAdmin 
                    ? ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ? 'dashicons-upload' : plugins_url( 'asset/image/icon_16x16.png', UploaderAnywhere_Registry::$sFilePath ) )
                    : null, // do not call the function in the front-end.
                // ( framework specific key ) this sets the screen icon for the post type for WordPress v3.7.1 or below.
                'screen_icon' => UploaderAnywhere_Registry::$sDirPath . '/asset/image/icon_32x32.png', // a file path can be passed instead of a url, plugins_url( 'asset/image/wp-logo_32x32.png', APFDEMO_FILE )
                'exclude_from_search'   => true,    
            )    
        );
    }
}