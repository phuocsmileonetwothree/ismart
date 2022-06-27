<?php

function category_tree($list_category, $cat_id){
	$result = array();
    foreach($list_category as $item){
		if($item['parent_id'] == $cat_id){
			$result[] = $item['cat_id'];
			unset($list_category[$item['cat_id']]);
			$child = category_tree($list_category, $item['cat_id']);
			$result = array_merge($result, $child);
		}
	}
	return $result;
}

// 1 parent 0
// 2 parent 1
// 3 parent 1
// 4 parnet 1
// 5 parnet
// 6
// 7