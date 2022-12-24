document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById("sender");
    // Get the form element
    const form = document.querySelector('#new-message-form');

    const xhr = new XMLHttpRequest();

    // Set up the request to the PHP script
    xhr.open("GET", "reset-cookie.php", true);

    // Send the request
    xhr.send();
    // Add a submit event listener to the form
    form.addEventListener('submit', (event) => {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Get the message input
        const messageInput = document.querySelector('#message');

        if (messageInput.value.trim() === '') {
            // Display an error message
            alert("Please enter a message.");
            return;
        }


        // Send the message to the server
        sendMessage(messageInput.value, select.options[select.selectedIndex].value).then((response) => {
            if (response.status === 200) {
                // Clear the message input
                messageInput.value = '';
            } else {
                // Display an error message
                alert(response.message);
            }
        });
    });

    // Send a message to the server
    async function sendMessage(message, sender) {
        // Send an AJAX request to the server
        console.log(sender);

        // Return the response as text
        return await fetch('send-message.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `message=${message}&sender=${sender}`
        });
    }
});

// Get the messages for a given thread and display them on the page
function getMessages() {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            eval(xhr.responseText);
        }
    };
    xhr.open("GET", "get-messages.php", true);
    xhr.send();
}

setInterval(getMessages, 1000);
