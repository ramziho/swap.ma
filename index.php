<?php
include('model/database.php');
print_r(dbGets('select * from users'));
?>