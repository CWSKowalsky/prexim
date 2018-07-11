<?php

use Contao\CoreBundle\ContaoCoreBundle;

$GLOBALS['BE_MOD']['merconis']['prex'] = array(
	'tables' => array('tl_prex')
);

$GLOBALS['BE_MOD']['merconis']['prim'] = array(
	'callback'  => 'Prim'
);

$GLOBALS['FE_MOD']['prex'] = array
(
	'prex_list'     => 'ModulePrexList',
);