<?php

class My_Plugin_Core {

    public function init() {
        add_action('admin_menu', [$this, 'register_admin_menu']);
    }

    public function register_admin_menu() {
        add_menu_page(
            'My API Plugin',
            'API Plugin',
            'manage_options',
            'my-api-plugin',
            [$this, 'render_admin_page'],
            'dashicons-rest-api',
            80
        );
    }

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>Send User Data to API</h1>
            <form method="post">
                <?php wp_nonce_field('submit_user_data', 'user_data_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="name">Name</label></th>
                        <td><input name="name" type="text" required class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email">Email</label></th>
                        <td><input name="email" type="email" required class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="date">Date</label></th>
                        <td><input name="date" type="date" required></td>
                    </tr>
                </table>

                <?php submit_button('Submit & Send to API'); ?>
            </form>
        </div>
        <?php

        // Handle form submission
        if (
            isset($_POST['name'], $_POST['email'], $_POST['date']) &&
            check_admin_referer('submit_user_data', 'user_data_nonce')
        ) {
            $name  = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $date  = sanitize_text_field($_POST['date']);

            // Store in DB
            $inserted = My_DB_Handler::insert_user($name, $email, $date);

            if ($inserted) {
                $api = new My_API_Handler();
                $api->send_user_to_api([
                    'name'  => $name,
                    'email' => $email,
                    'date'  => $date,
                ]);
                echo '<div class="updated notice"><p>Data saved and sent to API.</p></div>';
            } else {
                echo '<div class="notice notice-warning"><p>Duplicate entry detected. Data not saved.</p></div>';
            }

        }
    }
}
