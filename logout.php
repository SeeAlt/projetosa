<?php
session_start();
session_destroy();
header("Location: index.html"); // ou para a página que desejar
exit();
