<?php
/**
 * One of the abstract class of the plugin admin page class.
 * 
 * @package      Uploader Anywhere
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class UploaderAnywhere_AdminPage extends UploaderAnywhere_AdminPageFramework {

    public function setUp() {

        // Register custom field types
        new UploaderAnywhere_MultipleTextFieldType( $this->oProp->sClassName );
    
        /* ( required ) Set the root page */
        $this->setRootMenuPageBySlug( 'edit.php?post_type=' . UploaderAnywhere_Registry::PostType_Link );       

       $this->addSubMenuItems( 
            array(
                'title'         => __( 'Settings', 'uploader-anywhere' ),
                'menu_title'    => '<span class="uploader_anywhere_setting_metnu">' . __( 'Settings', 'uploader-anywhere' ) . '</span>',    // embed a class selector for an example rule to target the element.
                'page_slug'     => UploaderAnywhere_Registry::AdminPage_Settings,    // page slug                
            ),       
            // @deprecated 0.0.2
            // array(
                // 'title'         => "<span class='upload_anywhere_submenu_link'>" 
                        // . __( 'Upload', 'uploader-anywhere' ) 
                    // . "</span>",
                // 'href'          => add_query_arg( $_GET, admin_url( $this->oProp->sPageNow ) ),
                // 'show_page_heading_tab' => false,
            // ),
            array()
            
        );
         
        $this->setPageHeadingTabsVisibility( false ); // disables the page heading tabs by passing false.
        $this->setInPageTabTag( 'h2' ); // sets the tag used for in-page tabs     
        $this->setPageTitleVisibility( false ); // disable the page title of a specific page.
          
         
    }
    
}