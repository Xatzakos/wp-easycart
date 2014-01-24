<?php
////////////////////////////////////////////
// ADMIN INITIALIZE/LOCALIZE AJAX Functions
////////////////////////////////////////////
add_action( 'admin_enqueue_scripts', 'ec_load_admin_scripts' );
add_action( 'admin_init', 'ec_register_settings' );
add_action( 'admin_menu', 'ec_create_menu' );
add_action( 'admin_init', 'ec_custom_downloads', 1 );
add_action( 'admin_notices', 'ec_install_admin_notice' );
add_action( 'save_post', 'ec_post_save_permalink_structure' );
add_action( 'save_post', 'ec_post_save_match_store_meta', 13 );

function ec_install_admin_notice() {
	if( isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "basic-setup" ){
		update_option( 'ec_option_show_install_message', '1' );
	}
	
	if( !get_option( 'ec_option_show_install_message' ) && ( !get_option( 'ec_option_accountpage' ) || !get_option( 'ec_option_cartpage' ) || !get_option( 'ec_option_storepage' ) ) ){
    ?>
    <div class="updated">
        <p>You Have not Setup Your WP EasyCart! Please <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">Click Here to Setup</a>.</p>
    </div>
    <?php
	}
	
	$ec_selected_theme = wp_get_theme();
	if( $ec_selected_theme->Name == "Twenty Fourteen" && ( get_option( 'ec_option_base_theme' ) != "twenty-fourteen-v2" || get_option( 'ec_option_base_layout' ) != "twenty-fourteen-v2" ) ){ 
    
	if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/twenty-fourteen-v2/" ) ){;
	?>
    <div class="updated">
        <p>EasyCart notices that you are using the Twenty Fourteen WordPress theme, but not the Twenty Fourteen store design. Make the change to the cart for best results by <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management">clicking here</a>.</p>
    </div>
    <?php }else{ ?>
    <div class="updated">
        <p>EasyCart notices that you are using the Twenty Fourteen WordPress theme, but not the Twenty Fourteen store design. Learn how to upgrade by <a href="http://www.wpeasycart.com/forums/forum/customization-and-themes/general-theme-questions/individual-theme-support/base-and-default-theme/262-twenty-fourteen-wordpress-theme" target="_blank">clicking here for help</a>.</p>
    </div>
    <?php
	}// Close check for existing theme
	}// Close check for latest WordPress theme
}

function ec_load_admin_scripts( ){
	
	include( 'style.php' );
	
	wp_enqueue_script('thickbox');  
	wp_enqueue_style('thickbox');  

	wp_enqueue_script('media-upload'); 
	
	wp_register_script( 'wpeasycart_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/admin_ajax_functions.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'wpeasycart_admin_js' );
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		$https_link = $https_class->getHttpsUrl() . '/wp-admin/admin-ajax.php';
	}else{
		$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) )
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function ec_register_settings() {
	
	//register admin css
	wp_register_style( 'wpeasycart_admin_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/wpadmin_stylesheet.css' ) );
	wp_enqueue_style( 'wpeasycart_admin_css' );
	
	//register admin css
	wp_register_style( 'wpeasycart_adminv2_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/css/wpeasycart_adminv2.css' ) );
	wp_enqueue_style( 'wpeasycart_adminv2_css' );
		
	//register options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->register_options();
	
}

function ec_create_menu() {
	
	//V2 Admin
	$wp_version = get_bloginfo( 'version' );
	if( $wp_version < 3.8 ){
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	}else{
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'assets/images/sidebar_icon.png', __FILE__ ) );
	}
}

function ec_custom_downloads( ){
	if( is_admin( ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && ( $_GET['ec_action'] == "download_designs" || $_GET['ec_action'] == "download_products" ) ){
		
		if( $_GET['ec_action'] == "download_designs" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/design.zip";
			$zip_shortname = "design.zip";
		}else if( $_GET['ec_action'] == "download_products" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/products.zip";
			$zip_shortname = "products.zip";
		}
		$zip = new ZipArchive;
		$zip->open( $zipname, ZipArchive::CREATE );
		
		if( $_GET['ec_action'] == "download_designs" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/design/";
		}else if( $_GET['ec_action'] == "download_products" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/products/";
		}
		$source = str_replace( '\\', '/', realpath( $source ) );
		
		$files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $source ), RecursiveIteratorIterator::SELF_FIRST );

        foreach( $files as $file ){
            $file = str_replace( '\\', '/', realpath( $file ) );

            if( is_dir( $file ) === true ){
                $zip->addEmptyDir( str_replace( $source . '/', '', $file . '/' ) );
            
			}else if( is_file( $file ) === true ){
                $zip->addFromString( str_replace( $source . '/', '', $file ), file_get_contents( $file ) );
            }
        }
		
		$zip->close( );
		
		if( file_exists( $zipname ) ){
			header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header( "Cache-Control: private",false);
			header( 'Content-Type: application/zip' );
			header( 'Content-Disposition: attachment; filename="' . $zip_shortname . '";' );
			header( 'Content-Length: ' . ( string )( filesize( $zipname ) ) );
			header( "Content-Transfer-Encoding: binary" );
			header( 'Expires: 0');
			header( 'Cache-Control: private');
			header( 'Pragma: private');
			ob_clean();
			flush();
			
			readfile( $zipname );
			
			unlink( $zipname );
		
		}else{
			exit( "Could not find the zip to be downloaded" );
		}
	}else if( is_admin( ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && $_GET['ec_action'] == "download_db" ){
		$mysql_database = DB_NAME;
		$db_selected = mysql_select_db($mysql_database);
		
		// Get the contents
		$file_contents = ec_mysqldump( $mysql_database );
		
		$sql_shortname = "Storefront_Backup_" . date( 'Y_m_d' ) . ".sql";
		$sqlname = WP_PLUGIN_DIR . "/wp-easycart-data/" . $sql_shortname;
		
		file_put_contents( $sqlname, $file_contents );
		
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header( "Content-type: text/plain");
		header( 'Content-Disposition: attachment; filename=' . $sql_shortname );
		header( 'Content-Length: ' . ( string )( filesize( $sqlname ) ) );
		header( "Content-Transfer-Encoding: binary" );
		header( 'Expires: 0');
		header( 'Cache-Control: private');
		header( 'Pragma: private');
		
		readfile( $sqlname );
		unlink( $sqlname );
		
		// Stop the page execution so that it doesn't print HTML to the file accidently
		die();
	}
}

