document.addEventListener("DOMContentLoaded", function() {
    // Example comments and replies with timestamps and unique IDs
    const comments = [
        { id: 1, text: "This is an amazing article! Thanks for sharing.", timestamp: new Date('2024-08-23T10:00:00Z'), parentId: null },
        { id: 2, text: "I really enjoyed reading this. Great job!", timestamp: new Date('2024-08-24T09:00:00Z'), parentId: null },
        { id: 3, text: "Interesting perspective. I learned a lot.", timestamp: new Date('2024-08-24T08:00:00Z'), parentId: null },
        { id: 4, text: "Not sure I agree with everything here, but it's a good read.", timestamp: new Date('2024-08-22T07:00:00Z'), parentId: null },
        { id: 5, text: "This article could use more detail on the subject.", timestamp: new Date('2024-08-21T06:00:00Z'), parentId: null },
        { id: 6, text: "I agree with your point about the details.", timestamp: new Date('2024-08-24T11:00:00Z'), parentId: 1 },
        { id: 7, text: "Could you elaborate on the main argument?", timestamp: new Date('2024-08-24T11:30:00Z'), parentId: 2 },
        { id: 8, text: "Sure, here's more detail.", timestamp: new Date('2024-08-24T12:00:00Z'), parentId: 7 },
        { id: 9, text: "Thanks for clarifying!", timestamp: new Date('2024-08-24T12:30:00Z'), parentId: 8 },
        { id: 10, text: "Thanks for clarifying!", timestamp: new Date('2024-08-24T12:30:00Z'), parentId: 7 }
    ];

    // Sort comments by timestamp in descending order
    comments.sort((a, b) => b.timestamp - a.timestamp);

    // Function to render comments recursively with level tracking
    function renderComments(comments, parentId = null, level = 0) {
        const fragment = document.createDocumentFragment();

        comments
            .filter(comment => comment.parentId === parentId)
            .forEach(comment => {
                const div = document.createElement('div');
                div.className = `comment reply level-${level % 2 === 0 ? 'even' : 'odd'}`; // Alternate between 'even' and 'odd' levels
                div.innerHTML = `
                    <span class="timestamp">Posted on: ${comment.timestamp.toLocaleString()}</span>
                    <div class="text">${comment.text}</div>
                    <button class="reply-button" data-id="${comment.id}">Reply</button>
                `;
                div.setAttribute('id', `comment-${comment.id}`);

                // Render replies recursively, incrementing the level
                const replies = renderComments(comments, comment.id, level + 1);
                if (replies) {
                    div.appendChild(replies);
                }

                fragment.appendChild(div);
            });

        return fragment;
    }

    // Create the reader-comments div
    const readerCommentsDiv = document.querySelector('#reader-comments');

    if (readerCommentsDiv) {
        // Clear any existing content
        readerCommentsDiv.innerHTML = '<hr>';

        // Create and add heading
        const heading = document.createElement('h3');
        heading.textContent = "Readers' Comments";
        readerCommentsDiv.appendChild(heading);

        // Create the comment form
        const commentForm = document.createElement('div');
        commentForm.innerHTML = `
            <textarea id="new-comment" rows="3" placeholder="Write your comment..."></textarea>
            <br>
            <button id="submit-comment">Comment</button>
        `;
        readerCommentsDiv.appendChild(commentForm);

        // Render comments and append to the reader-comments div
        const commentsFragment = renderComments(comments);
        readerCommentsDiv.appendChild(commentsFragment);

        // Handle comment submission
        document.getElementById('submit-comment').addEventListener('click', function() {
            const newCommentText = document.getElementById('new-comment').value.trim();
            if (newCommentText) {
                const newComment = {
                    id: comments.length + 1,  // Generate a new unique ID
                    text: newCommentText,
                    timestamp: new Date(),
                    parentId: null
                };
                comments.unshift(newComment);  // Add new comment at the beginning
                renderCommentsList();  // Re-render the comments
                document.getElementById('new-comment').value = '';  // Clear the input field
            }
        });

        // Handle reply button click
        readerCommentsDiv.addEventListener('click', function(event) {
            if (event.target.classList.contains('reply-button')) {
                const parentId = parseInt(event.target.getAttribute('data-id'));
                const replyText = prompt("Write your reply:");
                if (replyText) {
                    const newReply = {
                        id: comments.length + 1,  // Generate a new unique ID
                        text: replyText,
                        timestamp: new Date(),
                        parentId: parentId
                    };
                    comments.unshift(newReply);  // Add new reply at the beginning
                    renderCommentsList();  // Re-render the comments
                }
            }
        });

        // Function to re-render the comments list
        function renderCommentsList() {
            const newCommentsFragment = renderComments(comments);
            readerCommentsDiv.querySelectorAll('.comment').forEach(comment => comment.remove());
            readerCommentsDiv.appendChild(newCommentsFragment);
        }
    }
});
