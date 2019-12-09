<?php 
/**
 * RUSAC_Settings
 * Settings for the plugin
 */
class RUSAC_Settings {
	
	function __construct(){
		add_action( 'admin_init', array($this, 'rusac_register_settings' ) );
        add_action('admin_menu', array($this, 'rusac_register_options_page') );
        add_filter( 'plugin_action_links_'.rusac_BaseName, array($this, 'rusac_add_action_links') );
        add_action('wp_ajax_rusac_clear_the_debug_log', array($this, 'rusac_clear_the_debug_log') );
	}

    function rusac_clear_the_debug_log() {
        $file_path = rusac_DIR.'/inc/RUSAC_Logger.log';
        unlink($file_path);
        wp_send_json_success();
    }

	function rusac_register_settings() {
        $api_url = get_option('rusac_api_url');
        if(empty($api_url)){ 
            add_option( 'rusac_api_url', '');
        }
        $api_key = get_option('rusac_api_key');
        if(empty($api_key)) {
            add_option( 'rusac_api_key', '');
        }
        $list_id = get_option('rusac_list_id');
        if(empty($list_id)) {
            add_option( 'rusac_list_id', '1');
        }
        $sync_switch = get_option('rusac_sync_switch');
        if(empty($sync_switch)) {
            add_option( 'rusac_sync_switch', 0);
        }
        $rusac_no_users_per_run = get_option('rusac_no_users_per_run');
        if(empty($rusac_no_users_per_run)) {
            add_option( 'rusac_no_users_per_run', 5);
        }
        $rusac_allowed_roles = get_option('rusac_allowed_roles');
        if (empty($rusac_allowed_roles)) {
            add_option( 'rusac_allowed_roles' , array('subscriber'));
        }
        $rusac_default_tags = get_option('rusac_default_tags');
        if (empty($rusac_default_tags)) {
            add_option( 'rusac_default_tags' , '');
        }
        $rusac_sync_debug = get_option('rusac_sync_debug');
        if (empty($rusac_sync_debug)) {
            add_option( 'rusac_sync_debug' , 0);
        }
        $rusac_sync_schedule = get_option('rusac_sync_schedule');
        if (empty($rusac_sync_schedule)) {
            add_option( 'rusac_sync_schedule' , 1);
        }
        
        register_setting( 'rusac_options_group', 'rusac_api_url', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_api_key', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_list_id', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_sync_switch', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_no_users_per_run', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_allowed_roles', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_default_tags', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_sync_debug', 'rusac_callback' );
        register_setting( 'rusac_options_group', 'rusac_sync_schedule', 'rusac_callback' );
        //
    }
    function rusac_register_options_page() {
        add_options_page('RU Active Campaigns Settings', 'RU Active Campaigns Settings', 'manage_options', 'rusac-settings', array($this,'rusac_options_page'));
    }

    function rusac_options_page() {
        global $wp_roles;
    ?>
    <div class="rusac-settings-section">
        <style type="text/css">
        form.rusac-settings input[type="text"]{padding:5px 10px;font-size:14px;width:300px;max-width:100%;}
        form.rusac-settings label{font-size:14px;line-height:30px;}
        form.rusac-settings .rusac-sync-settings label{padding-right:15px;}
        form.rusac-settings .allowed-roles label{padding-right:15px;}
        form.rusac-settings .advanced-settings{padding-top:50px;padding-bottom: 10px;}
        .debug-window pre{overflow-x:hidden;max-height:500px;overflow-y:auto;max-width:800px;}
        </style>
        <?php screen_icon(); ?>
        <h2><?php echo _e('RU Active Campaigns Settings','rus-activecampaign');?></h2>
        <form method="post" class="rusac-settings" action="options.php">
            <?php settings_fields( 'rusac_options_group' ); ?>
           <p></p>
            <table>
                <tr valign="top">
                    <th scope="row"><label for="rusac_api_url"><?php echo _e('API URL','rus-activecampaign');?></label></th>
                    <td><input type="text" id="rusac_api_url" name="rusac_api_url" value="<?php echo (get_option('rusac_api_url')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_api_key"><?php echo _e('API Key','rus-activecampaign');?></label></th>
                    <td><input type="text" id="rusac_api_key" name="rusac_api_key" value="<?php echo (get_option('rusac_api_key')); ?>" /> </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_list_id"><?php echo _e('Listing ID','rus-activecampaign');?></label></th>
                    <td><input type="text" id="rusac_list_id" name="rusac_list_id" value="<?php echo (get_option('rusac_list_id')); ?>" /> </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_sync_switch"><?php echo _e('Auto Sync','rus-activecampaign');?></label></th>
                    <td class="rusac-sync-settings"><?php $sync_option = get_option('rusac_sync_switch');?>
                        <label for="rusac_sync_switch_on"><input type="radio" id="rusac_sync_switch_on" name="rusac_sync_switch" value="1" <?php if ($sync_option == 1): ?> checked <?php endif ?>> On</label>
                       <label for="rusac_sync_switch_off"> <input type="radio" id="rusac_sync_switch_off" name="rusac_sync_switch" value="0" <?php if ($sync_option == 0): ?> checked <?php endif ?>> Off</label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_no_users_per_run"><?php echo _e('Number Of Users Sync per run','rus-activecampaign');?></label></th>
                    <td class="rusac-sync-settings"><input type="number" min=1 max=100 name="rusac_no_users_per_run" id="rusac_no_users_per_run" value="<?php echo get_option('rusac_no_users_per_run'); ?>"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_default_tags"><?php echo _e('Default User Tags','rus-activecampaign');?></label>
                        <p class="small"><?php echo _e('(Separated by ,)','rus-activecampaign');?></p>
                    </th>
                    <td class="rusac-sync-settings"><input type="text" name="rusac_default_tags" id="rusac_default_tags" value="<?php echo get_option('rusac_default_tags'); ?>"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="allowed_user_roles"><?php echo _e('Allow user roles to be sync','rus-activecampaign');?></label></th>
                    <td class="allowed-roles">
                    <?php $all_roles = $wp_roles->roles;
                    $allowed_roles = get_option('rusac_allowed_roles');
                    foreach ($all_roles as $key => $value) { ?>
                        <label for="role_<?php echo $key;?>"><input type="checkbox" id="role_<?php echo $key;?>" name="rusac_allowed_roles[]" value="<?php echo $key; ?>" <?php if (in_array($key,$allowed_roles)): ?> checked <?php endif ?>> <?php echo $value['name']; ?></label>
                    <?php }
                ?></td></tr>
                <tr><th class="advanced-settings"><?php echo _e('Advanced Settings','rus-activecampaign'); ?></th></tr>
                <tr valign="top">
                    <th scope="row"><label for="rusac_sync_schedule"><?php echo _e('Schedule Sync','rus-activecampaign');?></label></th>
                    <td class="allowed-roles">
                        <?php $rusac_sync_schedule = get_option('rusac_sync_schedule',1); ?>
                        <label for="rusac_sync_debug"> <?php echo _e('Sync Users in every','rus-activecampaign');?> <input type="number" id="rusac_sync_schedule" name="rusac_sync_schedule" value="<?php echo $rusac_sync_schedule; ?>"> <?php echo _e('mins','rus-activecampaign'); ?></label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="allowed_user_roles"><?php echo _e('Debug','rus-activecampaign');?></label></th>
                    <td class="allowed-roles">
                        <?php $rusac_sync_debug = get_option('rusac_sync_debug',false); ?>
                        <label for="rusac_sync_debug"><input type="checkbox" id="rusac_sync_debug" name="rusac_sync_debug" value="1" <?php if ($rusac_sync_debug): ?> checked <?php endif ?>> ON</label>
                    </td>
                </tr>
            </table>
            <?php  submit_button(); ?>
        </form>
        <?php if ($rusac_sync_debug) { 
            $file_path = rusac_DIR.'/inc/RUSAC_Logger.log'; ?>
        <div class="debug-window">
            <h2><?php echo _e('Debug Window','rus-activecampaign'); ?></h2>
            <?php if(file_exists($file_path)) {?>
            <div class="debug-controls">
                <a href="<?php echo rusac_URI;?>/inc/RUSAC_Logger.log" class="button" download><?php echo _e('Download Debug Log','rus-activecampaign');?></a>
                <a href="javascript:;" class="button" data-action="clear-log"><?php echo _e('Clear Debug Log','rus-activecampaign');?></a>
            </div>
            <pre><?php echo @file_get_contents($file_path);?></pre>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery('[data-action="clear-log"]').click(function(event){
            var admin_ajax_url = '<?php echo admin_url('admin-ajax.php');?>';
            var dataObj = {action: 'rusac_clear_the_debug_log', };
            jQuery.ajax({
                type:'post',
                url: admin_ajax_url,
                data: dataObj,
                success: function(resp){
                    if(resp.success){
                        jQuery('[data-action="clear-log"]').remove();
                        jQuery('.debug-window pre').html('');
                    }
                }
            });
        });
    });

    </script>
    <?php
    }
    

    function rusac_add_action_links( $links ) {
        $mylinks = array(
            '<a href="' . admin_url( 'options-general.php?page=rusac-settings' ) .'&token='.time(). '">'.__( 'Settings', 'rus-activecampaign' ).'</a>',
        );
        return array_merge( $mylinks, $links );
    }
}

if ( !isset($RUSAC_Settings) ) {
	$RUSAC_Settings = new RUSAC_Settings();
}