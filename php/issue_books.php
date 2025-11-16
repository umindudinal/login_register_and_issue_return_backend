<?php

session_start();
include 'connection.php';
$connection = getDatabaseConnection();

date_default_timezone_set('Asia/Colombo');
$issue_date = date('Y-m-d');
$due_date = date('Y-m-d', strtotime('+14 days'));

$alert = "";
$alert_type = "";

// Handle Issue Book form
if (isset($_POST['issue'])) {
    $reg_no = trim($_POST['reg_no']);
    $book_id = trim($_POST['book_id']);

    if (empty($reg_no) || empty($book_id)) {
        $alert = "Please fill all required fields.";
        $alert_type = "danger"; 
    } 
    else {
        $checkBook = $connection->prepare("SELECT status FROM book_information WHERE id = ?");
        $checkBook->bind_param("i", $book_id);
        $checkBook->execute();
        $result = $checkBook->get_result();

        if ($result->num_rows === 0) {
            $alert = "Book not found!";
            $alert_type = "danger";
        } 
        else {
            $book = $result->fetch_assoc();

            if ($book['status'] === 'issued') {
                $alert = "😢 This book is already issued.";
                $alert_type = "warning";
            } 
            else {
                $insert = $connection->prepare("INSERT INTO issue_return (registration_no, book_id, action, issue_date, due_date) VALUES (?, ?, 'issue', ?, ?)");
                $insert->bind_param("siss", $reg_no, $book_id, $issue_date, $due_date);

                if ($insert->execute()) {
                    $update = $connection->prepare("UPDATE book_information SET status = 'issued' WHERE id = ?");
                    $update->bind_param("i", $book_id);
                    $update->execute();

                    $alert = "😍 Book issued successfully!";
                    $alert_type = "success";
                } 
                else {
                    $alert = "Error issuing book: " . $insert->error;
                    $alert_type = "danger";
                }
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
    <a href="#" class="nav-item active"><i class="fa-solid fa-paper-plane"></i>Issue Books</a>
    <a href="return_books.php" class="nav-item"><i class="fa-solid fa-rotate-left"></i>Return Books</a>

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

    <!-- ===== ALERT BOX ===== -->
    <?php if (!empty($alert)) { ?>
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show mt-2" role="alert">
        <?= $alert ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <!-- ===================== -->

    <div class="form_container issue" style="background: none;">
      <div class="section2 issue_books">

        <form action="" method="post">
          <h2>Issue Book Form</h2>

          <div class="input_box">
            <label>Registration No</label>
            <input type="text" name="reg_no"
              value="<?= htmlspecialchars($_SESSION['reg_no']) ?>" readonly>
          </div>

          <div class="input_box">
            <label>Book ID</label>
            <input type="text" name="book_id" required>
          </div>

          <div class="input_box">
            <label>Issue Date</label>
            <input type="date" name="issue_date" value="<?= $issue_date ?>" readonly>
          </div>

          <div class="input_box">
            <label>Due Date</label>
            <input type="date" name="due_date" value="<?= $due_date ?>" readonly>
          </div>

          <button type="submit" name="issue">Issue</button>
        </form>

      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
