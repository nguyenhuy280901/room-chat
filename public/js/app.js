$(function() {
	try {
		$(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
	} catch (error) {
		
	}
	$("#sign-in-btn").click(event => {
		$("#main-content").removeClass("sign-up-mode");
	});
	$("#sign-up-btn").click(event => {
		$("#main-content").addClass("sign-up-mode");
	});
	$(".sign-up-form").submit(event => {
		var newpass = $(".sign-up-form input[name=password]").val();
		var confirmpass = $(".sign-up-form input[name=password_confirmation]").val();
		if(newpass !== confirmpass) {
			$(".error-field .error-message").text("Xác nhận mật khẩu không trùng khớp với mật khẩu");
			return false;
		}
		return true;
	});
	$("#btn-create-room").click(event => {
		$.ajax({
			url: `${ $("input[name=url]").val() }/create-roomid`
		}).done(data => {
			$(".form-create-room input[name=room_id]").val(data);
		});
	});
	$("#action_menu_btn").click(event => {
		$(".action_menu").toggle();
	});
	$(".sign-up-form input[name=avatar]").change(function(event){
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$(".personal-figure>img").fadeIn("fast").attr('src',tmppath);
	});
	$(".save-room").click(event => {
		$.ajax({
			url: `${ $("input[name=url]").val() }/save-room`,
			data: {
				"user_id": $("input[name=user_id]").val(),
				"room_id": $("input[name=room_id]").val()
			},
			success: data => {
				console.log(data);
			}
		})
	});
	$(".send_btn").click(event => {
		var content = $("textarea[name=message]").val();
		if(dt.files.length > 0){
			sendImages();
		}
		if(content === "") return;
		sendMessage(content);
		$("textarea[name=message]").val("");
	});
	const dt = new DataTransfer();
	$("#upload_image").change(function(event) {
		let listFile = event.target.files;
		$(".list-images").empty();
		for(let i = 0; i < listFile.length; i++){
			let tmppath = URL.createObjectURL(listFile[i]);
			listFile[i].key = i;
			let imageItem = `<div class="col-2 col-md-1 image-item">
								<i data="${listFile[i].key}" class="delete-image far fa-times-circle"></i>
								<img src="${tmppath}" class="w-100 h-100">
							</div>`;
			$(".list-images").append(imageItem);
			dt.items.add(listFile[i]);
		}
		$(".list-images").addClass("d-flex");
		$(".list-images").removeClass("d-none");

		this.files = dt.files;
		$(".delete-image").click(function(event) {
			let key = Number($(this).attr("data"));
			$(this).parent().remove();
			for(let i = 0; i < dt.files.length; i++){
				if(dt.files[i].key === key){
					dt.items.remove(i);
					break;
				}
			}
			$("#upload_image").get(0).files = dt.files;
			if(dt.files.length === 0){
				$(".list-images").removeClass("d-flex");
				$(".list-images").addClass("d-none");
			}
		});
	});
	$("textarea[name=message]").emojioneArea({
		autocomplete: false,
		events: { keyup: function (editor, event) {
			var key = event.which || event.keyCode;
			var content = this.getText().replace('\n', '');
			if(key === 13 && content !== ""){
				if($("#upload_image").get(0).files.length > 0){
					sendImages();
				}
				sendMessage(content);
				this.setText("");
			}
		}}
	});
	var room_id = $("input[name=room_id]").val();
	firebase.database().ref(room_id).on("child_added", function(snap) {
        displayMessage(snap.val());
    });
	// Lazy loading
	// $(".msg_card_body").scroll(function(event){
	// 	if(!$(this).scrollTop()){
	// 		console.log("123");
	// 	}
	// });
});

function sendMessage(content, type = "text"){
	let sender_id = $("input[name=user_id]").val();
	let sender_avatar = $("input[name=user_avatar]").val();
	let login_by = $("input[name=user_login_by]").val();
	let room_id = $("input[name=room_id]").val();

	firebase.database().ref(room_id).push().set({
        "sender_id": sender_id,
        "sender_avatar": sender_avatar,
		"login_by": login_by,
		"content": content,
		"time": new Date().getTime(),
		"type": type
    });
}

function sendImages(){
	let data = new FormData($(".form_upload_images")[0]);
	$.ajax({
		type: $(".form_upload_images").attr("method"),
		enctype: $(".form_upload_images").attr("enctype"),
		url: $(".form_upload_images").attr("action"),
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: data => {
			let listFile = JSON.parse(data);
			for(let i = 0; i < listFile.length; i++){
				sendMessage(listFile[i], "image");
			}
			$("#upload_image").val("");
			$(".list-images").removeClass("d-flex");
			$(".list-images").addClass("d-none");
		},
		error: e => {
			console.log(e);
		}
	});
}

function displayMessage(snap){
	let my_id = $("input[name=user_id]").val();
	let room_id = $("input[name=room_id]").val();
	let message = "";
	if(my_id == snap.sender_id){
		message = 	`<div class="d-flex justify-content-end mb-4">
						${snap.type == "text" ? `
						<div class="msg_cotainer_send">
							${snap.content}
							<span class="msg_time_send">${getTime(snap.time)}</span>
						</div>` : ""}
						${snap.type == "image" ? 
							`<div class="img_cotainer_send">
								<a target="_blank" href="../images/room_avt/room_${room_id + "/" + snap.content}">
									<img src="../images/room_avt/room_${room_id + "/" + snap.content}" class="w-100" />
								</a>
								<span class="msg_time_send">${getTime(snap.time)}</span>
							</div>` : ""}
						<div class="img_cont_msg">
							<img src="${snap.login_by == "form" ? "../images/user_avt/" + snap.sender_avatar : snap.sender_avatar}" class="rounded-circle user_img_msg">
						</div>
					</div>`;
	}else{
		message = 	`<div class="d-flex justify-content-start mb-4">
						<div class="img_cont_msg">
							<img src="${snap.login_by == "form" ? "../images/user_avt/" + snap.sender_avatar : snap.sender_avatar}" class="rounded-circle user_img_msg">
						</div>
						${snap.type == "text" ? `
						<div class="msg_cotainer">
							${snap.content}
							<span class="msg_time">${getTime(snap.time)}</span>
						</div>` : ""}
						${snap.type == "image" ? 
							`<div class="img_cotainer">
								<a target="_blank" href="../images/room_avt/room_${room_id + "/" + snap.content}">
									<img src="../images/room_avt/room_${room_id + "/" + snap.content}" class="w-100" />
								</a>
								<span class="msg_time">${getTime(snap.time)}</span>
							</div>` : ""}
					</div>`;
	}
    
    $(".msg_card_body").append(message);
	$(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
}

function getTime(timestamp){
	let time = new Date(timestamp);
	let date = time.getDate();
	let month = time.getMonth();
	let year = time.getFullYear();
	let hour = time.getHours();
	let minute = time.getMinutes();

	return `${formatTime(date)}/${formatTime(month + 1)}/${year} ${formatTime(hour)}:${formatTime(minute)}`;
}

function formatTime(num){
	return num > 9 ? num : '0' + num;;
}