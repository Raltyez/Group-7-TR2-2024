<?php
include_once("header.php");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Simulated responses
    $responses = [
        "hi" => "Hello! How can I help you today?",
        "order" => "You can view your order history by clicking on the 'Order History' button.",
        "design" => "You can request a specific design by visiting the 'Request Design' page.",
        "help" => "I'm here to assist you with any questions you may have."
    ];

    $data = json_decode(file_get_contents('php://input'), true);
    $userMessage = strtolower(trim($data['message']));

    // Default response
    $response = "I'm not sure how to respond to that. Can you please rephrase?";

    // Check for predefined responses
    foreach ($responses as $keyword => $reply) {
        if (strpos($userMessage, $keyword) !== false) {
            $response = $reply;
            break;
        }
    }

    echo json_encode(['response' => $response]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Virtual Assistant</title>
    <style>
        body {
            color: white;
        }
        button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <main>
        <div class="chat_container">
            <h2>Chat with Virtual Assistant</h2>
            <div id="predefined_responses">
                <h3>Quick Responses</h3>
                <ul>
                    <li>hi => Hello! How can I help you today?</li>
                    <li>order => You can view your order history by clicking on the 'Order History' button.</li>
                    <li>design => You can request a specific design by visiting the 'Request Design' page.</li>
                    <li>help => I'm here to assist you with any questions you may have.</li>
                </ul>
            </div>
            <div id="chat_container">
                <div id="chat_box">
                    <!-- Chat messages will be displayed here -->
                </div>
                <form id="chat_form">
                    <input type="text" id="user_message" placeholder="Type your message..." required>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('chat_form').addEventListener('submit', function(event) {
            event.preventDefault();
            let userMessage = document.getElementById('user_message').value;
            let chatBox = document.getElementById('chat_box');
            
            // Display user message
            let userMessageDiv = document.createElement('div');
            userMessageDiv.textContent = 'You: ' + userMessage;
            chatBox.appendChild(userMessageDiv);
            
            // Send user message to server
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                // Display assistant response
                let assistantMessageDiv = document.createElement('div');
                assistantMessageDiv.textContent = 'Assistant: ' + data.response;
                chatBox.appendChild(assistantMessageDiv);
                
                // Scroll to the bottom of the chat box
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            // Clear input field
            document.getElementById('user_message').value = '';
        });
    </script>
</body>
</html>

<?php
include_once("footer.html");
?>
