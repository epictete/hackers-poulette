<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    $nameErr = $lastnameErr = $genderErr = $emailErr = $countryErr = $subjectErr = $messageErr = "";
    $firstname = $lastname = $gender = $email = $country = $subject = $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST["website"])) {
        if (empty($_POST["firstname"])) {
            $firstnameErr = "First Name is required";
        } else {
            $firstname = test_input($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
                $firstnameErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST["lastname"])) {
            $lastnameErr = "Last Name is required";
        } else {
            $lastname = test_input($_POST["lastname"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
                $lastnameErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["country"])) {
            $countryErr = "Country is required";
        } else {
            $country = test_input($_POST["country"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$country)) {
                $countryErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST["subject"]) || $_POST["subject"] == 'other') {
            $subjectErr = "Subject is required";
        } else {
            $subject = test_input($_POST["subject"]);
        }
        if (empty($_POST["message"])) {
            $messageErr = "Message is required";
        } else {
            $message = test_input($_POST["message"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$message)) {
                $messageErr = "Only letters and white space allowed";
            }
        }

      } else {
        // return false;
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
    <div class="container">
        <p class="text-right"><span class="error">* required field</span></p>
        <form
        id="form"
        method="post"
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
        >
        <!-- Name -->
        <div class="form-group">
          <label for="firstname">First Name:</label>
          <input
            type="text"
            class="form-control"
            id="firstname"
            name="firstname"
          />
          <span class="error">* <?php echo $firstnameErr;?></span>
        </div>
        <div class="form-group">
          <label for="lastname">Last Name:</label>
          <input
            type="text"
            class="form-control"
            id="lastname"
            name="lastname"
          />
          <span class="error">* <?php echo $lastnameErr;?></span>
        </div>

        <!-- Gender -->
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            id="male"
            value="male"
          />
          <label class="form-check-label" for="male">
            Male
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            id="female"
            value="female"
          />
          <label class="form-check-label" for="female">
            Female
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            id="other"
            value="other"
          />
          <label class="form-check-label" for="other">
            Other
          </label>
        </div>
        <p><span class="error">* <?php echo $genderErr;?></span></p>
        <p></p>

        <!-- Email -->
        <div class="form-group">
          <label for="email">Email address</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@</div>
            </div>
            <input
              type="email"
              class="form-control"
              name="email"
              id="email"
              aria-describedby="emailHelp"
              placeholder="name@example.com"
            />
          </div>
          <span class="error">* <?php echo $emailErr;?></span>
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
          />
          <span class="error">* <?php echo $countryErr;?></span>
          <br />
        </div>

        <!-- Subject -->
        <div class="form-group">
          <label for="subject">Subject</label>
          <select class="form-control" name="subject" id="subject">
            <option value="subject1">Subject1</option>
            <option value="subject2">Subject2</option>
            <option value="subject3">Subject3</option>
            <option value="other" selected>Other</option>
          </select>
          <span class="error">* <?php echo $subjectErr;?></span>
        </div>

        <!-- Message -->
        <div class="form-group">
          <label for="message">Message</label>
          <textarea
            class="form-control"
            name="message"
            id="message"
            rows="3"
          ></textarea>
          <span class="error">* <?php echo $messageErr;?></span>
        </div>

        <!-- Honeypot -->
        <div class="form-group d-none">
          <input type="text" id="website" name="website" value=""  />
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-primary">Reset</button>
      </form>
    </div>

    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
