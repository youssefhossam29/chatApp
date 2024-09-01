<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/vertical-layout-light/style.css">
</head>
<style>
    .chat-list {
        max-height: 500px;
        overflow-y: auto;
    }

    .chat-item {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
    }

    .chat-item:hover {
        background-color: #f5f5f5;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .chat-message {
        display: flex;
        margin-bottom: 10px;
    }

    .message-avatar {
        margin-right: 10px;
    }

    .message-content {
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 10px;
    }

    .sender .message-content {
        background-color: #dcf8c6;
    }

    .card-footer {
        padding: 10px;
    }

    .chat-window {
        max-height: 500px;
        overflow-y: auto;
    }

    .chat-message-container {
        min-height: 400px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #ffffff;
        ;
        margin-bottom: 10px;
    }

    .chat-message.sender {
        margin-bottom: 10px;
        text-align: left;
    }

    .chat-message.receiver {
        margin-bottom: 10px;
        text-align: right;
    }

    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #4B49AC;
        border-color: #4B49AC;
    }

    .chat-message {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }

    .chat-message .message-avatar img {
        width: 40px;
        height: 40px;
    }

    .chat-message .message-content {
        display: inline-block;
        padding: 10px;
        border-radius: 5px;
        background-color: #f1f1f1;
        margin: 0 10px;
        max-width: 70%;
    }

    .chat-message.sender .message-content {
        background-color: #d1e7dd;
        text-align: right;
        margin-left: auto;
    }

    .chat-message.sender {
        flex-direction: row-reverse;
    }

    .chat-message .timestamp {
        font-size: 0.8em;
        color: #888;
    }

    .chat-message.sender .timestamp {
        margin-right: 10px;
    }

    .picture {
        width: 60px;
        height: 60px;
        margin-right: 15px;
        border: 2px solid #007bff;
    }

    .profile_name {
        font-size: 1.1em;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 5px;
    }

    .badge-primary {
        background-color: #1E2738;
        color: #fff;
    }
</style>


