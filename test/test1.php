<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Iframe Video Player</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f0f0f0;
            --text-color: #333;
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #e74c3c;
        }
        .dark-mode {
            --bg-color: #1a1a1a;
            --text-color: #f0f0f0;
            --primary-color: #2980b9;
            --secondary-color: #27ae60;
            --accent-color: #c0392b;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .player-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background-color: #000;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #iframePlayer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #fff;
            display: none;
        }
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        .btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        .btn:active {
            transform: translateY(0);
        }
        .channel-select {
            position: relative;
            width: 200px;
        }
        .channel-select select {
            width: 100%;
            padding: 10px;
            border-radius: 25px;
            border: 2px solid var(--primary-color);
            background-color: var(--bg-color);
            color: var(--text-color);
            font-size: 16px;
            appearance: none;
            cursor: pointer;
        }
        .channel-select::after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }
        #channelInfoWrapper {
            display: flex;
            justify-content: space-between; /* Aligns content to left and right */
            align-items: center;
            margin: 20px 0;
        }
        #channelInfo {
            font-size: 24px;
            font-weight: bold;
            text-align: left;
        }
        .dark-mode-toggle {
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 16px;
            cursor: pointer;
            padding: 10px;
            transition: color 0.3s, transform 0.3s;
            text-align: right;
        }
        .dark-mode-toggle i {
            margin-left: 5px;
        }
        .dark-mode-toggle:hover {
            color: var(--primary-color);
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            #channelInfoWrapper {
                flex-direction: column; /* Stack channel name and toggle vertically on small screens */
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="player-wrapper">
            <iframe id="iframePlayer" allowfullscreen></iframe>
            <div class="loading" id="loading">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
        <div id="channelInfoWrapper">
            <div id="channelInfo">Rajshahi TV</div> <!-- Example Channel Name -->
            <button id="darkModeToggle" class="dark-mode-toggle">
                Dark Mode <i class="fas fa-moon"></i>
            </button>
        </div>
        <div class="controls">
            <button id="prevBtn" class="btn"><i class="fas fa-step-backward"></i> Previous</button>
            <div class="channel-select">
                <select id="channelSelect"></select>
            </div>
            <button id="nextBtn" class="btn">Next <i class="fas fa-step-forward"></i></button>
        </div>
    </div>

    <script>
        const iframePlayer = document.getElementById('iframePlayer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const channelSelect = document.getElementById('channelSelect');
        const loading = document.getElementById('loading');
        const darkModeToggle = document.getElementById('darkModeToggle');

        const channels = [
            { name: "Rajshahi TV", url: "https://www.youtube.com/embed/dQw4w9WgXcQ" }, // Example iframe embed URL
            { name: "Sports Live", url: "https://www.youtube.com/embed/someVideo2" },
            { name: "Movie Central", url: "https://www.youtube.com/embed/someVideo3" },
            { name: "Music TV", url: "https://www.youtube.com/embed/someVideo4" },
            { name: "Nature & Wildlife", url: "https://www.youtube.com/embed/someVideo5" },
        ];

        let currentChannel = 0;

        function initializePlayer() {
            channels.forEach((channel, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = channel.name;
                channelSelect.appendChild(option);
            });

            iframePlayer.addEventListener('load', () => {
                loading.style.display = 'none';
            });

            switchChannel(0);
        }

        function switchChannel(index) {
            currentChannel = index;
            iframePlayer.src = channels[currentChannel].url; // Set the iframe URL
            loading.style.display = 'block'; // Show loading animation
            updateChannelInfo();
            channelSelect.value = currentChannel;
        }

        function updateChannelInfo() {
            const channelInfo = document.getElementById('channelInfo');
            channelInfo.textContent = channels[currentChannel].name;
        }

        prevBtn.addEventListener('click', () => {
            switchChannel((currentChannel - 1 + channels.length) % channels.length);
        });

        nextBtn.addEventListener('click', () => {
            switchChannel((currentChannel + 1) % channels.length);
        });

        channelSelect.addEventListener('change', (e) => {
            switchChannel(parseInt(e.target.value));
        });

        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            darkModeToggle.innerHTML = isDarkMode 
                ? 'Light Mode <i class="fas fa-sun"></i>' 
                : 'Dark Mode <i class="fas fa-moon"></i>';
        });

        initializePlayer();
    </script>
</body>
</html>