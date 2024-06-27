<?php
include_once 'db.php';

function add_kb_article($title, $content) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO knowledge_base (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function get_kb_articles() {
    $conn = db_connect();
    $result = $conn->query("SELECT * FROM knowledge_base ORDER BY created_at DESC");
    $articles = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $articles;
}

function get_kb_article($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM knowledge_base WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $article;
}

function update_kb_article($id, $title, $content) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE knowledge_base SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function delete_kb_article($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("DELETE FROM knowledge_base WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
