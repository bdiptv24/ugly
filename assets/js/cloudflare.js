
     document.addEventListener("DOMContentLoaded", function() {
            var username = prompt('Enter your username:');
            var password = prompt('Enter your password:');

            // Check username and password
            if (username === 'admin' && password === 'admin') {
                document.getElementById('content').style.display = 'block';
            } else {
                alert('Invalid username or password. Please try again.');
                document.body.style.display = 'none'; // Hide the entire body if credentials are incorrect
            }
        });
    
