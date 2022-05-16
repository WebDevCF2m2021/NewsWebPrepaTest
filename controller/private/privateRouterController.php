<?php

use NewsWeb\Manager\theuserManager;

if (isset($_GET["disconnect"]) || $_SESSION["idSession"] !== session_id()) {
    theuserManager::disconnect();
    header("Location: ./");
}
else {
    echo "<h1>You are logged in!</h1>";
    echo "<p><a href='?disconnect'>Logout?</a></p>";
}