<?php
/*
Plugin Name: Top Head Plugin
Description: Adding script into head
Version: 1.0
Author: NNWeb
*/

// Hook za dodavanje admin menija
add_action('admin_menu', 'top_head_plugin_menu');

function top_head_plugin_menu() {
    // Dodaje novu stavku menija pod "Plugins"
    add_plugins_page('Top Head Plugin Settings', 'Top Head Plugin', 'manage_options', 'top-head-plugin', 'top_head_plugin_settings_page');
}

// Prikazuje stranicu podesavanja u dashboard-u
function top_head_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h2>Top Head Plugin</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields('top-head-plugin-settings');
                do_settings_sections('top-head-plugin-settings');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Registrovanje podesavanja
add_action('admin_init', 'top_head_plugin_settings_init');

function top_head_plugin_settings_init() {
    register_setting('top-head-plugin-settings', 'top_head_plugin_code');
    add_settings_section('top-head-plugin-settings-section', 'Skripta', 'top_head_plugin_settings_section_callback', 'top-head-plugin-settings');
    add_settings_field('top-head-plugin-code', 'Dodajte svoju skriptu ovde:', 'top_head_plugin_code_callback', 'top-head-plugin-settings', 'top-head-plugin-settings-section');
}

function top_head_plugin_settings_section_callback() { 
    echo '<p>Unesite svoju skriptu koju želite da dodate u <head>.</p>';
}

function top_head_plugin_code_callback() {
    $script = get_option('top_head_plugin_code');
    echo '<textarea name="top_head_plugin_code" style="width:100%;height:200px;">' . esc_textarea($script) . '</textarea>';
}

// Dodavanje skripte u head
add_action('wp_head', 'add_top_head_script');
function add_top_head_script() {
    $script = get_option('top_head_plugin_code');
    if (!empty($script)) {
        echo $script;
    }
}

?>