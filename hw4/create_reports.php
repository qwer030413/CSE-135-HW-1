<?php
require_once "auth.php";
Role(['analyst','super_admin']);

$db = new PDO(
"mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
"chris",
"1234!Apple"
);

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $title = $_POST["title"] ?? "";
    $category = $_POST["category"] ?? "";
    $comment = $_POST["analyst_comment"];

    $query = $db->prepare("
        INSERT INTO reports (title, category, analyst_comment)
        VALUES (?, ?, ?)
    ");

    $query->execute([$title,$category,$comment]);

    $msg = "report is saved";
}
?>
<!doctype html>
<html>
    <body>
        <h1>Create comments for reports</h1>
        <a href="dashboard.php" style = "padding: 10px; border-radius:5px; background-color:lightblue;">Dashboard</a>
        <h2>All events report</h2>
        <form method="POST" style = "display: flex; flex-direction:column; width: 500px; background-color:#8A9DF2; padding: 10px; border-radius: 10px; gap:5px;">
            <label>title</label>
            <input name="title" value="">
            <label>category</label>
            <select name="category" required>
                <option value="">Select report</option>
                <option value="all_events">All Events</option>
                <option value="mouse_events">mouse movements</option>
                <option value="event_type">event type distribution</option>
                <option value="data_table">data table</option>
            </select>
            <label>comment</label>
            <textarea name="analyst_comment" rows="5" cols="60"></textarea>
            <br>
            <button type="submit">Save</button>
        </form>
    </body>

</html>