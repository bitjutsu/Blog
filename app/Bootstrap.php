<?php

# Set up constants:

# Create the database:
$db = new SQLite3(dirname(__FILE__).'/../data/sqlite.prod');
$db->exec(
    "CREATE TABLE IF NOT EXISTS posts (
        id INTEGER PRIMARY KEY,
        title STRING NOT NULL,
        body STRING NOT NULL,
        date_created INTEGER NOT NULL,
        date_modified INTEGER NOT NULL
    )"
);
$db->close();

# Include the Layout - will be the entry point to the app:
include 'Layout.php';
