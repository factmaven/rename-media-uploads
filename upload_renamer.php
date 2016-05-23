<?php
/*
Plugin Name: Upload Renamer
Plugin URI: http://www.factmaven.com/
Description: Renames uploaded media files by random chars or any other pattern.
Version: 1.0.5
Author: Fact Maven Corp.
Author URI: http://www.factmaven.com/
License: GNU v2
*/
if (!class_exists('upload_renamer')) {
    class upload_renamer
    {
        protected $defaultOpts = array('mode' => 'char', 'length' => 5, 'param' => '');
        //　Construct
        public function __construct()
        {
            if (is_admin()) {
                $plugin = plugin_basename(__FILE__);
                add_action('admin_init', array(
                    &$this,
                    'register'
                ));
                add_action('admin_menu', array(
                    &$this,
                    'menu'
                ));
                add_filter('plugin_action_links_' . $plugin, array(
                    &$this,
                    'link'
                ));
                add_filter('wp_handle_upload_prefilter', array(
                    &$this,
                    'rename'
                ));
            }
        }
        // Register setting
        public function register()
        {
            register_setting('upload_renamer_setting', 'upload_renamer_options');
        }
        // Add item under "Media" menu
        public function menu()
        {
            add_media_page('Upload Renamer', 'Upload Renamer', 'administrator', 'upload_renamer', array(
                &$this,
                'setting'
            ));
        }
        // Renaming process
        public function rename($file)
        {
            $wp_filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], false);
            extract($wp_filetype);
            if (!$ext)
                $ext = ltrim(strrchr($file['name'], '.'), '.');
            $options      = $this->option();
            $newname      = $this->_name($options['mode'], (int) $options['length'], (string) $options['param']) . '.' . $ext;
            $file['name'] = str_replace('%file%', substr($file['name'], 0, -(strlen($ext) + 1)), $newname);
            return $file;
        }
        // Renaming types & function
        protected function _name($mode, $length = 5, $param = '')
        {
            switch ($mode) {
                case 'char-mixed':
                    $chars = empty($param) ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789' : (string) $param;
                    $chars = str_shuffle($chars);
                    $str   = substr($chars, 0, $length);
                    break;
                case 'char-lower':
                    $chars = empty($param) ? 'abcdefghijklmnopqrstuvwxyz0123456789' : (string) $param;
                    $chars = str_shuffle($chars);
                    $str   = substr($chars, 0, $length);
                    break;
                case 'char-upper':
                    $chars = empty($param) ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' : (string) $param;
                    $chars = str_shuffle($chars);
                    $str   = substr($chars, 0, $length);
                    break;
                case 'num':
                    $str = sprintf("%0{$length}d", rand(0, str_repeat('9', $length)));
                    break;
                case 'date':
                    $format = empty($param) ? 'Ymd_His' : $param;
                    $str    = date($format);
                    break;
                case 'custom':
                    if (empty($param))
                        return $this->_name('char', 5);
                    preg_match_all('/%((file|date|char|num)(\|[^%]+)?)%/', $param, $m);
                    foreach ($m[0] as $v) {
                        $args = explode('|', trim($v, '%'));
                        if (in_array($args[0], array(
                            'char',
                            'num'
                        )))
                            $rp = $this->_name($args[0], empty($args[1]) ? 5 : (int) $args[1]);
                        else if ($args[0] == 'date')
                            $rp = $this->_name($args[0], 0, empty($args[1]) ? '' : (int) $args[1]);
                        else
                            continue;
                        $param = str_replace($v, $rp, $param);
                    }
                    $str = $param;
                    break;
                default:
                    $str = '';
            }
            return $str;
        }
        function link($links)
        {
            $settings_link = '<a href="options-general.php?page=upload_renamer">' . $this->__('Settings') . '</a>';
            array_unshift($links, $settings_link);
            return $links;
        }
        // Setting options page.
        public function setting()
        {
            if (!current_user_can('manage_options')) {
                wp_die($this->__('You do not have sufficient permissions to access this page.'));
                return;
            }
            include(dirname(__FILE__) . '/options.php');
        }
        // get options
        function option($key = '')
        {
            $option = get_option('upload_renamer_options') ? get_option('upload_renamer_options') : array();
            $option = array_merge($this->defaultOpts, $option);
            if ($key)
                $return = $option[$key];
            else
                $return = $option;
            return $return;
        }
        //Language
        public function __($key)
        {
            return __($key, 'upload_renamer');
        }
    }
}
add_action('init', 'upload_renamer_init');
function upload_renamer_init()
{
    if (class_exists('upload_renamer')) {
        new upload_renamer();
    }
}
//register_uninstall_hook(__FILE__, array('upload_renamer', 'uninstall'));
?>