<?php
header('Content-Type: application/json');
require_once "db.php";

$response = ['success' => false, 'songs' => []];

try {
    // Если есть поисковый запрос
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $sql = "SELECT * FROM songs 
                WHERE title LIKE '%$search%' 
                OR artist LIKE '%$search%'
                OR genre LIKE '%$search%'
                ORDER BY title";
        // УБЕРИТЕ LIMIT 20
    } 
    // Иначе все песни
    else {
        $sql = "SELECT * FROM songs ORDER BY title";
    }
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $songs = [];
        while ($row = mysqli_fetch_assoc($result)) {
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
        
        $response['success'] = true;
        $response['songs'] = $songs;
        $response['count'] = count($songs);
        $response['query'] = $sql; // Для отладки
        $response['total_in_db'] = mysqli_num_rows($result); // Для отладки
    } else {
        $response['error'] = mysqli_error($conn);
    }
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>