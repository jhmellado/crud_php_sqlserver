<?php
session_destroy();

if (headers_sent()) {
    echo "<script> window.location.href='index.php?view=login'";
} else {
    header("Location: index.php?view=login");
}
