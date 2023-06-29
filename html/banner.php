<?php

function getUserIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? "";
    }
    return $ip;
}

const ADD_VIEW_COUNT = 1;

$db_host = $_ENV['mysql_host'] ?? null;
$db_user = $_ENV['mysql_user'] ?? null;
$db_password = $_ENV['mysql_password'] ?? null;
$db_name = $_ENV['mysql_database'] ?? null;

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ip_address = getUserIp();
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    $page_url = $_SERVER['HTTP_REFERER'] ?? "";
    $hash = md5($ip_address . $user_agent . $page_url);
    $views_count = ADD_VIEW_COUNT;

    $sql = "INSERT INTO visitor_info (hash, ip_address, user_agent, page_url, views_count) 
        VALUES (:hash, :ip_address, :user_agent, :page_url, :views_count)
        ON DUPLICATE KEY UPDATE views_count = views_count + :views_count";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hash', $hash);
    $stmt->bindParam(':ip_address', $ip_address);
    $stmt->bindParam(':user_agent', $user_agent);
    $stmt->bindParam(':page_url', $page_url);
    $stmt->bindParam(':views_count', $views_count, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Data successfully inserted or updated in tables.";
    } else {
        echo "Error executing PDO statement: " . $stmt->errorInfo()[2];
    }
} catch (PDOException $e) {
    echo "Error DB connection: " . $e->getMessage();
}
?>
