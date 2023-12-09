<?php

function validate_message($message)
{
    // function to check if message is correct (must have at least 10 caracters (after trimming))
    $trimmedMessage = trim($message);
    return strlen($trimmedMessage) >=10;    
}

function validate_username($username)
{
    //'aaaa$" => false vì có chứa "$"
    //aaa111 => true
    return ctype_alnum($username);
}

function validate_email($email)
{
    return strpos($email, "@");
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = true;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here is the list of error messages that can be displayed:

    // "Message must be at least 10 characters long"
    $message = isset($_POST['message']) ? $_POST['message'] : "";
    if (validate_message($message) == false) {
        $message_error = "Message must be at least 10 characters long";
        $form_valid = false;
    }

    // "Please enter a username"
    // "Username should contain only letters and numbers"
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    if (empty($username)) {
        $user_error = "Please enter a username";
        $form_valid = false;
    } elseif (validate_username($username)==false) {
        $user_error = "Username should contain only letters and numbers";
        $form_valid = false;
    }
    
    // "Please enter an email"
    // "Email must contain '@'"
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    if (empty($email)) {
        $email_error = "Please enter an email";
        $form_valid = false;
    } elseif (validate_email($email)==false) {
        $email_error = "Invalid email format";
        $form_valid = false;
    }

    // "You must accept the Terms of Service"
    $term = isset($_POST['terms']) ? $_POST['terms'] : "";
    if (empty($term)) {
        $terms_error = "You must accept the Terms of Service";
        $form_valid = false;
    }
}

?>
<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username" value="<?php echo ($form_valid == false)? htmlspecialchars($username):""; ?>">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo ($form_valid == false)? htmlspecialchars($email):""; ?>">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"><?php echo ($form_valid == false)? htmlspecialchars($message):""; ?></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms" <?php if (!$form_valid && isset($_POST['terms'])) echo 'checked'; ?>>
        <label for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<hr>

<?php
if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo htmlspecialchars($username); ?></p>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($message); ?></p>
        </div>
    </div>
<?php
endif;
?>