<x-app-layout>
    <div class="container-scroller">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <br>
                        <div class="col-md-12 mt-4 grid-margin">
                            <div class="row">
                                <!-- Left column: Chat list -->
                                <div class="col-md-4 col-lg-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header badge-primary">
                                            <h4 class="mb-0">Chats</h4>
                                        </div>
                                        <div class="list-group chat-list" id="chatList"
                                            style="max-height: 500px; overflow-y: auto;">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($users as $user)
                                                    <li class="list-group-item d-flex align-items-center chat-item">
                                                        <img src="{{ asset('uploads/users/' . $user->picture) }}"
                                                            class="picture rounded-circle mr-3"
                                                            style="width: 40px; height: 40px;" alt="">
                                                        <div class="profile_info">
                                                            <span
                                                                class="profile_name font-weight-bold">{{ $user->name }}</span>
                                                            <span class="id"
                                                                style="display: none;">{{ $user->id }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right column: Chat area -->
                                <div class="col-md-8 col-lg-9">
                                    <div class="card shadow-sm">
                                        <div class="card-header badge-primary">
                                            <div class="d-flex align-items-center">
                                                <img id="chat_img" src="" class="rounded-circle mr-3"
                                                    alt="" style="width: 40px; height: 40px;">
                                                <h4 class="mb-0" id="chat_name">Chatting with</h4>
                                            </div>
                                        </div>

                                        <div class="card-body chat-window" style="height: 400px; overflow-y: auto;">
                                            <div class="chat-message-container" id="chatMessageContainer">
                                                <!-- Chat messages will be dynamically loaded here -->
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <form id="messageForm" method="POST">
                                                @csrf
                                                <input type="hidden" name="receiver_id" id="receiver_id">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Type your message here..." id="messageInput"
                                                        name="message">
                                                    <button class="btn badge-primary" style="margin-left:5px"
                                                        type="submit" id="sendMessageButton">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // Initialize Pusher
        var pusher = new Pusher('22e35c7e2f0617ae7c56', {
            cluster: 'ap2',
            encrypted: true
        });

        // Subscribe to the 'user-messages' channel
        var channel = pusher.subscribe('user-messages');

        // Bind to the 'user-message' event
        // Inside the Pusher event handler
        channel.bind('user-message', function(data) {

            let currentUserId = '{{ Auth::id() }}';
            let activeChatUserId = $('#receiver_id').val();
            if (data.sender_id !== parseInt(currentUserId)) {
                if (data.receiver_id == currentUserId && data.sender_id == activeChatUserId) {

                    let senderId = data.sender_id;
                    let message = data.message;
                    let senderName = data.user.name;
                    let senderPicture = data.user.picture;
                    let messageTime = new Date(data.created_at).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Create message HTML with proper asset URL
                    let messageHtml = `
                            <div class="chat-message receiver"> <!-- Left alignment for received messages -->
                                <div class="message-avatar">
                                    <img src="${senderPicture}" class="rounded-circle avatar" alt="">

                                </div>
                                <div class="message-content">
                                    <p><strong>${senderName}:</strong> ${message}</p>
                                    <div class="timestamp">${messageTime}</div>
                                </div>
                            </div>`;

                    // Append message to chat container
                    document.getElementById('chatMessageContainer').insertAdjacentHTML('beforeend', messageHtml);
                }
            }
        });
    </script>
    <!-- JavaScript to handle profile card click -->
    <script>
        $(document).ready(function() {
            // Bind click event to the chat-item list elements
            $('.chat-item').on('click', function() {
                let Picture = $(this).find('.picture').attr('src');
                let profileName = $(this).find('.profile_name').text();
                let receiverId = $(this).find('.id').text();
                $('#receiver_id').val(receiverId);
                $('#chat_img').attr('src', Picture);
                $('#chat_name').text('Chatting with ' + profileName);

                // Fetch messages
                $.ajax({
                    url: '{{ route('messages.fetch') }}',
                    method: 'GET',
                    data: {
                        receiver_id: receiverId
                    },
                    success: function(response) {
                        $('#chatMessageContainer').empty();

                        response.messages.forEach(function(message) {
                            let isSender = message.sender_id == '{{ Auth::id() }}';
                            let userAvatar = isSender ?
                                '{{ asset('uploads/users/' . $LoggedUserInfo->picture) }}' :
                                Picture;
                            let userName = isSender ? '{{ $LoggedUserInfo->name }}' :
                                profileName;

                            let messageTime = new Date(message.created_at)
                                .toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                            let messageHtml = `
                                    <div class="chat-message ${isSender ? 'sender' : 'receiver'}">
                                        <div class="message-avatar">
                                            <img src="${userAvatar}" class="rounded-circle avatar" alt="">
                                        </div>
                                        <div class="message-content">
                                            <p><strong>${userName}:</strong> ${message.message}</p>
                                            <div class="timestamp">${messageTime}</div>
                                        </div>
                                    </div>`;
                            $('#chatMessageContainer').append(messageHtml);
                        });

                        // Scroll to the bottom of the chat container
                        $('#chatMessageContainer').scrollTop($('#chatMessageContainer')[0]
                            .scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching messages:', error);
                    }
                });
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();

                let message = $('#messageInput').val().trim();
                let receiverId = $('#receiver_id').val();

                if (message === "") {
                    alert("Message cannot be empty.");
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('message.send') }}',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        message: message,
                        receiver_id: receiverId
                    },
                    beforeSend: function() {
                        // Disable the send button and change its text to "Sending..."
                        $('#sendMessageButton').text('Sending...').attr('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, "Success");
                            $('#messageInput').val(''); // Clear the input

                            let userAvatar =
                                '{{ asset('uploads/users/' . $LoggedUserInfo->picture) }}';
                            let userName = '{{ $LoggedUserInfo->name }}';

                            let messageTime = new Date().toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            let messageHtml = `
                                    <div class="chat-message sender">
                                        <div class="message-avatar">
                                            <img src="${userAvatar}" class="rounded-circle avatar" alt="">
                                        </div>
                                        <div class="message-content">
                                            <p><strong>${userName}:</strong> ${message}</p>
                                            <div class="timestamp">${messageTime}</div>
                                            </div>
                                    </div>`;

                            $('#chatMessageContainer').append(messageHtml);

                            // Scroll to the bottom of the chat container after sending a message
                            $('#chatMessageContainer').scrollTop($('#chatMessageContainer')[0]
                                .scrollHeight);
                        } else {
                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON.message);
                        toastr.error('Failed to send message', "Error");
                    },
                    complete: function() {
                        $('#sendMessageButton').text('Send').attr('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>
