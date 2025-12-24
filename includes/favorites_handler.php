<?php
header('Content-Type: application/json');
require_once "db.php";

$user_id = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_id = isset($_POST['song_id']) ? (int)$_POST['song_id'] : 0;
    $action = $_POST['action'] ?? '';
    
    if ($song_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid song ID']);
        exit;
    }
    
    if ($action === 'add') {
        $stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Already in favorites']);
            exit;
        }
        
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, song_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Added to favorites']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        
    } elseif ($action === 'remove') {
        $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Removed from favorites']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        
    } elseif ($action === 'check') {
        $stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        echo json_encode([
            'success' => true,
            'is_favorite' => $result->num_rows > 0
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get_all') {
        $stmt = $conn->prepare("
            SELECT s.* FROM songs s
            JOIN favorites f ON s.id = f.song_id
            WHERE f.user_id = ?
            ORDER BY f.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = [
                'id' => $row['id'],
                'title' => htmlspecialchars($row['title']),
                'artist' => htmlspecialchars($row['artist']),
                'genre' => htmlspecialchars($row['genre']),
                'year' => $row['year'],
                'duration' => $row['duration'],
                'language' => htmlspecialchars($row['language']),
                'youtube_id' => $row['youtube_id']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'songs' => $songs
        ]);
    }
}
?>