<?php

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="./resources/css/general.css">
    <link rel="stylesheet" href="./resources/css/login.css">
</head>

<body>
    <div class="box">
        <div class="form">
            <form id="form">
                <h2>Sign in </h2>
                <div class="inputbox">
                    <input type="text" required="required" id="username">
                    <span>Username </span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="password" required="required" id="password">
                    <span>Password</span>
                    <i></i>
                </div>
                <div class="links">
                    <a href="#"> Forgot Password</a>
                </div>
                <button type="submit" id="login">Login</button>
                <div class="login-error">

                </div>
            </form>
        </div>
    </div>
    <script>
        const form = document.querySelector('#form');
        const username = document.querySelector('#username');
        const password = document.querySelector('#password');
        const loginError = document.querySelector(".login-error");

        form.addEventListener('submit', async (event) => {

            //prevent the form from submitting
            event.preventDefault();

            try {

                //fech request for logging in
                let result = await fetch("./auth", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        username: username.value,
                        password: password.value
                    })
                });

                const isValid = result.ok;

                result = await result.json();

                //throw an error in receive status code is not 200
                if (!isValid) {
                    throw new Error(result.message);
                }

                console.log(result.message);

            } catch (error) {
                console.log(error.message);
                loginError.innerHTML = error.message;
            }

        })
    </script>
</body>

</html>