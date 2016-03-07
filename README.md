# rainloop-plugin-mysql-change-password

## Description

If you are using Postfix + Dovecot + MySQL as mail server with virtual users and want to allow user update their email password directly on Rainloop Wabmail, then this repo may help you. 

## Installation

1. Download the repo to your rainloop plugins folder `[rainloop root]/data/_data_/_default_/plugins/` and name as `mysql-change-password`.
2. Open `MysqlChangePasswordDriver.php` file to fill your MySQL connection info in $config parameter, save.
3. Log-in Rainloop admin and enable `mysql-change-password` plugin.

It works.

## 說明

如果你使用 Postfix + Dovecot 搭建郵件主機，並且透過 MySQL 進行虛擬化帳號管理，那麼此 reop 可以讓你的使用者直接在 Rainloop Webmail 的設定當中修改 Email 密碼。

## 安裝

1. 下載此 repo 到你的 rainloop plugins 目錄，一般是 `[rainloop root]/data/_data_/_default_/plugins/`，並且記得將目錄名稱改為 `mysql-change-password`。
2. 修改 `MysqlChangePasswordDriver.php` 檔案當中的 $config 並填入你的 MySQL 連線資訊。
3. 登入 Rainloop admin 並啟用 `mysql-change-password` 此 plugin。
