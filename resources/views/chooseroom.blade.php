<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat app</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}images/icons8-chat-48.png"/>
    {{-- Load Boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    {{-- Load css --}}
    <link rel="stylesheet" href="{{ asset('') }}css/app.css">
</head>
<body>
    <input type="hidden" name="url" value="{{ env('APP_URL') }}">
    <div class="alert alert-primary mb-0 text-center fs-3 fw-bolder" role="alert">
        Hello {{ $user->name }}, Welcome to my ChatApp!!
    </div>
    <div id="wrapper">
        <div class="container bg-white pt-3 pb-5 px-5">
            <div class="row">
                <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3 mb-4 list-room">
                    <h5 class="text-primary mb-3">Your list room</h5>
                    <div class="row">
                        @foreach ($user->rooms as $room)
                            <div class="col-md-2 col-4 room-item text-center">
                                <div class="room-avatar">
                                    <img src="{{ asset('') }}images/room_avt/{{ $room->avatar }}" class="w-100" alt="{{ $room->name }}">
                                    <div class="overlay">
                                        <div class="content">
                                            <a href="{{ route('messenger', ["room" => $room->id]) }}">
                                                Join<br>Room
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('messenger', ["room" => strval($room->id)]) }}" class="room-name text-decoration-none text-danger">
                                    {{ $room->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3 mb-4 list-room">
                    <h5 class="text-primary mb-3">Save room</h5>
                    <div class="row">
                        @foreach ($user->userRooms as $userRoom)
                            @php
                                $room = $userRoom->room;
                            @endphp
                            <div class="col-md-2 col-4 room-item text-center">
                                <div class="room-avatar">
                                    <img src="{{ asset('') }}images/room_avt/{{ $room->avatar }}" class="w-100" alt="{{ $room->name }}">
                                    <div class="overlay">
                                        <div class="content">
                                            <a href="{{ route('messenger', ["room" => $room->id]) }}">
                                                Join<br>Room
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('messenger', ["room" => strval($room->id)]) }}" class="room-name text-decoration-none text-danger">
                                    {{ $room->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 offset-md-3 offset-lg-4 text-center">
                    <form action="{{ route('chat') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Room ID" name="room_id" required>
                            <button class="btn btn-secondary" type="submit">Start Chat</button>
                        </div>
                    </form>
                    <span class="text-danger d-inline-block mb-3 fs-3 fw-bolder">OR</span>
                    <div class="row">
                        <div class="col-6">
                            <button id="btn-create-room" class="btn btn-outline-info w-100" data-bs-toggle="modal" data-bs-target="#create-room-modal">Create A Room</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="create-room-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-create-room" action="{{ route('create-room') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingRoomID" name="room_id" placeholder="Room ID" readonly>
                            <label for="floatingRoomID">Room ID</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" required class="form-control" id="floatingRoomName" name="room_name" placeholder="Room Name">
                            <label for="floatingRoomName">Room Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="room-avatar">Room Avatar</label>
                            <input type="file" class="form-control" id="room-avatar" name="room_avatar" required>
                        </div>
                        <input id="submit-create-room" type="submit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <label for="submit-create-room" class="btn btn-primary">Create</label>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('') }}js/app.js"></script>
</body>
</html>