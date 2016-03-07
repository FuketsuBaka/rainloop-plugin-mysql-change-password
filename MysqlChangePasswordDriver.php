<?php

class MysqlChangePasswordDriver implements \RainLoop\Providers\ChangePassword\ChangePasswordInterface
{
	/**
	 * @var string
	 */
	private $sAllowedEmails = '';

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

		$config = array (
			'host' => '',
			'user' => '',
			'pass' => '',
			'db'   => '',
			);

    $mysqli = new mysqli ($config['host'], $config['user'], $config['pass'], $config['db']);
    $result = $mysqli->query ("UPDATE `user` SET `password`='". hash ('SHA256', $sNewPassword) ."' WHERE `email`='". $oAccount->Email () ."'");

    if ($result)
      $bResult = true;

		return $bResult;
	}
}