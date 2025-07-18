<?php

class My_DB_Handler {

    // Helper method to return table name with prefix
    public static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . 'my_api_plugin_users';
    }

    // Called on plugin activation
    public static function create_table() {
        global $wpdb;
        $table = self::get_table_name();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            date DATE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_email_date (email, date)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        error_log('Table creation attempted: ' . $table);
    }

    // Insert user data into DB
    public static function insert_user($name, $email, $date) {
        global $wpdb;
        $table = self::get_table_name();

        // Optional: Prevent duplicates
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE email = %s AND date = %s",
            $email,
            $date
        ));

        if ($existing > 0) {
            error_log("Duplicate detected: $email on $date");
            return false;
        }

        $result = $wpdb->insert(
            $table,
            [
                'name' => $name,
                'email' => $email,
                'date' => $date,
            ],
            ['%s', '%s', '%s']
        );

        if ($result === false) {
            error_log("Insert failed: " . $wpdb->last_error);
            return false;
        }

        error_log("Inserted: $name, $email, $date");
        return true;
    }

    // Called on plugin deactivation
    public static function on_deactivate() {
        global $wpdb;
        $table = self::get_table_name();
        $wpdb->query("DROP TABLE IF EXISTS $table");
        error_log("Table dropped: $table");
    }
}