//store settings menu
function ec_settings_page_callback(){
	include("ec_install.php");
}

function ec_install_page_callback(){
	include("ec_install.php");
}

function ec_setup_page_callback(){
	include("store_setup.php");
}

function ec_payment_page_callback(){
	include("payment.php");
}

function ec_social_icons_page_callback(){
	include("social_icons.php");
}

function ec_language_page_callback(){
	include("language.php");
}


//administration menu
function ec_administration_callback() {
	include("demos.php");
}
function ec_admin_console_page_callback() {
	include("admin_console.php");
}
function ec_demos_callback() {
	include("demos.php");
}
function ec_users_guide_callback() {
	include("users_guide.php");
}

//store design menu
function ec_base_design_page_callback(){
	include("base_design.php");
}

// Admin per theme function is in wpeasycart.php

//store checklist menu
function ec_checklist_page_callback(){
	include("checklist.php");
}

//store v2 admin menu item
function ec_adminv2_page_callback( ){
	include( "admin_v2.php" );
}

function ec_mysqldump( $mysql_database ){	
	$return_string = "";
	$return_string .= "/*MySQL Dump File*/\n";
	$sql = "show tables;";
	$result = mysql_query($sql);
	if( $result ){
		while( $row = mysql_fetch_row( $result ) ){
			$return_string .= ec_mysqldump_table_structure( $row[0] );
			$return_string .= ec_mysqldump_table_data( $row[0] );
		}
	}else{
		$return_string .= "/* no tables in $mysql_database */\n";
	}
	mysql_free_result( $result );
	return $return_string;
}

function ec_mysqldump_table_structure( $table ){
	$return_string = "";
	$return_string .= "/* Table structure for table `$table` */\n";
	$return_string .= "DROP TABLE IF EXISTS `$table`;\n\n";
	$sql = "show create table `$table`; ";
	$result = mysql_query( $sql );
	if( $result ){
		if( $row = mysql_fetch_assoc( $result ) ){
			$return_string .= $row['Create Table'].";\n\n";
		}
	}
	mysql_free_result( $result );
	return $return_string;
}

function ec_mysqldump_table_data( $table ){
	$return_string = "";
	$sql = "select * from `$table`;";
	$result = mysql_query( $sql );
	if( $result ){
		$num_rows = mysql_num_rows( $result );
		$num_fields = mysql_num_fields( $result );
		if( $num_rows > 0 ){
			$return_string .= "/* dumping data for table `$table` */\n";
			$field_type = array( );
			$i = 0;
			while( $i < $num_fields ){
				$meta = mysql_fetch_field( $result, $i );
				array_push( $field_type, $meta->type );
				$i++;
			}
			$return_string .= "insert into `$table` values\n";
			$index = 0;
			while( $row = mysql_fetch_row( $result ) ){
				$return_string .= "(";
				for( $i = 0; $i < $num_fields; $i++ ){
					if( is_null( $row[$i] ) )
						$return_string .= "null";
					else{
						switch( $field_type[$i] ){
							case 'int':
								$return_string .= $row[$i];
								break;
							case 'string':
							case 'blob' :
							default:
								$return_string .= "'".mysql_real_escape_string($row[$i])."'";
						}
					}

					if( $i < $num_fields - 1 )
						$return_string .= ",";
				}
				$return_string .= ")";
				
				if( $index < $num_rows - 1 )
					$return_string .= ",";
				else
					$return_string .= ";";
				$return_string .= "\n";

				$index++;
			}
		}
	}
	mysql_free_result($result);
	$return_string .= "\n";
	return $return_string;
}

function ec_post_save_permalink_structure( $post_id ) {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function ec_post_save_match_store_meta( $post_id ) {
	//If we are matching post meta, lets do it here for store page only!
	$selected_store_id = get_option( 'ec_option_storepage' );
	$using_meta_match = get_option( 'ec_option_match_store_meta' );
	if( $using_meta_match && $selected_store_id == $post_id ){
		//Get the store page meta
		$store_meta = get_post_meta( $post_id );
		//Get the posts for the store
		$args = array( 'post_type' => 'ec_store' );
		$my_query = new WP_Query( $args );
		foreach( $my_query->posts as $post ){
			//Get the post meta for deletion if needed
			$post_meta = get_post_meta( $post->ID );
			//Delete each meta for this post
			foreach( $post_meta as $key => $meta ){
				delete_post_meta( $post->ID, $key );
			}
			
			//Add each store meta to this post
			foreach( $store_meta as $key => $meta ){
				//We need to check if unseriablizable and deal with it accordingly
				$meta_arr = @unserialize( $meta[0] );
				if( $meta_arr !== false ){
					add_post_meta( $post->ID, $key, $meta_arr );
				}else{
					add_post_meta( $post->ID, $key, $meta[0] );
				}
			}
		}
	}
}

?>