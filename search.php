<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>📚 Search & Sort Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
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
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        input[type="text"] {
            padding: 10px;
            flex: 1;
            min-width: 200px;
            border: 2px solid #4CAF50;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }
        input[type="text"]:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 5px rgba(46, 125, 50, 0.5);
        }
        button {
            padding: 10px 20px;
            border: none;
            background: #4CAF50;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #388e3c;
            transform: scale(1.05);
        }
        .sort-btn {
            background: #2196F3;
        }
        .sort-btn:hover {
            background: #0b7dda;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .no-result {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
        .add-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
            transition: 0.3s;
        }
        .add-link:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-search"></i> Search & Sort Books by Subject (Only Authors ending with Singh)</h2>
    <form method="GET">
        <input type="text" name="subject" placeholder="Enter subject name..." 
               value="<?php echo isset($_GET['subject']) ? $_GET['subject'] : ''; ?>" required>
        <button type="submit" name="search"><i class="fas fa-search"></i> Search</button>
        <button type="submit" name="sort" value="asc" class="sort-btn"><i class="fas fa-arrow-up"></i> Price Asc</button>
        <button type="submit" name="sort" value="desc" class="sort-btn"><i class="fas fa-arrow-down"></i> Price Desc</button>
    </form>

    <?php
    if (isset($_GET['subject'])) {
        $subject = $_GET['subject'];
        $order = "ASC"; // default

        if (isset($_GET['sort']) && $_GET['sort'] == "desc") {
            $order = "DESC";
        }

        
        $stmt = $conn->prepare("SELECT * FROM books  WHERE subject_name LIKE ? AND author_name LIKE ?  ORDER BY cost $order");
        $searchTerm = "%" . $subject . "%";
        $authorFilter = "% Singh";  
        $stmt->bind_param("ss", $searchTerm, $authorFilter);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Book Code</th>
                        <th>Book Name</th>
                        <th>Author Name</th>
                        <th>Subject Name</th>
                        <th>Cost</th>
                        <th>ISBN No</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['book_code']}</td>
                        <td>{$row['book_name']}</td>
                        <td>{$row['author_name']}</td>
                        <td>{$row['subject_name']}</td>
                        <td>₹{$row['cost']}</td>
                        <td>{$row['ISBN_No']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-result'>❌ No books found for subject '$subject' with author ending in 'Singh'</p>";
        }
    }
    ?>

    <a class="add-link" href="index.php"><i class="fas fa-plus-circle"></i> Add New Book</a>
</div>

</body>
</html>
