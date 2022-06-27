<div id="content">
    <form method="post">
        <h3>Login</h3>
        <?php echo form_error('acc_not_exist') ?>
        <input type="text" name="username" placeholder="Username" autofocus>
        <?php echo form_error('username') ?>
        <input type="password" name="password" placeholder="Password">
        <?php echo form_error('password') ?>
        <input type="submit" value="Login" name="btn_login">
    </form>
</div>
<style>
    p.error {
        flex-basis: 100%;
        text-align: center;
        color: #fff;
        font-size: 14px;
        margin: 0;
        margin-bottom: 20px;
    }

    body {
        margin: 0;
    }

    #content {
        border-radius: 4px;
        width: 320px;
        margin: 0 auto;
        margin-top: 20px;
        padding: 20px;
        background-color: #0093E9;
        background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 99%);
        padding-top: 0;
        box-shadow: 0 1px 6px 0 rgb(32 33 36 / 50%);
    }

    form {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    input {
        flex-basis: 70%;
        padding: 6px;
        margin-bottom: 20px;
        text-align: center;
        border-radius: 2px;
        border: none;
        outline: none;
    }

    input[type=submit] {
        flex-basis: 35%;
        border: none;
        outline: none;
        padding: 5px;
        font-size: 12px;
        background: #fff;
        margin-bottom: 0;
        z-index: 999;
        border-radius: 2px;
    }

    h3 {
        flex-basis: 100%;
        text-align: center;
        text-transform: uppercase;
        color: #ecf0f1;
        font-size: 30px;
    }
</style>