<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry MaVins</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #auth {
            width: 100%;
            max-width: 900px;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-wrap: wrap;
        }

        #auth-left {
            flex: 1;
            padding: 60px 40px;
        }

        #auth-left h1 {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        #auth-left p {
            color: #666;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 10px;
            padding-left: 45px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(37, 117, 252, 0.4);
            border-color: #2575fc;
        }

        .form-control-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6a11cb;
            font-size: 1.2rem;
        }

        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background: #2575fc;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #6a11cb;
        }

        #auth-right {
            flex: 1;
            background: url('{{ asset('assets/assets/images/image.png') }}') center no-repeat;
            background-size: cover;
        }

        .alert {
            border-radius: 10px;
        }

        .text-center a {
            color: #2575fc;
            text-decoration: none;
            font-weight: 600;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        @media(max-width: 992px) {
            #auth {
                flex-direction: column;
            }

            #auth-right {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div id="auth">
        <div id="auth-left">
            <h1>Laundry MaVins.</h1>
            <p class="mb-4">Silahkan Login Sesuai Tugas Anda.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="post">
                @csrf
                <div class="form-group position-relative mb-4">
                    <input name="email" type="email" class="form-control form-control-lg" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <div class="form-group position-relative mb-4">
                    <input name="password" type="password" class="form-control form-control-lg" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <div class="form-check form-check-lg d-flex align-items-center mb-4">
                    <input class="form-check-input me-2" type="checkbox" value="" id="rememberMe">
                    <label class="form-check-label text-gray-600" for="rememberMe">
                        Keep me logged in
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">Log in</button>
            </form>

            <div class="text-center mt-5 fs-6">
                <p>Don't have an account? <a href="#">Sign up</a></p>
                <p><a href="#">Forgot password?</a></p>
            </div>
        </div>

        <div id="auth-right"></div>
    </div>
</body>

</html>
