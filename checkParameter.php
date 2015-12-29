<?php
/**
 * 小功能文件头部参数验证
 * 
 * @author boboit
 * @date 2015.12.1
*/  

error_reporting(E_ALL);
ini_set("display_errors", 1);

$chkID = 'b39e1e2211f63';
if (!isset($_GET[$chkID])) die;
