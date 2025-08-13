<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>📚 Add New Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffffcc;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 2px solid #66a6ff;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }
        input:focus {
            border-color: #0052cc;
            box-shadow: 0 0 5px rgba(0,82,204,0.5);
        }
        button {
            padding: 12px;
            background: #66a6ff;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0052cc;
            transform: scale(1.05);
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
            transition: 0.3s;
        }
        a:hover {
            color: #0052cc;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-book"></i> Add New Book</h2>
    <form method="POST">
        <input type="number" name="book_code" placeholder="Book Code" required>
        <input type="text" name="book_name" placeholder="Book Name" required>
        <input type="text" name="author_name" placeholder="Author Name" required>
        <input type="text" name="subject_name" placeholder="Subject Name" required>
        <input type="number" step="0.01" name="cost" placeholder="Cost" required>
        <input type="text" name="isbn_no" placeholder="ISBN No" required>
        <button type="submit" name="submit"><i class="fas fa-plus-circle"></i> Add Book</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $book_code = $_POST['book_code'];
        $book_name = $_POST['book_name'];
        $author_name = $_POST['author_name'];
        $subject_name = $_POST['subject_name'];
        $cost = $_POST['cost'];
        $isbn_no = $_POST['isbn_no'];

        $stmt = $conn->prepare("INSERT INTO books (book_code, book_name, author_name, subject_name, cost, ISBN_No) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssds", $book_code, $book_name, $author_name, $subject_name, $cost, $isbn_no);

        if ($stmt->execute()) {
            echo "<p class='success'>✅ Book added successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
        }
    }
    ?>

    <a href="search.php"><i class="fas fa-search"></i> Go to Search</a>
</div>

</body>
</html>
