<?php

class MysqlChangePasswordPlugin extends \RainLoop\Plugins\AbstractPlugin
{
	public function Init()
	{
		$this->addHook('main.fabrica', 'MainFabrica');
	}

	/**
	 * @param string $sName
	 * @param mixed $oProvider
	 */
	public function MainFabrica($sName, &$oProvider)
	{
		switch ($sName)
		{
			case 'change-password':

				include_once __DIR__.'/MysqlChangePasswordDriver.php';

				$oProvider = new MysqlChangePasswordDriver();

				$oProvider->SetAllowedEmails(\strtolower(\trim($this->Config()->Get('plugin', 'allowed_emails', ''))));

			        $config = array(
					'host'        => trim($this->Config()->Get('plugin', 'sql_ch_pass_dbhost', '')),
					'user'        => trim($this->Config()->Get('plugin', 'sql_ch_pass_dbuser', '')),
					'pass'        => trim($this->Config()->Get('plugin', 'sql_ch_pass_dbpass', '')),
					'db'          => trim($this->Config()->Get('plugin', 'sql_ch_pass_dbname', '')),
 					'table'       => trim($this->Config()->Get('plugin', 'sql_ch_pass_tablename', '')),
					'col_pass'    => trim($this->Config()->Get('plugin', 'sql_ch_pass_passfield', '')),
					'col_email'   => trim($this->Config()->Get('plugin', 'sql_ch_pass_emailfield', '')),
					'enc_method'  => trim($this->Config()->Get('plugin', 'sql_ch_pass_encrmethod', ''))
				);

				$oProvider->FillSettings($config);
				break;
		}
	}

	/**
	 * @return array
	 */
	public function configMapping()
	{
		return array(
			\RainLoop\Plugins\Property::NewInstance('allowed_emails')->SetLabel('Allowed emails')
				->SetType(\RainLoop\Enumerations\PluginPropertyType::STRING_TEXT)
				->SetDescription('Allowed emails, space as delimiter, wildcard supported. Example: user1@domain1.net user2@domain1.net *@domain2.net')
				->SetDefaultValue('*'),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_dbhost')->SetLabel('Host address')
                                ->SetDescription('Host address to connect.')
                                ->SetDefaultValue('127.0.0.1'),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_dbuser')->SetLabel('DB User - Name')
                                ->SetDescription('Name of the MySQL user with privileges to UPDATE.')
                                ->SetDefaultValue(''),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_dbpass')->SetLabel('DB User - Password')
                                ->SetDescription('Password of the MySQL user with privileges to UPDATE.')
                                ->SetDefaultValue(''),
			\RainLoop\Plugins\Property::NewInstance('sql_ch_pass_dbname')->SetLabel('DB Name')
				->SetDescription('Name of the MySQL database.')
				->SetDefaultValue('mail'),
 			\RainLoop\Plugins\Property::NewInstance('sql_ch_pass_tablename')->SetLabel('Users table Name')
 				->SetDescription('Name of the MySQL table which contains user and password fields.')
 				->SetDefaultValue('users'),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_passfield')->SetLabel('Password field')
                                ->SetDescription('Name of the password field in users table.')
                                ->SetDefaultValue('password'),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_emailfield')->SetLabel('Email field')
                                ->SetDescription('Name of the unique email field to find user in table.')
                                ->SetDefaultValue('email'),
                        \RainLoop\Plugins\Property::NewInstance('sql_ch_pass_encrmethod')->SetLabel('Encryption method')
                                ->SetType(\RainLoop\Enumerations\PluginPropertyType::SELECTION)
                                ->SetDescription("How user's provided password will be stored in your db.")
                                ->SetDefaultValue(array('ENCRYPT', 'HASH-SHA256', 'HASH-SHA512', 'HASH-MD5', 'None (For extremals)'))
		);
	}
}
