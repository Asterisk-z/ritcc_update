<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <title>Email Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #E5EBEC;
            font-family: 'Inter', sans-serif;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            /* margin: auto; */
            /* height: 100vh; */
        }

        a {
            color: #23346A;
        }

        .container {
            background-color: #FFFFFF;
            padding: 20px;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .logo img {
            width: 150px;
        }

        .body-text {
            display: flex;
            flex-direction: column;
            gap: 25px
        }

        main {
            border-top: 1px solid #E0E0E0;
            border-bottom: 1px solid #E0E0E0;
        }

        main h1 {
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            margin-top: 10px;
            color: #23346A;
        }

        main p {
            font-family: Inter;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            letter-spacing: 0em;
            text-align: left;
            color: #272727;
            font-size: 400;
        }

        .code {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .box {
            border: 1px solid #CC9933;
            border-radius: 5px;
            height: 55px;
            width: 210px;
            margin: 20px 0;
        }

        footer {
            padding: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            color: #667085;
        }

        .social-media {
            display: flex;
            gap: 15px;
            font-size: 25px;
            color: #667085;
        }

        footer h2 {
            font-family: Inter;
            font-size: 16px;
            font-weight: 600;
            line-height: 24px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="https://goldhive.fmdqgroup.com/includes/scripts/build/themes/FMDQ/login-logo.png"
                    alt="Company Logo">
            </div>
        </header>
        <main>
            <div class="body-text">
                <h1 style="text-align: center;">Road Infrastructure Tax Credit Certificate
                    Auctioning System</h1>
                <p>Dear <span>{{ $updated['name'] }}</span>,</p>
                {{-- Profie --}}
                @if ($updated['type'] == 'change_password')
                <p>Your password has been changed.</p>
                {{-- <p>These are your login credentials:
                    <br><br>
                    Email address: <strong>{{ $approved['email'] }}</strong>
                    <br>
                    Password: <strong>{{ $approved['password'] }}</strong>
                </p> --}}
                @endif
                <p>
                <p>Kindly click on this <a href="{{ route('login') }}"><strong>link</strong></a> to proceed.</p>
                </p>
            </div>
        </main>
        <footer>
            <div class="social-media">
                <a href="https://www.facebook.com/FMDQGroup?mibextid=ZbWKwL" target="_blank"><i
                        class="fa-brands fa-facebook"></i></a>
                <a href="https://twitter.com/FMDQGroup?t=Qb29hBbSMHCu0ChZiLTI5g&s=09" target="_blank"><i
                        class="fa-brands fa-twitter"></i></a>
                <a href="https://instagram.com/fmdqgroup?igshid=MzRlODBiNWFlZA==" target="_blank"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/fmdq-group/" target="_blank"><i
                        class="fa-brands fa-linkedin"></i></a>
                <a href="https://youtube.com/@fmdqgroup9322" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <h2>FMDQ GROUP PLC</h2>
            <address>Exchange Place, 35 Idowu Taylor Street, Victoria Island, Lagos, Nigeria</address>
            <a href="tel:+3412778771">+234-1-2778771</a>
            <a href="mailto:info@fmdqgroup.com">info@fmdqgroup.com</a>
        </footer>
    </div>
</body>

</html>