<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
        }

        .register-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 18px;
            background: #2563eb;
            color: #ffffff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h1 {
            font-size: 26px;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .register-header p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            height: 50px;
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            padding: 0 15px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
            background: #ffffff;
        }

        .password-input {
            padding-right: 70px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .show-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            display: none;
        }

        .alert {
            display: none;
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .register-btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-btn:hover {
            background: #1d4ed8;
        }

        .register-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .login-text {
            text-align: center;
            margin-top: 22px;
            color: #64748b;
            font-size: 14px;
        }

        .login-text a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .register-card {
                padding: 25px 20px;
            }

            .register-header h1 {
                font-size: 23px;
            }
        }
    </style>

</head>

<body>

<div class="register-container">

    <div class="register-card">

        <div class="logo">
            M
        </div>

        <div class="register-header">
            <h1>Create Account</h1>
            <p>Register your account to continue</p>
        </div>


        <!-- Success Message -->
        <div id="successAlert" class="alert alert-success"></div>


        <!-- Error Message -->
        <div id="errorAlert" class="alert alert-error"></div>


        <form id="registerForm">


            <!-- Mobile Number -->

            <div class="form-group">

                <label for="mobile">
                    Mobile Number
                </label>

                <input
                    type="tel"
                    id="mobile"
                    name="mobile"
                    class="form-control"
                    placeholder="01XXXXXXXXX"
                    maxlength="11"
                    autocomplete="tel"
                    required
                >

                <div
                    id="mobileError"
                    class="error-text">
                </div>

            </div>


            <!-- Password -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="input-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control password-input"
                        placeholder="Enter your password"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="show-password"
                        onclick="togglePassword('password', this)"
                    >
                        Show
                    </button>

                </div>

                <div
                    id="passwordError"
                    class="error-text">
                </div>

            </div>


            <!-- Confirm Password -->

            <div class="form-group">

                <label for="password_confirmation">
                    Confirm Password
                </label>

                <div class="input-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control password-input"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="show-password"
                        onclick="togglePassword('password_confirmation', this)"
                    >
                        Show
                    </button>

                </div>

                <div
                    id="passwordConfirmationError"
                    class="error-text">
                </div>

            </div>


            <!-- Submit Button -->

            <button
                type="submit"
                id="registerButton"
                class="register-btn"
            >
                Create Account
            </button>

        </form>


        <div class="login-text">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </div>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | Laravel Register API URL
    |--------------------------------------------------------------------------
    */

    const API_URL =
        'http://127.0.0.1:8000/api/v1/auth/register';


    const registerForm =
        document.getElementById('registerForm');

    const registerButton =
        document.getElementById('registerButton');

    const successAlert =
        document.getElementById('successAlert');

    const errorAlert =
        document.getElementById('errorAlert');


    /*
    |--------------------------------------------------------------------------
    | Toggle Password
    |--------------------------------------------------------------------------
    */

    function togglePassword(inputId, button)
    {
        const input =
            document.getElementById(inputId);

        if (input.type === 'password') {

            input.type = 'text';
            button.innerText = 'Hide';

        } else {

            input.type = 'password';
            button.innerText = 'Show';

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Clear Errors
    |--------------------------------------------------------------------------
    */

    function clearErrors()
    {
        successAlert.style.display = 'none';
        errorAlert.style.display = 'none';

        successAlert.innerText = '';
        errorAlert.innerText = '';

        document
            .querySelectorAll('.error-text')
            .forEach(function(element) {

                element.innerText = '';
                element.style.display = 'none';

            });
    }


    /*
    |--------------------------------------------------------------------------
    | Show Field Error
    |--------------------------------------------------------------------------
    */

    function showFieldError(field, message)
    {
        let errorElement = null;


        if (field === 'mobile') {

            errorElement =
                document.getElementById(
                    'mobileError'
                );

        }


        if (field === 'password') {

            errorElement =
                document.getElementById(
                    'passwordError'
                );

        }


        if (field === 'password_confirmation') {

            errorElement =
                document.getElementById(
                    'passwordConfirmationError'
                );

        }


        if (errorElement) {

            errorElement.innerText = message;
            errorElement.style.display = 'block';

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Register Form Submit
    |--------------------------------------------------------------------------
    */

    registerForm.addEventListener(
        'submit',
        async function(event)
        {

            event.preventDefault();

            clearErrors();


            /*
            |--------------------------------------------------------------------------
            | Get Form Data
            |--------------------------------------------------------------------------
            */

            const mobile =
                document
                    .getElementById('mobile')
                    .value
                    .trim();


            const password =
                document
                    .getElementById('password')
                    .value;


            const passwordConfirmation =
                document
                    .getElementById(
                        'password_confirmation'
                    )
                    .value;


            /*
            |--------------------------------------------------------------------------
            | Mobile Validation
            |--------------------------------------------------------------------------
            */

            if (!/^01[0-9]{9}$/.test(mobile)) {

                showFieldError(
                    'mobile',
                    'Please enter a valid 11 digit mobile number.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Password Validation
            |--------------------------------------------------------------------------
            */

            if (password.length < 6) {

                showFieldError(
                    'password',
                    'Password must be at least 6 characters.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Confirm Password
            |--------------------------------------------------------------------------
            */

            if (password !== passwordConfirmation) {

                showFieldError(
                    'password_confirmation',
                    'Password confirmation does not match.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Loading Button
            |--------------------------------------------------------------------------
            */

            registerButton.disabled = true;

            registerButton.innerText =
                'Creating Account...';


            try {

                /*
                |--------------------------------------------------------------------------
                | Send Request To Laravel API
                |--------------------------------------------------------------------------
                */

                const response =
                    await fetch(
                        API_URL,
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json'
                            },

                            body: JSON.stringify({

                                mobile:
                                    mobile,

                                password:
                                    password,

                                password_confirmation:
                                    passwordConfirmation

                            })
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Get JSON Response
                |--------------------------------------------------------------------------
                */

                const result =
                    await response.json();


                console.log(
                    'API Response:',
                    result
                );


                /*
                |--------------------------------------------------------------------------
                | Registration Success
                |--------------------------------------------------------------------------
                */

                if (response.ok && result.success) {


                    successAlert.innerText =
                        result.message ||
                        'Registration successful.';


                    successAlert.style.display =
                        'block';


                    /*
                    |--------------------------------------------------------------------------
                    | Save Access Token
                    |--------------------------------------------------------------------------
                    */

                    if (
                        result.data &&
                        result.data.access_token
                    ) {

                        localStorage.setItem(
                            'access_token',
                            result.data.access_token
                        );


                        localStorage.setItem(
                            'token_type',
                            result.data.token_type ||
                            'Bearer'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Save User Information
                    |--------------------------------------------------------------------------
                    */

                    if (
                        result.data &&
                        result.data.user
                    ) {

                        localStorage.setItem(
                            'user',
                            JSON.stringify(
                                result.data.user
                            )
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Clear Registration Form
                    |--------------------------------------------------------------------------
                    */

                    registerForm.reset();


                    /*
                    |--------------------------------------------------------------------------
                    | Redirect
                    |--------------------------------------------------------------------------
                    |
                    | Dashboard তৈরি হলে নিচের code uncomment করবেন।
                    |
                    | setTimeout(function() {
                    |
                    |     window.location.href =
                    |         'dashboard.php';
                    |
                    | }, 1000);
                    |
                    */


                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Laravel Validation Errors
                |--------------------------------------------------------------------------
                */

                if (result.errors) {

                    Object
                        .keys(result.errors)
                        .forEach(function(field) {

                            const messages =
                                result.errors[field];


                            if (
                                Array.isArray(messages) &&
                                messages.length > 0
                            ) {

                                showFieldError(
                                    field,
                                    messages[0]
                                );

                            }

                        });

                }


                /*
                |--------------------------------------------------------------------------
                | General API Error
                |--------------------------------------------------------------------------
                */

                errorAlert.innerText =
                    result.message ||
                    'Registration failed. Please try again.';


                errorAlert.style.display =
                    'block';


            } catch (error) {


                /*
                |--------------------------------------------------------------------------
                | Network / Server Error
                |--------------------------------------------------------------------------
                */

                console.error(
                    'Registration Error:',
                    error
                );


                errorAlert.innerText =
                    'Unable to connect to Laravel API. Please make sure the API server is running.';


                errorAlert.style.display =
                    'block';


            } finally {


                /*
                |--------------------------------------------------------------------------
                | Reset Button
                |--------------------------------------------------------------------------
                */

                registerButton.disabled = false;

                registerButton.innerText =
                    'Create Account';

            }

        }
    );

</script>

</body>

</html>