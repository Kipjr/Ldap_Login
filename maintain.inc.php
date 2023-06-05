<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin
 */
class Ldap_Login_maintain extends PluginMaintain
{
  /*
   * My pattern uses a single installation method, which handles both installation
   * and activation, where Piwigo always calls 'activate' just after 'install'
   * As a result I use a marker in order to not execute the installation method twice
   *
   * The installation function is called by main.inc.php and maintain.inc.php
   * in order to install and/or update the plugin.
   *
   * That's why all operations must be conditionned :
   *    - use "if empty" for configuration vars
   *    - use "IF NOT EXISTS" for table creation
   */
	private $installed = false;
	

	function __construct($plugin_id)
	{
		parent::__construct($plugin_id); // always call parent constructor

		// Class members can't be declared with computed values so initialization is done here
		if(!defined('LDAP_LOGIN_PATH')){
			// +-----------------------------------------------------------------------+
			// | Define plugin constants                                               |
			// +-----------------------------------------------------------------------+
			define('LDAP_LOGIN_ID',      basename(dirname(__FILE__)));
			define('LDAP_LOGIN_PATH' ,   PHPWG_PLUGINS_PATH . LDAP_LOGIN_ID . '/');
		
			include_once(LDAP_LOGIN_PATH.'/class.config.php');
			include_once(LDAP_LOGIN_PATH.'/class.log.php');
			include_once(LDAP_LOGIN_PATH.'/functions_sql.inc.php'); 
		}
		

	}
	function __destruct(){
		 //nothing
	}



	function install($plugin_version, &$errors=array())
	{
	/**
     * perform here all needed step for the plugin installation
     * such as create default config, add database tables,
     * add fields to existing tables, create local folders...
	 *
	 * Checks for data.dat and ./config/data.dat
	 * Migrates data.dat to ./config/data.dat
	 * Loads config from ./config/data.dat and imports it to SQL
	 * 
	 * If no config found load default config
	 * At the end, save the config to SQL
	 * 
	 * @since ~
	 *
	 */
		global $prefixeTable;
		
		$ld_config=new Config();
		$ld_log=new Log();
		
		if(!ld_table_exist()){ //new install or from old situation
			$ld_config->loadDefaultConfig();
			//prepare sql-table
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Created SQL-table");
			ld_sql('create','create_table');
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Created SQL-data from default values");
			ld_sql('create','create_data',$ld_config->getAllValues($default=true));
			
			//everyone, in old situation (ONCE)
			if (file_exists(LDAP_LOGIN_PATH .'/data.dat' ) && !file_exists(LDAP_LOGIN_PATH .'/config/data.dat' )) { //only in root not in .config/
				rename(LDAP_LOGIN_PATH . '/data.dat', LDAP_LOGIN_PATH .'/config/data.dat'); //migrate old location to new
				$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Moved data.dat");
			}
			
			//future, in new situation (inactivated plugin)
			if (file_exists(LDAP_LOGIN_PATH .'/config/data.dat' )) { 
				$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> loading ./config/data.dat ");
				$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> function load_old_config ");
				$ld_config->loadOldConfig(); // will overwrite default values
				unlink( LDAP_LOGIN_PATH .'/config/data.dat'  ); //delete data.dat
				$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> deleted ./config/data.dat ");
			}
			
		}
		else { 
			$ld_config->loadDefaultConfig();
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Default config loaded ");
			$ld_config->loadConfig($merge=True);
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Merged old config");
			ld_sql('create','create_data',$ld_config->getAllValues());
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Expanded database");
			ld_sql('update','update_sql_structure');
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Added Column with timestamps");
		}
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Saving config");
		$ld_config->saveConfig();
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> plugin installed");
		$this->installed = true;
		unset($ld_config);
		unset($ld_log);

	}


	function activate($plugin_version, &$errors=array())
	{
	/**
     * this function is triggered after installation, by manual activation
     * or after a plugin update
     * for this last case you must manage updates tasks of your plugin in this function
	 *
	 * Creates table and default data
	 * Clears log if parameter not set or True
	 * 
	 * @since ~
	 *
	 */
		$ld_config=new Config();
		$ld_log=new Log();
		$ld_config->loadDefaultConfig();
		$ld_config->loadConfig($merge=True);
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> activate");
		if (($ld_config->getValue('ld_debug_clearupdate') == 1) OR ($ld_config->getValue('ld_debug_clearupdate') == True))
		{   
			$full="\n";
			
			if(str_starts_with( $ld_config->getValue('ld_debug_location') , "/")) {
				# absolute
				if(is_writable( $ld_config->getValue('ld_debug_location') . 'ldap_login.log')){
					file_put_contents( $ld_config->getValue('ld_debug_location') . 'ldap_login.log',$full."\n");
				} else {
					$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]>Unable to write to " .  $ld_config->getValue('ld_debug_location') . 'ldap_login.log');
				}
			} else {
				# relative (nothing or ./logs/)
				if(is_writable(LDAP_LOGIN_PATH . 'logs/' . 'ldap_login.log')){
					file_put_contents( LDAP_LOGIN_PATH . 'logs/' . 'ldap_login.log',$full."\n");
				} else {
					$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]>Unable to write to " . LDAP_LOGIN_PATH . 'logs/' . 'ldap_login.log');
				}
			}			
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> Ldap_login.log cleared");
		}
		
		if (!$this->installed)
		{ 
			//this first after activation.

			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> [Maintain.inc.php/Install] ");
			$this->install($plugin_version, $errors); //then install
			$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> plugin activated");
		}
		unset($ld_config);
		unset($ld_log);
	}
	

	function update($old_version, $new_version, &$errors=array())
	{
	/**
	* Plugin (auto)update
	*
	* This function is called when Piwigo detects that the registered version of
	* the plugin is older than the version exposed in main.inc.php
	* Thus it's called after a plugin update from admin panel or a manual update by FTP
	* I (Kipjr) chosed to handle install and update in the same method
	* you are free to do otherwise
	*/
		$this->install($new_version, $errors);
	}
  
	function deactivate()
	{
	/**
	 * this function is triggered after deactivation, by manual deactivation
	 * or after a plugin update
	 *  
	 * Does nothing but writing in a log and exporting data
	 *
	 * @since ~
	 *
	 * 
	 * */
	 	
	 
	 	$ld_config=new Config();
	 	$ld_log=new Log();
		$ld_log->warning("[".basename(__FILE__)."/".__FUNCTION__."]> Check value of 'allow_user_registration' as no user is currently able to register.");
		$ld_log->debug("[".basename(__FILE__)."/".__FUNCTION__."]> deactivated");
		unset($ld_config);
		unset($ld_log);
	}

	function uninstall()
	{ 
	
	/**
	 * Perform here all cleaning tasks when the plugin is removed
     * you should revert all changes made in 'install'
	 *  
	 * Removes the SQL-table and writes in log
	 *
	 * @since ~
	 *
	 */	
		$ld_config=new Config();
		$ld_log=new Log();
		$ld_config->loadConfig();
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> uninstall");
		ld_sql('delete','delete_table');
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> removed piwigo_ldap_login_config table");
		$ld_log->writeLog("[".basename(__FILE__)."/".__FUNCTION__."]> plugin uninstalled");
		unset($ld_config);
		unset($ld_log);
	}
}
?>