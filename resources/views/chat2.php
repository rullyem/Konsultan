<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="UTF-8">
	<title>Chat</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="shortcut icon" href="http://www.yoursite.com/" />
	<style>
		#chat-area {
			height: 100%;
			width: 100%;
		}
		
		.input-group {
			position: fixed;
			bottom: 0;
			left: 0;
		}
	</style> 
</head>

<body>
	<div id="chat-area">
		<ul class="list-group">
		</ul>
	</div>
	<form id="chat-form">
		<div class="input-group">
			<input id="message" type="text" autocomplete="off" class="form-control" placeholder="Enter your message...">
			<span class="input-group-btn">
			<input class="btn btn-primary" type="submit" value="Send">
		</span>
		</div>
	</form>

	<script>
		var conn = new WebSocket('ws://localhost:3000');
		conn.onopen = function (e) {
			console.log("Connection established!");
		};

		conn.onmessage = function (e) {
			showMessage(e.data, 'Others');
		};

		document.querySelector('#chat-form').addEventListener('submit', function (e) {
			e.preventDefault();

			var messageElement = document.querySelector('#message');
			var message = messageElement.value;

			var messageData = {
				'id': '',
				'userId': '12334',
				'content': message
			}
			var messageDataJson = JSON.stringify(messageData);

			conn.send(JSON.stringify(messageDataJson));
			showMessage(message, 'Me');
			messageElement.value = '';
		});

		function showMessage(msg, sender) {
			var messageItem = document.createElement('li');
			var className = 'list-group-item';
			
			if (messageItem.classList) 
				messageItem.classList.add(className); 
			else 
				messageItem.className += ' ' + className;

			messageItem.innerHTML = '<strong>' + sender + ': </strong>' + msg;	
			document.querySelector('#chat-area > ul').appendChild(messageItem);
		}
	</script>
</body>

</html>