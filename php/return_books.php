<?php

session_start();
include 'connection.php';
$connection = getDatabaseConnection();

date_default_timezone_set('Asia/Colombo');
$return_date = date('Y-m-d');

$issue_date = "";
$book_title = "";
$alert = "";
$alert_type = "";

// Handle Return Book
if (isset($_POST['return'])) {
    $reg_no = trim($_POST['reg_no']);
    $book_id = trim($_POST['book_id']);

    if (empty($reg_no) || empty($book_id)) {
        $alert = "Please fill all required fields!";
        $alert_type = "danger";
    } 
    else {
        $stmt = $connection->prepare("SELECT ir.issue_date, b.title, b.status FROM issue_return ir JOIN book_information b ON ir.book_id = b.id WHERE ir.registration_no = ? AND ir.book_id = ? AND ir.action = 'issue' ORDER BY ir.id DESC LIMIT 1");
        $stmt->bind_param("ii", $reg_no, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $alert = "No issued record found for this book!";
            $alert_type = "danger";
        } 
        else {
            $row = $result->fetch_assoc();
            $issue_date = $row['issue_date'];
            $book_title = $row['title'];

            if ($row['status'] === 'available') {
                $alert = "This book is not currently issued!";
                $alert_type = "warning";
            } 
            else {
                // Add return record
                $insert = $connection->prepare("INSERT INTO issue_return (registration_no, book_id, action, issue_date, return_date) VALUES (?, ?, 'return', ?, ?)");
                $insert->bind_param("iiss", $reg_no, $book_id, $issue_date, $return_date);
                $insert->execute();

                // Mark book as available
                $update = $connection->prepare("UPDATE book_information SET status = 'available' WHERE id = ?");
                $update->bind_param("i", $book_id);
                $update->execute();

                $alert = "😍 Book returned successfully!";
                $alert_type = "success";
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>ITUM Library Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="topbar">
  <div class="brand">ITUM Library Management System</div>
  <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="sidebar">
  <a href="dashboard.php" class="nav-item"><i class="fa-solid fa-table-cells"></i>Dashboard</a>
  <a href="book_management.php" class="nav-item"><i class="fa-solid fa-book"></i>Book Management</a>
  <a href="issue_books.php" class="nav-item"><i class="fa-solid fa-paper-plane"></i>Issue Books</a>
  <a href="#" class="nav-item active"><i class="fa-solid fa-rotate-left"></i>Return Books</a>

  <?php if ($_SESSION["role"] == "Admin") { ?>
      <a href="member.php" class="nav-item"><i class="fa-solid fa-users"></i>Members</a>
      <a href="report.php" class="nav-item"><i class="fa-solid fa-chart-simple"></i>Reports</a>
      <a href="fine_management.php" class="nav-item"><i class="fa-solid fa-money-bill-wave"></i>Fine Management</a>
  <?php } ?>

  <div class="bottom-profile">
      <i class="fa-solid fa-user"></i><?= htmlspecialchars($_SESSION["first_name"]) ?>
  </div>
</div>

<main class="main">

  <!-- ==== INLINE ALERT MESSAGE ==== -->
  <?php if (!empty($alert)) { ?>
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show mt-2" role="alert">
          <?= $alert ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
  <?php } ?>
  <!-- ============================== -->

  <div class="form_container issue" style="background: none;">
    <div class="section2 issue_books">
      <form action="" method="post">
        <h2>Return Book Form</h2>

        <div class="input_box">
          <label>Registration No</label>
          <input type="text" name="reg_no" value="<?= htmlspecialchars($_SESSION['reg_no']) ?>" readonly>
        </div>

        <div class="input_box">
          <label>Student Name</label>
          <input type="text" name="student_name" value="<?= htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']) ?>" readonly>
        </div>

        <div class="flex">
          <div class="input_box">
            <label>Book ID</label>
            <input type="text" name="book_id" value="<?= isset($_POST['book_id']) ? htmlspecialchars($_POST['book_id']) : '' ?>" required>
          </div>
          <div class="input_box">
            <label>Book Title</label>
            <input type="text" name="book_title" value="<?= htmlspecialchars($book_title) ?>" readonly>
          </div>
        </div>

        <div class="flex">
          <div class="input_box">
            <label>Issue Date</label>
            <input type="date" name="issue_date" value="<?= $issue_date ?>" readonly>
          </div>
          <div class="input_box">
            <label>Return Date</label>
            <input type="date" name="return_date" value="<?= $return_date ?>" readonly>
          </div>
        </div>

        <button type="submit" name="return">Return</button>
      </form>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
