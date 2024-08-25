<?php
header('Content-Type: application/json');

$dataset = [
    ['username' => 'user1', 'service' => 'print', 'options' => 'black and white', 'image_file' => 'image1.jpg', 'price' => 10.00],
    ['username' => 'user2', 'service' => 'print', 'options' => 'color', 'image_file' => 'image2.jpg', 'price' => 15.00],
    ['username' => 'user3', 'service' => 'bike rental', 'options' => 'city bike', 'image_file' => 'image3.jpg', 'price' => 25.00],
    ['username' => 'user4', 'service' => 'bike rental', 'options' => 'mountain bike', 'image_file' => 'image4.jpg', 'price' => 30.00],
    ['username' => 'user5', 'service' => 'print', 'options' => 'black and white', 'image_file' => 'image5.jpg', 'price' => 12.00],
    ['username' => 'user6', 'service' => 'print', 'options' => 'color', 'image_file' => 'image6.jpg', 'price' => 18.00],
    ['username' => 'user7', 'service' => 'bike rental', 'options' => 'city bike', 'image_file' => 'image7.jpg', 'price' => 20.00],
    ['username' => 'user8', 'service' => 'bike rental', 'options' => 'mountain bike', 'image_file' => 'image8.jpg', 'price' => 28.00],
    ['username' => 'user9', 'service' => 'print', 'options' => 'black and white', 'image_file' => 'image9.jpg', 'price' => 14.00],
    ['username' => 'user10', 'service' => 'print', 'options' => 'color', 'image_file' => 'image10.jpg', 'price' => 22.00],
    ['username' => 'user11', 'service' => 'bike rental', 'options' => 'city bike', 'image_file' => 'image11.jpg', 'price' => 18.00],
    ['username' => 'user12', 'service' => 'bike rental', 'options' => 'mountain bike', 'image_file' => 'image12.jpg', 'price' => 32.00],
    ['username' => 'user13', 'service' => 'print', 'options' => 'black and white', 'image_file' => 'image13.jpg', 'price' => 11.00],
    ['username' => 'user14', 'service' => 'print', 'options' => 'color', 'image_file' => 'image14.jpg', 'price' => 17.00],
    ['username' => 'user15', 'service' => 'bike rental', 'options' => 'city bike', 'image_file' => 'image15.jpg', 'price' => 24.00],
    ['username' => 'user16', 'service' => 'bike rental', 'options' => 'mountain bike', 'image_file' => 'image16.jpg', 'price' => 29.00],
    ['username' => 'user17', 'service' => 'print', 'options' => 'black and white', 'image_file' => 'image17.jpg', 'price' => 13.00],
    ['username' => 'user18', 'service' => 'print', 'options' => 'color', 'image_file' => 'image18.jpg', 'price' => 19.00],
    ['username' => 'user19', 'service' => 'bike rental', 'options' => 'city bike', 'image_file' => 'image19.jpg', 'price' => 22.00],
    ['username' => 'user20', 'service' => 'bike rental', 'options' => 'mountain bike', 'image_file' => 'image20.jpg', 'price' => 35.00],
];

// Define filter criteria
$filter_criteria = [
    'service' => 'bike rental',
    'options' => 'city bike'
];

// Filter dataset
$filtered_data = array_filter($dataset, function($item) use ($filter_criteria) {
    foreach ($filter_criteria as $key => $value) {
        if ($item[$key] != $value) {
            return false;
        }
    }
    return true;
});

// print_r($filtered_data);

echo json_encode(array_values($filtered_data));
?>
