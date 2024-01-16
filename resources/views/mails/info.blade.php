<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RITCC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #000;
        }

        /* Wrapper for the email content */
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            text-align: center;
            padding: 20px 0;
        }

        /* Logo styles */
        .logo {
            max-width: 100px;
        }

        /* Main content styles */
        .content {
            background-color: #fff;
            /* White background for content */
            padding: 20px;
        }

        /* Call to action button styles */
        .cta-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #23336c;
            /* Blue button background */
            color: #fff;
            /* White text color */
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <img src="https://goldhive.fmdqgroup.com/includes/scripts/build/themes/FMDQ/login-logo.png"
                alt="Company Logo">
        </div>
        <div class="content">
            <h4 style="text-align: center;">Road Infrastructure Tax Credit Certificate
                Auctioning System</h4>
            <p>Dear {{$user->firstName}},</p>
            <p>{!! $info !!}</p>
            <p>Kindly click on this <a href="{{ route('login') }}"><strong>link</strong></a> to proceed.</p>
            <p>Thank You.</p>
            <p style="margin-top: -15px;">FMDQ Securities Exchange</p>
        </div>
        <div class="footer">
            <p>
                <a href="https://www.facebook.com/FMDQGroup?mibextid=ZbWKwL" target="_blank"><i
                        class="fa-brands fa-facebook"></i></a>
                <a href="https://twitter.com/FMDQGroup?t=Qb29hBbSMHCu0ChZiLTI5g&s=09" target="_blank"><i
                        class="fa-brands fa-twitter"></i></a>
                <a href="https://instagram.com/fmdqgroup?igshid=MzRlODBiNWFlZA==" target="_blank"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/fmdq-group/" target="_blank"><i
                        class="fa-brands fa-linkedin"></i></a>
                <a href="https://youtube.com/@fmdqgroup9322" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </p>

            <p>&copy; {{date('Y')}} FMDQ Group. All rights reserved.</p>
            <address>Exchange Place, 35 Idowu Taylor Street, Victoria Island, Lagos, Nigeria</address>
            <a href="tel:+3412778771">+234-1-2778771</a>
            <a href="mailto:info@fmdqgroup.com">info@fmdqgroup.com</a>
        </div>
    </div>
</body>

</html>