function toggleLike(btn, questionId) {
    fetch('Code/xuly_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'question_id=' + encodeURIComponent(questionId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const icon = btn.querySelector('i');
            const text = btn.querySelector('span');
            const likeCountDiv = btn.closest('.container_post').querySelector('.likes_count');

            if (data.status === 'liked') {
                btn.classList.add('active');
                icon.classList.replace('far', 'fas');
                text.textContent = 'Đã thích';
            } else {
                btn.classList.remove('active');
                icon.classList.replace('fas', 'far');
                text.textContent = 'Thích';
            }

            likeCountDiv.innerHTML = `${data.totalLikes}`;
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(err => {
        console.error('Lỗi khi like:', err);
    });
}




//Ô comment khi click nút bình luận
function focusComment(){
    document.querySelector('.comment_input_box').focus();
}


//Xử lý khi nhập comment
document.addEventListener('DOMContentLoaded', function () {
    const commentBox = document.querySelector('.comment_input_box');
    if (!commentBox) {
        console.warn("Không tìm thấy .comment_input_box!");
        return;
    }

    commentBox.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const commentText = this.value.trim();
            console.log('Đã gửi comment:', commentText);
            if (commentText) {
                sendCommentToServer(commentText);
                this.value = '';
                this.style.height = '30%';
            }
        }
    });
});

// Gửi comment đến server
function sendCommentToServer(text) {
    const id_ques = document.querySelector('.comment_input_box').dataset.quesId;

    fetch('Code/xuly_binhluan.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `comment=${encodeURIComponent(text)}&id_ques=${encodeURIComponent(id_ques)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            console.error('Lỗi:', data.error);
        } else {
            addNewComment(data); // Truyền object đúng dạng
        }
    })
    .catch(err => console.error('Lỗi gửi comment:', err));
}




// Thêm comment mới
function addNewComment(data) {
    console.log('Dữ liệu truyền vào addNewComment:', data);

    if (!data || typeof data !== 'object') {
        console.error('❌ addNewComment gọi sai định dạng', data);
        return;
    }

    const commentList = document.querySelector('.comment_list');
    const newComment = document.createElement('div');
    newComment.innerHTML = `
        <div class="comment_item">
            <img src="uploads/${data.avatar}" alt="Avatar" class="comment_avata">
            <div class="comment_content">
                <div class="comment_user">${data.user_name}</div>
                <div class="comment_text">${data.text}</div>
                <div class="comment_actions">
                    <span class="comment_action">Thích</span>
                    <span class="comment_action">Phản hồi</span>
                    <span class="comment_action">${data.time}</span>
                </div>
            </div>
        </div>`;
    commentList.prepend(newComment);

    const commentCount = document.querySelector('.comments_count');
    const current = parseInt(commentCount.textContent) || 0;
    commentCount.textContent = `${current + 1} bình luận`;
}


// Thu gon và đóng chat
document.addEventListener('DOMContentLoaded', function() {
    const chatBtn = document.querySelector('.container_chat');
    const chatBox = document.querySelector('.chat_box');
    const btnClose = document.querySelector('.chat_close');
    const btnMinimize = document.querySelector('.chat_mini');

    chatBtn.addEventListener('click', function() {
        chatBox.classList.add('active');
        chatBox.classList.remove('minimized');
        chatBox.style.display = '';
    });

    btnClose.addEventListener('click', function(e) {
        chatBox.classList.remove('active');
        chatBox.classList.remove('minimized');
        chatBox.style.display = 'none';
        e.stopPropagation();
    });

    btnMinimize.addEventListener('click', function(e) {
        chatBox.classList.add('minimized');
        e.stopPropagation();
    });

    // Khi ở trạng thái mini, nhấn vào bóng chat để mở lại
    chatBox.addEventListener('click', function(e) {
        if (chatBox.classList.contains('minimized')) {
            // Nếu click vào nút đóng thì không mở lại
            if (e.target.classList.contains('chat_close')) return;
            chatBox.classList.remove('minimized');
        }
    });


    const followBtn = document.getElementById('followBtn');
    const followerCount = document.getElementById('followerCount');
    let isFollowing = false;
    let count = parseInt(followerCount.textContent);

    followBtn.addEventListener('click', function() {
        if (!isFollowing) {
            isFollowing = true;
            followBtn.textContent = 'Đã theo dõi';
            count++;
        } else {
            isFollowing = false;
            followBtn.textContent = 'Theo dõi';
            count--;
        }
        followerCount.textContent = count;
    });
});

let lastMessageHTML = ""; // lưu nội dung HTML cũ để so sánh

function loadMessages() {
    const sender_id = document.getElementById("sender_id").value;
    const receiver_id = document.getElementById("receiver_id").value;

    if (!sender_id || !receiver_id) return;

    const content = document.querySelector(".chat_content");
    const isAtBottom = Math.abs(content.scrollTop + content.clientHeight - content.scrollHeight) < 10;
    const previousScrollTop = content.scrollTop;

    fetch(`Code/get_messages.php?sender_id=${sender_id}&receiver_id=${receiver_id}`)
        .then(res => res.text())
        .then(html => {
            // Nếu giống nhau thì không làm gì để tránh nháy
            if (html.trim() === lastMessageHTML.trim()) return;

            // Gán nội dung mới
            content.innerHTML = html;
            lastMessageHTML = html;

            // Cuộn tùy theo trạng thái
            if (isAtBottom) {
                content.scrollTop = content.scrollHeight;
            } else {
                content.scrollTop = previousScrollTop;
            }
        })
        .catch(err => {
            console.error("Lỗi khi tải tin nhắn:", err);
        });
}




document.querySelector(".chat_input").addEventListener("submit", async (e) => {
    e.preventDefault();

    const sender_id = document.getElementById("sender_id").value;
    const receiver_id = document.getElementById("receiver_id").value;
    const message = document.getElementById("chatInput").value.trim();

    if (!message) return;

    const formData = new FormData();
    formData.append("sender_id", sender_id);
    formData.append("receiver_id", receiver_id);
    formData.append("message", message);

    try {
        const response = await fetch("Code/send_message.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        if (result.error) throw new Error(result.error);

        document.getElementById("chatInput").value = "";
        loadMessages(); // tải lại tin nhắn mới
    } catch (err) {
        alert("Lỗi gửi tin nhắn: " + err.message);
    }
});

// Gọi load mỗi 3s
setInterval(loadMessages, 3000);

