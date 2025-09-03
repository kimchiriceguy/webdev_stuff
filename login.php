<?php
session_start();
//create variables to be used:

$harvard_password = "webdev2";
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($inputPassword, $hashedPassword)) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_username'] = $username;
            $_SESSION['user_id'] = $id; //added to store ID as it is needed in calendar booking
            header("Location: index.php");
            exit();
        }
    }
    $stmt->close();    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($inputPassword, $hashedPassword)) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_username'] = $username;
            $_SESSION['user_id'] = $id; //added to store ID as it is needed in calendar booking
            header("Location: index.php");
            exit();
        }
    }
    $stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log In - Harvard University</title>
  <style media="screen">
    body {
      background-color: #69000c;
      height: 100vh;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .tab_table_container {
      display: flex;
      z-index: 1;
      flex-direction: column;
      position: relative;
      width: 600px;
      height: 230px;
      border: 2px solid black;
      border-top: 3px solid white;
      border-left: 3px solid white;
      background-color: #c0c0c0;
      margin: 0 auto;
    }

    .header_table {
      width: 99%;
      height: 30px;
      background-color: #000080;
      border: none;
      bottom: 2px;
      margin-top: 4px;
      justify-content: center;
      margin-left: 3px;
    }

    .header_text {
      width: 550px;
      height: 20px;
      margin-top: 4px;
      margin-left: 5px;
      font-family: "w95fa", arial, serif;
      font-size: 20px;
      color: white;
    }

    .static_text_container {
      display: block;
      flex-direction: column;
      justify-content: center;
      justify-text: left;
      width: 330px;
      margin-left: 115px;
      padding: 10px;
      margin-top: 10px;
    }

    .pixel_art {
      display: block;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 1px;
      height: 1px;
      padding: 10px;
      box-sizing: border-box;
      margin-top: 39px;
      position: absolute;
      margin-left: -5px;
    }

    .pixel_art img {
      width: 130px;
      height: 130px;
      margin-right: 70px;
    }

    .main_input_container {
      display: block;
      flex-direction: column;
      justify-content: left;
      justify-text: left;
      width: 290px;
      margin-left: 129px;
      margin-top: 10px;
    }

    .username_input, .password_input {
      width: 170px;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 0px;
      margin-left: 30px;
      font-size: 16px;
      border-radius: 0px;
      border: 2px solid white;
      border-top: 2px solid black;
      border-left: 2px solid black;
    }

    .username_input:focus, .password_input:focus {
      border: 2px solid black;
      border-top: 2px solid white;
      border-left: 2px solid white;
      outline: none;
    }

    .username_input:active, .password_input:active {
      outline: none;
    }

    .okcancel_button_container {
      display: flex;
      justify-content: center;
      flex-direction: column;
      position: absolute;
      right: 5px;
      top: 28px;
      width: 120px;
      height: 120px;
    }

    .ok_button {
      width: 95px;
      height: 30px;
      cursor: pointer;
      outline: none;
      border: 2px solid black;
      border-top: 2px solid white;
      border-left: 2px solid white;
      background-color: #c0c0c0;
    }

    .ok_button:active {
      border: 2px solid white;
      border-top: 2px solid black;
      border-left: 2px solid black;
    }

    .cancel_button {
      width: 95px;
      height: 30px;
      cursor: pointer;
      outline: none;
      border: 2px solid black;
      border-top: 2px solid white;
      border-left: 2px solid white;
      background-color: #c0c0c0;
      margin-top: 7px;
    }

    .cancel_button:active {
      border: 2px solid white;
      border-top: 2px solid black;
      border-left: 2px solid black;
    }

    .question_mark {
      position: absolute;
      top: 7px;
      left: 566px;
      width: 25px;
      height: 25px;
      cursor: pointer;
      border: 2px solid black;
      border-top: 2px solid white;
      border-left: 2px solid white;
      background-color: #c0c0c0;
      font-size: 16px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .question_mark:active {
      border: 2px solid white;
      border-top: 2px solid black;
      border-left: 2px solid black;
    }

    .popup_table {
      display: none;
      position: fixed;
      top: 200px;
      background-color: #ffffff;
      margin-left: 700px;
      padding: 20px;
      border: 2px solid black;
      z-index: 10;
      width: 300px;
      height: 200px;
      overflow-y: auto;
    }

    .popup_table table {
      width: 100%;
    }

    .popup_table td {
      font-family: w95fa;
      font-size: 15px;
    }

    .popup_table_close {
      cursor: pointer;
      background-color: #f00000;
      color: white;
      border: none;
      padding: 10px;
      font-size: 16px;
      margin-top: 75px;
      margin-left: 230px;
    }

    .wrong_password_popup {
      display: none;
      z-index: 1;
      flex-direction: column;
      position: fixed;
      width: 600px;
      height: 230px;
      border: 2px solid black;
      border-top: 3px solid white;
      border-left: 3px solid white;
      background-color: #c0c0c0;
      margin: 0 auto;
      z-index: 123123;
    }

    .wrong_password_popup .header_table {
      background-color: #ff0000;
    }

    .wrong_password_popup .header_text {
      font-family: w95fa;
      font-size: 20px;
      color: white;
      padding-left: 5px;
      padding-top: 5px;
    }

    .wrong_password_popup .static_text_container {
      padding: 10px;
      font-family: w95fa;
      font-size: 15px;
      width: 500px;
      margin-left: 10px;
    }

    .wrong_password_popup .popup_table_close {
      cursor: pointer;
      background-color: #f00000;
      color: white;
      border: none;
      padding: 10px;
      font-size: 16px;
      margin-top: 75px;
      margin-left: 500px;
      border: 2px solid black;
      border-top: 2px solid white;
      border-left: 2px solid white;
    }

  </style>
</head>
<body>
  <div class="tab_table_container">

    <div class="header_table">
      <div class="header_text">
        Harvard University Login Page
      </div>
    </div>

    <button type="button" class="question_mark" name="question_mark" id="question_mark">
      ?
    </button>

    <div class="pixel_art">
      <img src="assets/media.png" alt="itsakey">
    </div>

    <div class="static_text_container">
      <table>
        <td style="font-family: w95fa; font-size: 15px;">Please input your student ID and password.</td>
      </table>
    </div>

    <div class="main_input_container" style="font-family: w95fa; font-size:14px; padding-left: 30px;">
      Username:
      <input type="text" class="username_input" name="username_input" style="font-family: w95fa; font-size:12px;" id="username">
      Password:
      <input type="password" class="password_input" name="password_input" style="font-family: w95fa; font-size:12px;" id="password">
    </div>

    <div class="okcancel_button_container">
      <button type="button" class="ok_button" id="ok_button" style="font-family: w95fa; font-size:17px;">OK</button>
      <button type="button" class="cancel_button" id="cancel_button" style="font-family: w95fa; font-size:17px;">Cancel</button>
    </div>
  </div>

  <div class="popup_table" id="popup_table">
    <table>
      <tr>
        <td style="font-weight: bold;">Username:</td>
      </tr>
      <tr>
        <td>Give an ID number</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Password:</td>
      </tr>
      <tr>
        <td>webdev2</td>
      </tr>
    </table>
    <button class="popup_table_close" id="popup_table_close">Close</button>
  </div>



  <script>
    const ok_button = document.getElementById('ok_button');
    const cancel_button = document.getElementById('cancel_button');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const question_mark = document.getElementById('question_mark');
    const popup_table = document.getElementById('popup_table');
    const popup_table_close = document.getElementById('popup_table_close');
    const wrong_password_popup = document.getElementById('wrong_password_popup');
    const wrongPasswordPopupClose = document.getElementById('wrong_password_popup_close');

    // ok button logic
    ok_button.addEventListener('click', function main() {
      const username_value = username.value;
      const password_value = password.value;

      
    });

    // cancel button logic
    cancel_button.addEventListener('click', function main() {
      username.value = '';
      password.value = '';
    });

    // question mark logic
    question_mark.addEventListener('click', function main() {
      popup_table.style.display = 'block';
    });

    //close hint logic
    popup_table_close.addEventListener('click', function main() {
      popup_table.style.display = 'none';
    });

    //close the wrong password popup
    wrongPasswordPopupClose.addEventListener('click', function main() {
      wrong_password_popup.style.display = 'none';
    });
  </script>

</body>
</html>


<?php $conn->close(); ?>