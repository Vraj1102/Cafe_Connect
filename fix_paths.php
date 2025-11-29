<?php
// Path Fix Script - Run this once to fix all file paths

$directories = ['customer', 'admin', 'shop'];
$fixes = 0;

foreach ($directories as $dir) {
    $files = glob("$dir/*.php");
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $original = $content;
        
        // Fix includes
        $content = str_replace('include("conn_db.php")', 'include("../config/conn_db.php")', $content);
        $content = str_replace("include('conn_db.php')", "include('../config/conn_db.php')", $content);
        $content = str_replace('include("head.php")', 'include("../includes/head.php")', $content);
        $content = str_replace("include('head.php')", "include('../includes/head.php')", $content);
        $content = str_replace('include("nav_header.php")', 'include("../includes/nav_header.php")', $content);
        $content = str_replace("include('nav_header.php')", "include('../includes/nav_header.php')", $content);
        $content = str_replace('include("restricted.php")', 'include("../includes/restricted.php")', $content);
        $content = str_replace("include('restricted.php')", "include('../includes/restricted.php')", $content);
        
        // Fix CSS paths
        $content = str_replace('href="css/', 'href="../assets/css/', $content);
        $content = str_replace("href='css/", "href='../assets/css/", $content);
        
        // Fix JS paths
        $content = str_replace('src="js/', 'src="../assets/js/', $content);
        $content = str_replace("src='js/", "src='../assets/js/", $content);
        
        // Fix image paths in src attributes
        $content = str_replace('src="img/', 'src="/Sai Cafe/assets/img/', $content);
        $content = str_replace("src='img/", "src='/Sai Cafe/assets/img/", $content);
        $content = str_replace('src=\\"img/', 'src=\\"/Sai Cafe/assets/img/', $content);
        $content = str_replace("src=\\'img/", "src=\\'/Sai Cafe/assets/img/", $content);
        
        // Fix background image paths
        $content = str_replace("'img/default.jpg'", "'/Sai Cafe/assets/img/default.jpg'", $content);
        $content = str_replace("'img/default.png'", "'/Sai Cafe/assets/img/default.jpg'", $content);
        $content = preg_replace("/'img\/([^']+)'/", "'/Sai Cafe/assets/img/$1'", $content);
        
        // Fix header location redirects
        $content = str_replace('header("location: index.php")', 'header("location: /Sai Cafe/index.php")', $content);
        $content = str_replace("header('location: index.php')", "header('location: /Sai Cafe/index.php')", $content);
        
        if ($content !== $original) {
            file_put_contents($file, $content);
            $fixes++;
            echo "Fixed: $file\n";
        }
    }
}

echo "\nTotal files fixed: $fixes\n";
echo "Path fixes complete!\n";
?>
