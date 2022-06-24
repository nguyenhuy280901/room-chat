<!DOCTYPE html>
<html>
<head>
	<title>Chat app</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}images/icons8-chat-48.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('') }}emojionearea-master/dist/emojionearea.min.css">
	<link rel="stylesheet" href="{{ asset('') }}css/chat.css">
</head>
<body>
	<input type="hidden" name="url" value="{{ env('APP_URL') }}">
	<div class="container-fluid h-100">
		<div class="row justify-content-center h-100">
			<div class="col-md-10 col-xl-8 chat">
				<div class="card">
					<div class="card-header msg_head">
						<div class="d-flex bd-highlight">
							<div class="img_cont">
								<img src="{{ asset('') }}images/room_avt/{{ $room->avatar}}" class="rounded-circle user_img" alt="{{ $room->name }}">
							</div>
							<div class="user_info">
								<span>{{ $room->name }}</span>
								<p>Room ID: {{ $room->id }}</p>
							</div>
						</div>
						<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
						<div class="action_menu">
							<ul>
								<li>
									<a href="{{ route('profile') }}" class="text-white text-decoration-none">
										<i class="fas fa-user-circle"></i>View profile
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" class="text-white text-decoration-none save-room">
										<i class="far fa-bookmark"></i>Save Room
									</a>
								</li>
								<li>
									<a href="{{ route('choose-room') }}" class="text-white text-decoration-none">
										<i class="fas fa-sign-out-alt"></i>Exit room
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-body msg_card_body">
						<input type="hidden" name="user_id" value="{{ $user->id }}">
						<input type="hidden" name="user_avatar" value="{{ $user->avatar }}">
						<input type="hidden" name="user_login_by" value="{{ $user->login_by }}">
						<input type="hidden" name="room_id" value="{{ $room->id }}">
					</div>
					<div class="card-footer">
						<div class="row list-images mx-0 p-2 d-none">
							
						</div>
						<div class="input-group">
							<textarea name="message" class="form-control type_msg" placeholder="Type your message..."></textarea>
							<div class="input-group-append">
								<form class="d-none form_upload_images" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="file" name="upload_image[]" id="upload_image" multiple accept="image/*">
									<input type="hidden" name="room_id" value="{{ $room->id }}">
								</form>
								<label for="upload_image" class="mb-0">
									<span class="h-100 input-group-text upload_btn">
										<i class="fas fa-file-image"></i>
									</span>
								</label>
								<span class="input-group-text send_btn">
									<i class="fas fa-location-arrow"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>

    <!-- Add Firebase Database -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-analytics.js"></script>

    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var firebaseConfig = {
            apiKey: "AIzaSyAA7PiBAxYjhFNk2JlK9S9XCm6qvZa-gfo",
            authDomain: "demochat-d7f12.firebaseapp.com",
            projectId: "demochat-d7f12",
            storageBucket: "demochat-d7f12.appspot.com",
            messagingSenderId: "721754162979",
            appId: "1:721754162979:web:8d2fa1b620ee0f412f6e96",
            measurementId: "G-1GGP4R2DPG",
            databaseURL: "https://demochat-d7f12-default-rtdb.asia-southeast1.firebasedatabase.app"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
	<script src="{{ asset('') }}emojionearea-master/dist/emojionearea.min.js"></script>
	<script src="{{ asset('') }}js/app.js"></script>
</body>
</html>
