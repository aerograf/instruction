<?php
// Плагин для модуля "tag"
// Информация об теге
/**
 * @param $items
 * @return bool
 */
use XoopsModules\Instruction;
 
function instruction_tag_iteminfo(&$items)
{
    if (0 === count($items) || !is_array($items)) {
        return false;
    }

    $items_id = [];
    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            $items_id[] = (int)$item_id;
        }
    }
    $db = \XoopsDatabaseFactory::getDatabase();
    //$itemHandler = new Instruction\InstructionHandler($db);
    //$itemHandler = xoops_getModuleHandler('instruction', 'instruction');
    $itemHandler = new \XoopsModules\Instruction\InstructionHandler($db);
    $items_obj   = $itemHandler->getObjects(new \Criteria('instrid', '(' . implode(', ', $items_id) . ')', 'IN'), true);

    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            if (isset($items_obj[$item_id])) {
                $item_obj                 = $items_obj[$item_id];
                $items[$cat_id][$item_id] = [
                    'title'   => $item_obj->getVar('title'),
                    'uid'     => $item_obj->getVar('uid'),
                    'link'    => "instr.php?id={$item_id}",
                    'time'    => $item_obj->getVar('datecreated'),
                    'tags'    => '',
                    'content' => '',
                ];
            }
        }
    }
    unset($items_obj);
    
    return '';
}

// Синхронизация тегов
/**
 * @param $mid
 */
function instruction_tag_synchronization($mid)
{
    $db = \XoopsDatabaseFactory::getDatabase();
    //$itemHandler = new instruction\InstructionHandler($db);
    //$itemHandler = xoops_getModuleHandler('instruction', 'instruction');
    $itemHandler = new \XoopsModules\Instruction\InstructionHandler($db);
    $linkHandler = xoops_getModuleHandler('link', 'tag');

    /* clear tag-item links */
    if (version_compare($GLOBALS['xoopsDB']->getServerVersion(), '4.1.0', 'ge')):
        $sql = "    DELETE FROM {$linkHandler->table}"
               . '    WHERE '
               . "        tag_modid = {$mid}"
               . '        AND '
               . '        ( tag_itemid NOT IN '
               . "            ( SELECT DISTINCT {$itemHandler->keyName} "
               . "                FROM {$itemHandler->table} "
               . "                WHERE {$itemHandler->table}.status > 0"
               . '            ) '
               . '        )'; else:
        $sql = "    DELETE {$linkHandler->table} FROM {$linkHandler->table}"
               . "    LEFT JOIN {$itemHandler->table} AS aa ON {$linkHandler->table}.tag_itemid = aa.{$itemHandler->keyName} "
               . '    WHERE '
               . "        tag_modid = {$mid}"
               . '        AND '
               . "        ( aa.{$itemHandler->keyName} IS NULL"
               . '            OR aa.status < 1'
               . '        )';
    endif;
    if (!$result = $linkHandler->db->queryF($sql)) {
        //xoops_error($linkHandler->db->error());
    }
}
