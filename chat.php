
<?php

session_start();
if(!isset($_SESSION['username'])){
  header('location: signin.php');
  $_SESSION['password'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Self WhatsApp Chat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      transition: ease 0.3s, color 0.3s;
    }
    .header {
      padding: 10px;
      background: #075e54;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .header img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
    }
    .header .actions i {
      font-size: 18px;
      margin-left: 15px;
      cursor: pointer;
    }
    .chat-date {
      text-align: center;
      padding: 8px;
      background: #d0d0d0;
      color: #333;
    }
    .chat-window {
      height: 60vh;
      overflow-y: auto;
      padding: 10px;
      background: #e5ddd5;
      display: flex;
      flex-direction: column;
    }
    .controls {
      display: flex;
      flex-wrap: wrap;
      padding: 10px;
      background: #f0f0f0;
      gap: 8px;
      align-items: center;
      border-top: 1px solid #ccc;
    }
    .controls textarea, .controls input[type=time], .controls input[type=text], .controls select {
      padding: 6px;
      font-size: 14px;
      border-radius: 5px;
    }
    .controls textarea {
      flex: 1 1 100%;
    }
    .controls button, #theme-toggle {
      padding: 8px 12px;
      background: #075e54;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .controls .emoji-btn {
      font-size: 20px;
      cursor: pointer;
    }
    .message {
      margin: 10px 0;
      padding: 8px;
      border-radius: 8px;
      max-width: 75%;
      word-wrap: break-word;
    }
    .sender {
      background: #dcf8c6;
      align-self: flex-end;
    }
    .receiver {
      background: white;
      align-self: flex-start;
    }
    .timestamp {
      font-size: 10px;
      text-align: right;
      margin-top: 5px;
    }
    .dark-theme {
      background: #121212;
      color: #e0e0e0;
    }
    .dark-theme .chat-window {
      background: #1f1f1f;
    }
    .dark-theme .controls {
      background: #2c2c2c;
    }
    .dark-theme .chat-date {
      background: #333;
      color: #eee;
    }
    .dark-theme .sender {
      background: #075e54;
      color: #fff;
    }
    .dark-theme .receiver {
      background: #333;
      color: #e0e0e0;
    }
    
    .about-page {
  background: #ffffff;
  color: #000;
  padding: 20px;
  margin: 0;
}

.about-page h2 {
  color: #075e54;
  margin-top: 0;
  font-size: 26px;
}

.about-page h3 {
  color: #075e54;
  margin-top: 20px;
  font-size: 20px;
}

.about-page hr {
  border: 1px solid #075e54;
  margin: 10px 0;
}

.about-page p {
  font-size: 14px;
  line-height: 1.6;
  margin: 5px 0 20px;
}

@media (max-width: 600px) {
  .about-page {
    padding: 15px;
  }

  .about-page h2 {
    font-size: 22px;
  }

  .about-page h3 {
    font-size: 18px;
  }

  .about-page p {
    font-size: 13px;
  }
}

    @media (max-width: 600px) {
      .controls textarea {
        flex: 100%;
      }
    }

    .footer {
      background: #075e54;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .footer .social-icons a {
      color: white;
      margin: 0 8px;
      font-size: 18px;
      text-decoration: none;
    }
 
  </style>
</head>
<body>
  <div class="header">
    <div class="profile">
      <img id="profile-pic" src="https://via.placeholder.com/35" alt="Profile Picture">
      <input type="text" id="profile-name" value="You" style="border:none; background:transparent; color:white; font-size:16px; width:80px;">
      <input type="file" id="profile-image-upload" accept="image/*" style="display:none">
<div id="status-display" style="font-size:12px; color:white; margin-top:2px;">Online</div>
    </div>
    <div class="actions">
      <i class="fa fa-phone"></i>
      <i class="fa fa-video"></i>
      <i class="fa fa-ellipsis-v"></i>
      <!-- <a href="">Logout</a> -->
    </div>
  </div>

  <div class="chat-date">
    <input type="text" id="chat-day" value="Today" style="border:none; background:transparent; text-align:center; font-size:14px;">
  </div>

  <div class="chat-window" id="chat-window"></div>

  <div class="controls">
    <div id="emoji-picker" style="display:none; position:absolute; bottom:70px; background:white; border:1px solid #ccc; padding:5px; border-radius:5px; max-width:220px; flex-wrap:wrap; z-index:10;"></div>
    <span class="emoji-btn" id="emoji-btn">😀</span>
    <textarea id="message" placeholder="Type a message..."></textarea>
    <label for="image-upload"><i class="fa fa-image"></i></label>
    <input type="file" id="image-upload" accept="image/*" style="display:none">
    <input type="text" id="time-sent" placeholder="HH:MM" style="width:70px;">
    <select id="tick-status">
      <option value="none">No Tick</option>
      <option value="single">✔️ Single</option>
      <option value="double">✔✔️ Double</option>
      <option value="double-blue">✔✔️ Blue</option>
    </select>
    <select id="status-mode">
      <option>Online</option>
      <option>Offline</option>
    </select>
    <button onclick="sendMessage('sender')">Send</button>
    <button onclick="sendMessage('receiver')">Receive</button>
    <button id="theme-toggle">Toggle Theme</button>
  </div>

