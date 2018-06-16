<?php

class MysqlChangePasswordDriver implements \RainLoop\Providers\ChangePassword\ChangePasswordInterface
{
	/**
	 * @var string
	 */
	private $sAllowedEmails = '';
	private $sConfig = array(
		'host' => '',
		'user' => '',
		'pass' => '',
		'db' => '',
		'table' => '',
		'col_pass' => '',
		'col_email' => '',
		'enc_method' => ''
		);

	/**
	 * @param string $sAllowedEmails
	 *
	 * @return \ChangePasswordExampleDriver
	 */
	public function SetAllowedEmails($sAllowedEmails)
	{
		$this->sAllowedEmails = $sAllowedEmails;
		return $this;
	}
	public function FillSettings($config)
	{
 		$this->sConfig = array_merge($this->sConfig, $config);
	}

	/**
	 * @param \RainLoop\Model\Account $oAccount
	 *
	 * @return bool
	 */
	public function PasswordChangePossibility($oAccount)
	{
		return $oAccount && $oAccount->Email() &&
			\RainLoop\Plugins\Helper::ValidateWildcardValues($oAccount->Email(), $this->sAllowedEmails);
	}

	/**
	 * @param \RainLoop\Model\Account $oAccount
	 * @param string $sPrevPassword
	 * @param string $sNewPassword
	 *
	 * @return bool
	 */
	public function ChangePassword(\RainLoop\Account $oAccount, $sPrevPassword, $sNewPassword)
	{
		$bResult = false;

		$mysqli = new mysqli ($this->sConfig['host'], $this->sConfig['user'], $this->sConfig['pass'], $this->sConfig['db']);
		$str_query_start  = "UPDATE `".$this->sConfig['table']."` ";
		$str_query_start .= "SET `".$this->sConfig['col_pass']."`=";

		$str_query_enc    = '';
		switch($this->sConfig['enc_method']){
			case 'ENCRYPT':
				$str_query_enc = "ENCRYPT('". $sNewPassword ."') ";
				break;
			case 'HASH-SHA256':
				$str_query_enc = '';
				break;
                        case 'HASH-SHA512':
                                $str_query_enc = '';
                                break;
                        case 'HASH-MD5':
                                $str_query_enc = '';
                                break;
                        case 'None (For extremals)':
                                $str_query_enc = "'" .$sNewPassword ."'";
                                break;
			default:
				$str_query_enc = "ENCRYPT('". $sNewPassword ."') ";
		}
		$str_query_where  = "WHERE `".$this->sConfig['col_email']."`='". $oAccount->Email () ."'";

		$result = $mysqli->query ($str_query_start . $str_query_enc . $str_query_where);

		if ($result)
			$bResult = true;

		return $bResult;
	}
}
