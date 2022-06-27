<?php
$module = get_module();
$action = get_action();
$list_root = array();
if ($action == 'index') {
    $cat_id = $_GET['cat_id'];
    $list_root = array_reverse(get_list_root_parent_by_cat_id($module, $action, $cat_id, $list_root));

}

if ($action == 'detail') {
    $id = $_GET['id'];
    if($module == 'product'){
        $detail = db_fetch_row("SELECT `cat_id`, `name` as `title`, `product_id` as `id` FROM `tbl_{$module}` WHERE `{$module}_id` = '{$id}'");
        $list_root = array_reverse(get_list_root_parent_by_cat_id($module, $action, $detail['cat_id'], $list_root));
    }
    if($module == 'post'){
        $detail = db_fetch_row("SELECT `cat_id`, `title`, `post_id` as `id` FROM `tbl_{$module}` WHERE `{$module}_id` = '{$id}'");
        $list_root = array_reverse(get_list_root_parent_by_cat_id($module, $action, $detail['cat_id'], $list_root));
    }
    if($module == 'page'){
        $detail = db_fetch_row("SELECT `title`, `page_id` as `id` FROM `tbl_{$module}` WHERE `{$module}_id` = '{$id}'");
        $detail['cat_id'] = 0;
        $list_root = array_reverse(get_list_root_parent_by_cat_id($module, $action, $detail['cat_id'], $list_root));
        $list_root[] = array(
            'id' => $detail['id'],
            'title' => $detail['title']
        );
    }

}

foreach($list_root as $key => $root){
    $root['title'] = create_slug($root['title']);
    if(!isset($root['id'])){
        $list_root[$key]['url'] = "category-{$module}/{$root['title']}-{$root['cat_id']}";
    }else{
        $list_root[$key]['url'] = "{$module}/{$root['title']}-{$root['id']}";
    }
}
?>
<div class="secion" id="breadcrumb-wp">
    <div class="secion-detail">
        <ul class="list-item clearfix">
            <li>
                <a href="index.html" title="">Trang chủ</a>
            </li>
            <?php foreach ($list_root as $root) {
            ?>
                <li>
                    <a href="<?php echo $root['url'] ?>" title=""><?php echo $root['title'] ?></a>
                </li>
            <?php
            } ?>

        </ul>
    </div>
</div>