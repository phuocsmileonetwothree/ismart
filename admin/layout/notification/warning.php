<div id="wp-blur" class="d-none <?php if(!empty($message)) echo "d-block" ?>">
    <div class="alert warning">
        <h2><strong>Warning!!!</strong></h2>
        <h3><?php if (!empty($message)) echo $message; ?></h3>
        <a class="close">&times;</a>
    </div>
</div>