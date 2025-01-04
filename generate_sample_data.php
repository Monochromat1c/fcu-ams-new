<?php

$data = [
    [
        'asset_tag_id' => 'ASSET-001',
        'brand' => 'Dell',  // Make sure this brand exists in your brands table
        'model' => 'Latitude 5420',
        'specs' => 'Intel Core i5, 16GB RAM, 512GB SSD',
        'serial_number' => 'SN12345678',
        'cost' => '45000',
        'supplier' => 'TechVendor Inc',  // Make sure this supplier exists in your suppliers table
        'site' => 'Main Campus',  // Make sure this site exists in your sites table
        'location' => 'IT Department',  // Make sure this location exists in your locations table
        'category' => 'Laptop',  // Make sure this category exists in your categories table
        'department' => 'Information Technology',  // Make sure this department exists in your departments table
        'purchase_date' => '2024-01-15',
        'condition' => 'New',  // Should match a condition in your conditions table
        'status' => 'Available',  // Should match a status in your statuses table
        'assigned_to' => 'John Doe',
        'issued_date' => '2024-01-20',
        'notes' => 'Company laptop for development team'
    ],
    [
        'asset_tag_id' => 'ASSET-002',
        'brand' => 'HP',
        'model' => 'ProDesk 600',
        'specs' => 'Intel Core i7, 32GB RAM, 1TB SSD',
        'serial_number' => 'HP98765432',
        'cost' => '55000',
        'supplier' => 'TechVendor Inc',
        'site' => 'Main Campus',
        'location' => 'Finance Department',
        'category' => 'Desktop',
        'department' => 'Finance',
        'purchase_date' => '2024-01-16',
        'condition' => 'New',
        'status' => 'Available',
        'assigned_to' => 'Jane Smith',
        'issued_date' => '2024-01-21',
        'notes' => 'Finance department workstation'
    ],
    [
        'asset_tag_id' => 'ASSET-003',
        'brand' => 'Lenovo',
        'model' => 'ThinkPad X1',
        'specs' => 'Intel Core i7, 16GB RAM, 512GB SSD',
        'serial_number' => 'LN11223344',
        'cost' => '65000',
        'supplier' => 'TechVendor Inc',
        'site' => 'Main Campus',
        'location' => 'HR Department',
        'category' => 'Laptop',
        'department' => 'Human Resources',
        'purchase_date' => '2024-01-17',
        'condition' => 'New',
        'status' => 'Available',
        'assigned_to' => 'Robert Johnson',
        'issued_date' => '2024-01-22',
        'notes' => 'HR manager laptop'
    ]
];

// Open CSV file
$fp = fopen('sample_assets_import.csv', 'w');

// Write headers
fputcsv($fp, array_keys($data[0]));

// Write data
foreach ($data as $row) {
    fputcsv($fp, $row);
}

fclose($fp);

echo "Sample import file 'sample_assets_import.csv' has been generated.\n";
echo "\nBefore importing, please ensure that the following exist in your database:\n";
echo "Brands: Dell, HP, Lenovo\n";
echo "Suppliers: TechVendor Inc\n";
echo "Sites: Main Campus\n";
echo "Locations: IT Department, Finance Department, HR Department\n";
echo "Categories: Laptop, Desktop\n";
echo "Departments: Information Technology, Finance, Human Resources\n";
echo "Conditions: New\n";
echo "Statuses: Available\n"; 