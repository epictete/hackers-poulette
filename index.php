<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Contact form for support team">
    <title>Hackers Poulette</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>

    <?php

    $firstnameErr = $lastnameErr = $genderErr = $emailErr = $countryErr = $messageErr = "";
    $firstname = $lastname = $gender = $email = $country = $subject = $message = "";
    $firstnameOk = $lastnameOk = $genderOk = $emailOk = $countryOk = $messageOk = false;
    $info = $email_sent = $email_not_sent = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST["website"])) {
        if (empty($_POST["firstname"])) {
            $firstnameErr = "First Name is required";
        } else {
            $firstname = test_input($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z\- ]*$/",$firstname)) {
                $firstnameErr = "Only letters, hyphens and white space allowed";
            } else {
              $firstnameOk = true; 
            }
        }
        if (empty($_POST["lastname"])) {
            $lastnameErr = "Last Name is required";
        } else {
            $lastname = test_input($_POST["lastname"]);
            if (!preg_match("/^[a-zA-Z\- ]*$/",$lastname)) {
                $lastnameErr = "Only letters, hyphens and white space allowed";
            } else {
              $lastnameOk = true; 
            }
        }
        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
            $genderOk = true; 
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            } else {
              $emailOk = true; 
            }
        }
        if (empty($_POST["country"])) {
            $countryErr = "Country is required";
        } else {
            $country = test_input($_POST["country"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$country)) {
                $countryErr = "Only letters and white space allowed";
            } else {
              $countryOk = true; 
            }
        }
        $subject = test_input($_POST["subject"]);
        if (empty($_POST["message"])) {
            $messageErr = "Message is required";
        } else {
            $message = test_input($_POST["message"]);
            if (!filter_var($message, FILTER_SANITIZE_STRING)) {
                $messageErr = "Only letters, white space and numbers allowed";
            } else {
              $messageOk = true; 
            }
        }
        if (
          $firstnameOk &&
          $lastnameOk &&
          $genderOk &&
          $emailOk &&
          $countryOk &&
          $messageOk
          ) {
          require 'mailer.php';
        } else {
          $info = '
          <div class="alert alert-warning" role="alert">
            Some fields are missing or incorrect.
          </div>
          ';
        }
      }
    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    ?>

    <img src="/hackers-poulette-logo.png" alt="" />

    <div class="container w-50">
      <?php echo $info;?>
      <?php echo $email_sent;?>
      <?php echo $email_not_sent;?>
    </div>

    <div class="container w-50">
      <div class="jumbotron shadow">
          <h1 class="display-4 text-center">Support Team</h1>
          <hr class="my-4">
          <h3 class="text-center">Contact Form</h3>
          <p class="error text-right">* required field</p>
          <form
          id="form"
          method="post"
          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
          role="form"
          aria-label="contact support team"
          >
          <!-- Name -->
          <div class="form-group">
            <label for="firstname">First Name:</label>
            <input
              type="text"
              class="form-control"
              id="firstname"
              name="firstname"
              value="<?php echo $firstname;?>"
              aria-required="true"
            />
            <span class="error" role="alert" aria-relevant="all">* <?php echo $firstnameErr;?></span>
          </div>
          <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input
              type="text"
              class="form-control"
              id="lastname"
              name="lastname"
              value="<?php echo $lastname;?>"
              aria-required="true"
            />
            <span class="error" role="alert" aria-relevant="all">* <?php echo $lastnameErr;?></span>
          </div>

          <!-- Gender -->
          <div role="radiogroup" aria-required="true">
            <div class="form-check form-check-inline">
              <input
                type="radio"
                class="form-check-input"
                id="male"
                name="gender"
                value="male"
                <?php if (isset($gender) && $gender == "male") echo "checked";?>
                role="radio"
              />
              <label class="form-check-label" for="male">
                Male
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input
                type="radio"
                class="form-check-input"
                id="female"
                name="gender"
                value="female"
                <?php if (isset($gender) && $gender == "female") echo "checked";?>
                role="radio"
              />
              <label class="form-check-label" for="female">
                Female
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input
                type="radio"
                class="form-check-input"
                id="other"
                name="gender"
                value="other"
                <?php if (isset($gender) && $gender == "other") echo "checked";?>
                role="radio"
              />
              <label class="form-check-label" for="other">
                Other
              </label>
            </div>
          </div>
          <p class="error" role="alert" aria-relevant="all">* <?php echo $genderErr;?></p>

          <!-- Email -->
          <div class="form-group">
            <label for="email">Email address:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">@</div>
              </div>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="<?php echo $email;?>"
                placeholder="name@example.com"
                aria-describedby="emailHelp"
                aria-required="true"
              />
            </div>
            <span class="error" role="alert" aria-relevant="all">* <?php echo $emailErr;?></span>
            <small id="emailHelp" class="form-text text-muted"
              >We'll never share your email with anyone else.</small
            >
          </div>

          <!-- Country -->
          <div class="form-group">
            <label for="country">Country:</label><br />
            <input
              type="text"
              class="form-control"
              id="country"
              name="country"
              value="<?php echo $country;?>"
              aria-required="true"
            />
            <span class="error" role="alert" aria-relevant="all">* <?php echo $countryErr;?></span>
          </div>

          <!-- Subject -->
          <div class="form-group">
            <label for="subject">Subject:</label>
            <select class="form-control" name="subject" id="subject">
              <option value="other" <?php if (isset($subject) && $subject=="other") echo "selected";?>>Other</option>
              <option value="installation" <?php if (isset($subject) && $subject=="installation") echo "selected";?>>Installation</option>
              <option value="configuration" <?php if (isset($subject) && $subject=="configuration") echo "selected";?>>Configuration</option>
              <option value="bug-report" <?php if (isset($subject) && $subject=="bug-report") echo "selected";?>>Bug report</option>
            </select>
          </div>

          <!-- Message -->
          <div class="form-group">
            <label for="message">Your message:</label>
            <textarea
              class="form-control"
              name="message"
              id="message"
              rows="3"
              aria-required="true"
            ><?php echo $message;?></textarea>
            <span class="error" role="alert" aria-relevant="all">* <?php echo $messageErr;?></span>
          </div>

          <!-- Honeypot -->
          <div class="form-group d-none">
            <input type="text" id="website" name="website" value=""  />
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-primary" role="button">Submit</button>
          <button type="reset" class="btn btn-secondary" role="button">Reset</button>
        </form>
      </div>
    </div>

    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
