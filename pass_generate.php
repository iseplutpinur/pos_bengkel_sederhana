<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generate</title>
</head>

<body>
    <form action="" method="POST">
        <input type="text" name="pass">
        <button type="submit">Ubah</button>
    </form>
    <?php if (isset($_POST['pass'])) : ?>
        <input type="text" name="result" value="<?= password_hash($_POST['pass'], PASSWORD_DEFAULT); ?>">
        <button onclick="copyPass()">Copy</button>
        <script>
            function copyPass() {
                let text = document.querySelector('input[name=result]');
                text.select();
                document.execCommand('copy');
            }
        </script>
    <?php endif; ?>
</body>

</html>