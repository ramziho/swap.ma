<?php
include('model/database.php');
print_r(dbGet('select * from users'));
?>