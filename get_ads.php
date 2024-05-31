<?php
$conn = new mysqli('localhost', 'root', '', 'mysite');
$result = $conn->query("SELECT title, description FROM ads");

while ($row = $result->fetch_assoc()) {
    echo '<div class="col-md-3 ad-card">';
    echo '  <div class="card">';
    echo '      <div class="card-body">';
    echo '          <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
    echo '          <p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
    echo '      </div>';
    echo '  </div>';
    echo '</div>';
}

$conn->close();
?>
