<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.04.2017
 * Time: 02:08
 */

include_once 'class/Helper.php';

use \ferhengo\regex\Helper as Helper;

header('Content-type: text/html; charset=utf-8');

$source = 'http://example.com';
$criteria = 'app';
Helper::followAllTheLinks($source, $criteria);

//print DAO::getAffectedRows();

$notAffectedLinks = Helper::getNotAffectedLinks();
foreach ($notAffectedLinks as $notAffectedLink) {
    Helper::followAllTheLinks($source, $criteria);
}