<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- Load FontAwesome -->
    <link
        rel="stylesheet"
        href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('') }}css/style.css"/>
    <title>Chat app</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}images/icons8-chat-48.png"/>
</head>
<body>
    <div class="container login-page @if(Session::has('error-register')) sign-up-mode @endif" id="main-content">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" required autocomplete="username"/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" autocomplete="current-password" required/>
                    </div>
                    <label><input type="checkbox" name="remember_me"/> Remember Me</label>
                    <div class="error-field">
                        <span class="error-message">
                            @if(Session::has('error-login'))
                                {!! Session::get('error-login') !!}
                            @endif
                        </span>
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="{{ route('login-social', ['social' => 'facebook']) }}" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ route('login-social', ['social' => 'google']) }}" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>
                <form action="{{ route('register') }}" class="sign-up-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="title">Sign up</h2>
                    <div>
                        <div class="personal-image">
                            <label class="label">
                                <input id="avatar" type="file" name="avatar" required/>
                                <figure class="personal-figure">
                                    <img src="{{ asset('') }}images/person-paper-icon.png" class="personal-avatar" alt="avatar">
                                    <figcaption class="personal-figcaption">
                                        <img src="{{ asset('') }}images/camera-white.png">
                                    </figcaption>
                                </figure>
                            </label>
                        </div>
                        <label for="avatar">Choose Avatar</label>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-id-card"></i>
                        <input type="text" placeholder="Name" name="name" required/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" required autocomplete="username"/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required autocomplete="new-password"/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-check-square"></i>
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="current-password" required/>
                    </div>
                    <div class="error-field">
                        <span class="error-message">
                            @if(Session::has('error-register'))
                                {!! Session::get('error-register') !!}
                            @endif
                        </span>
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="{{ route('login-social', ['social' => 'facebook']) }}" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ route('login-social', ['social' => 'google']) }}" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis, ex ratione. Aliquid!</p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="{{ asset('') }}images/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                    laboriosam ad deleniti.</p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="{{ asset('') }}images/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('') }}js/app.js"></script>
</body>
</html>