<div class="about-page">
  <h2>About Page</h2>
  <h3>How to use the self chat</h3>
  <hr>
  <p>This is a self WhatsApp-style chat where you can send messages as a sender or receiver, select message ticks, manually set time sent, attach images, and insert emojis. Toggle between light and dark themes using the provided button. You can indicate if the user is online or offline as well</p>
  <h3>What it was created for</h3>
  <hr>
  <p>This self-chat interface was built for demonstration, educational purposes and for fun time. It mimics core chat interactions in a personal environment for UI/UX testing and frontend practice. It is primarily created for persuasive marketting strategies but it can as well be used to create humorous contents on social media to pull engagement. <br> Note: Not for negative usage.</p>
</div>

<footer class="footer">
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p>&copy; 2025 Whatsapp Self Chat. All rights reserved.</p>
      </footer>

<script>
    const chatWindow = document.getElementById('chat-window');

    function sendMessage(type) {
      const messageText = document.getElementById('message').value;
      const timeSent = document.getElementById('time-sent').value;
      const tickStatus = document.getElementById('tick-status').value;
      const imageFile = document.getElementById('image-upload').files[0];

      if (messageText.trim() === '' && !imageFile) return;

      const messageDiv = document.createElement('div');
      messageDiv.className = `message ${type}`;

      let tickIcon = '';
      if (tickStatus === 'single') {
        tickIcon = '<i class="fa fa-check"></i>';
      } else if (tickStatus === 'double') {
        tickIcon = '<i class="fa fa-check-double"></i>';
      } else if (tickStatus === 'double-blue') {
        tickIcon = '<i class="fa fa-check-double" style="color:#34B7F1;"></i>';
      }

      let content = '';
      if (imageFile) {
        const imageUrl = URL.createObjectURL(imageFile);
        content += `<div><img src="${imageUrl}" style="max-width:100%; border-radius:8px;"></div>`;
      }
      if (messageText.trim() !== '') {
        content += `<div>${messageText}</div>`;
      }

      messageDiv.innerHTML = `
        ${content}
        <div class="timestamp">${timeSent || 'HH:MM'} ${tickIcon}</div>
      `;

      chatWindow.appendChild(messageDiv);
      chatWindow.scrollTop = chatWindow.scrollHeight;

      document.getElementById('message').value = '';
      document.getElementById('image-upload').value = '';
    }

    document.getElementById('theme-toggle').addEventListener('click', () => {
  document.body.classList.toggle('dark-theme');
});

document.getElementById('status-mode').addEventListener('change', (e) => {
  document.getElementById('status-display').textContent = e.target.value;
});

    document.getElementById('profile-pic').addEventListener('click', () => {
      document.getElementById('profile-image-upload').click();
    });

    document.getElementById('profile-image-upload').addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const imageUrl = URL.createObjectURL(file);
        document.getElementById('profile-pic').src = imageUrl;
      }
    });

    const emojiBtn = document.getElementById('emoji-btn');
const emojiPicker = document.getElementById('emoji-picker');
const messageInput = document.getElementById('message');

const emojiList = ['😀','😂','😍','😎','👍','🙏','🔥','🎉','❤️','💯','😢','🤔','🙌','😴','💖','👏','😡','😱','🥳','🤗','👑','🫶','🌟','🎶','🍀','⚽','🏀','🎮','🍕','🍔','🍟'];

emojiList.forEach(emoji => {
  const span = document.createElement('span');
  span.textContent = emoji;
  span.style.fontSize = '22px';
  span.style.margin = '5px';
  span.style.cursor = 'pointer';
  span.addEventListener('click', () => {
    messageInput.value += emoji;
    messageInput.focus();
    emojiPicker.style.display = 'none';
  });
  emojiPicker.appendChild(span);
});

emojiBtn.addEventListener('click', () => {
  emojiPicker.style.display = (emojiPicker.style.display === 'flex') ? 'none' : 'flex';
  emojiPicker.style.flexWrap = 'wrap';
});
  </script>
</body>
</html>

