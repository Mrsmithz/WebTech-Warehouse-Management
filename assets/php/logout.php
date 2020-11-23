<?php
session_start();
session_destroy();
echo '<script type="text/javascript">',
        'window.location.href = "/projects/pg30hyr/login.php"',
            '</script>';
     exit;
?>
