<?php
include "db/db.php";

$conn = openCon();
insertQuery($conn);
closeCon($conn);
?>