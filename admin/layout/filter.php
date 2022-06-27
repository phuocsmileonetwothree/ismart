<style>
    button#search {
        border-radius: 3px;
        border: 1px solid #afafaf;
        padding: 2px 15px;
        background: #fafafa !important;
    }
</style>
<?php if (!empty($data)) {
?>


    <!-- FILTER AND SEARCH -->
    <div class="filter-wp clearfix">
        <ul class="post-status fl-left">
            <?php foreach ($data['filter'] as $key => $value) {
                if ($key != 'all') {
                    if($key == 'still' or $key == 'out'){
                        $status = "&stocking={$key}";
                    }else{
                        $status = "&status={$key}";
                    }
                } else {
                    $status = "";
                }

            ?>

                <li class="<?php echo $key ?>"><a href="?mod=<?php echo get_module() ?>&action=<?php echo get_action() . $status ?>"><?php echo convert_filter($key) ?> <span class="count">(<?php echo $value ?>)</span></a></li>
            <?php
            } ?>
        </ul>
        <form method="GET" class="form-s fl-right">
            <input type="hidden" name="mod" value="<?php echo get_module() ?>">
            <input type="hidden" name="action" value="<?php echo get_action() ?>">
            <input type="text" name="key" id="s" placeholder="Tìm kiếm theo tên" value="<?php echo !empty($data['search']['key']) ? $data['search']['key'] : '' ?>">
            <button id="search" type="submit">Tìm kiếm</button>
        </form>
    </div>

    <!-- ACTIONS -->

    <div class="actions">
        <form method="GET" action="" class="form-actions">
            <select name="actions">
                <option value="0">Tác vụ</option>
                <?php foreach ($data['actions'] as $key => $value) {
                ?>
                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php
                } ?>
            </select>
            <input mod="<?php echo get_module(); ?>" type="submit" name="sm_action" value="Áp dụng" class="action-ajax">
        </form>
    </div>

<?php
} ?>