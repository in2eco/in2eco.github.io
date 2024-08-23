<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="index.css"> -->
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" rel="stylesheet">
</head>
<body>
    <!-- <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div> -->
    <table id="websites" class="display" style="width:100%">

    </table>
    <script>
      let data = [
        {"title": "Free Static Website Hosting on Github with Custom Domain", "publish_date": "2024-08-23"},
        {"title": "Car Camping in National Parks, USA", "publish_date": "2024-08-20"},
      ];
      // Get reference to the table element (or create one)
      const table = document.getElementById('websites');
      // table.border = 1; // Adds a border to the table

      // Create a table header row
      const headerRowContainer = document.createElement('thead');
      const headerRow = document.createElement('tr');
      const headers = ['Title', 'Publish Date'];
      headers.forEach(headerText => {
        const header = document.createElement('th');
        header.textContent = headerText;
        headerRow.appendChild(header);
      });
      headerRowContainer.appendChild(headerRow);
      table.appendChild(headerRowContainer);

      // Create table rows for each data entry
      const bodyRowContainer = document.createElement('tbody');
      data.forEach(item => {
        const row = document.createElement('tr');

        // Loop through each key in the object to create table cells
        for (const key in item) {
          const cell = document.createElement('td');
          cell.textContent = item[key];
          row.appendChild(cell);
        }

        // Add the row to the table
        bodyRowContainer.appendChild(row);
      });
      table.appendChild(bodyRowContainer);
      // Append the table to the document body (or another container)
      // document.body.appendChild(table);

    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script>new DataTable('#websites');</script>
</body>
</html>
