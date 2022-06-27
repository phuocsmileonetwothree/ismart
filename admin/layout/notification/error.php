<div id="wp-blur" class="<?php if(!empty($message)) echo "d-block" ?>">
    <div class="alert error">
        <h2><strong>Error</strong></h2>
        <h3><?php if(!empty($message)) echo $message; ?></h3>
        <a class="close">&times;</a>
    </div>
</div>