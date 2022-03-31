Requirements
------------
- mysql 5.6+
- php 7.0+
- composer (composer.phar file)

Installation (development)
------------
- Move to the project directory: `cd path/to/project`
- Init an empty git repository: `git init`
- Add remote: `git remote add origin https://github.com/GenieHub01/GPingV2Final-01A.git`
- Pull the repository to your working directory: `git pull origin master`
- Initialize an application with the command: `php init`
then choose the Development environment
- Configure `/common/config/db.php` to connect to MySQL.
- Run composer with the command: `php path/to/composer.phar install`
- Run migrations: `php yii migrate` then type `yes` or just `y`

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
 