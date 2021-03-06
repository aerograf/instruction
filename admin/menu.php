<?php

use XoopsModules\Instruction;

if (!isset($moduleDirName)) {
    $moduleDirName = basename(dirname(__DIR__));
}

/** @var Xmf\Module\Helper $moduleHelper */
if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}

$pathIcon32    = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

$moduleHelper->loadLanguage('modinfo');
$moduleHelper->loadLanguage('admin');

// Административное меню
$adminmenu = [
    [
        'title' => _MI_INSTRUCTION_ADMIN_HOME,
        'link'  => 'admin/index.php',
        'desc'  => _MI_INSTRUCTION_ADMIN_HOME_DESC,
        'icon'  => $pathIcon32 . '/home.png'
    ],
    [
        'title' => _MI_INSTRUCTION_ADMIN_CAT,
        'link'  => 'admin/cat.php',
        'desc'  => _MI_INSTRUCTION_ADMIN_CAT_DESC,
        'icon'  => $pathIcon32 . '/category.png'
    ],
    [
        'title' => _MI_INSTRUCTION_ADMIN_INSTR,
        'link'  => 'admin/instr.php',
        'desc'  => _MI_INSTRUCTION_ADMIN_INSTR_DESC,
        'icon'  => $pathModIcon32 . '/nav_book.png'
    ],
    [
        'title' => _MI_INSTRUCTION_ADMIN_PERM,
        'link'  => 'admin/perm.php',
        'desc'  => _MI_INSTRUCTION_ADMIN_PERM_DESC,
        'icon'  => $pathIcon32 . '/permissions.png'
    ],
    [
        'title' => _MI_INSTRUCTION_ADMIN_ABOUT,
        'link'  => 'admin/about.php',
        'desc'  => _MI_INSTRUCTION_ADMIN_ABOUT_DESC,
        'icon'  => $pathIcon32 . '/about.png'
    ]
];
