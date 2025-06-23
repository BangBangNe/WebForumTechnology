function toggleLike(btn){
    btn.classList.toggle('active');
    const icon =btn.querySelector('i');
    const text=btn.querySelector('span');

    if(btn.classList.contains('active')){
        icon.classList.replace('far','fas');
        text.textContent="Đã thích";
    }else{
        icon.classList.replace('fas', 'far');
        text.textContent = 'Thích';
    }

    //Cập nhập số lượng like
    const likesCount=document.querySelector('.likes_count');
    const currentLikes=parseInt(likesCount.textContent);
    likesCount.textContent=btn.classList.contains('active')? currentLikes+1:currentLikes-1;
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
                addNewComment(commentText);
                this.value = '';
                this.style.height = '30%';
                sendCommentToServer(commentText);
                console.log('Đã gửi comment:', commentText);
            }
        }
    });
});

// Gửi comment đến server
function sendCommentToServer(text) {
    const id_ques = document.querySelector('.comment_input_box').dataset.quesId;

    fetch('xuly_binhluan.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `comment=${encodeURIComponent(text)}&id_ques=${encodeURIComponent(id_ques)}`
    })
    .then(res => res.text())
    .then(data => {
        console.log('Server phản hồi:', data);
    })
    .catch(err => console.error('Lỗi gửi comment:', err));
}

// Thêm comment mới
 function addNewComment(text){ 
    const commentList=document.querySelector('.comment_list');
    const newComment = document.createElement('div');
    newComment.innerHTML = `
        <div class="comment_item">
            <img src="test.jpg" alt="" class="comment_avata">
            <div class="comment_content">
                <div class="comment_user">Bạn</div>
                <div class="comment_text">${text}</div>
                <div class="comment_actions">
                    <span class="comment_action">Thích</span>
                    <span class="comment_action">Phản hồi</span>
                    <span class="comment_action">2 giờ trước</span>
                </div>
            </div>
        </div>`;
    commentList.prepend(newComment);

    //Cập nhật số comment
    const commentCount=document.querySelector('.comments_count');
    const currentComments=parseInt(commentCount.textContent);
    commentCount.textContent=`${currentComments+1} bình luận`;
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

    fetch(`get_messages.php?sender_id=${sender_id}&receiver_id=${receiver_id}`)
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
        const response = await fetch("send_message.php", {
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

