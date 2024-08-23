<?php
// Define the directory path (current directory)
$directoryPath = './';

// Get all files in the directory
$files = scandir($directoryPath);

// Filter for .html files
$htmlFiles = array_filter($files, function($file) use ($directoryPath) {
    return is_file($directoryPath . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'html';
});

// Function to extract the <title> content from an HTML file
function getTitleFromHtml($filePath) {
    $content = file_get_contents($filePath);
    if ($content === false) {
        return 'Unable to read file';
    }

    // Use DOMDocument to parse HTML and extract <title> content
    $dom = new DOMDocument;
    @$dom->loadHTML($content);
    $title = $dom->getElementsByTagName('title')->item(0);

    return $title ? $title->textContent : 'No title found';
}

// Function to extract the keywords from <meta name="keywords"> tag
function getKeywordsFromHtml($filePath) {
    $content = file_get_contents($filePath);
    if ($content === false) {
        return 'Unable to read file';
    }

    // Use DOMDocument to parse HTML and extract <meta name="keywords"> content
    $dom = new DOMDocument;
    @$dom->loadHTML($content);
    $metaTags = $dom->getElementsByTagName('meta');

    foreach ($metaTags as $metaTag) {
        if ($metaTag->getAttribute('name') === 'keywords') {
            return $metaTag->getAttribute('content');
        }
    }

    return 'No keywords found';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Files DataTable</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<h1>HTML Files DataTable</h1>

<table id="filesTable">
    <thead>
        <tr>
            <th>File Name</th>
            <th>Title</th>
            <th>Keywords</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($htmlFiles as $file): ?>
            <tr>
                <td><?php echo htmlspecialchars($file); ?></td>
                <td><?php echo htmlspecialchars(getTitleFromHtml($directoryPath . $file)); ?></td>
                <td><?php echo htmlspecialchars(getKeywordsFromHtml($directoryPath . $file)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#filesTable').DataTable({
          "paging": false,
        });
    });
</script>

</body>
</html>
