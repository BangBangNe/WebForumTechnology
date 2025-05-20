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
document.querySelector('.comment_input_box').addEventListener('keypress',function(e){
    if(e.key==='Enter'&&!e.shiftKey){
        e.preventDefault();
        const commentText = this.value.trim();
        if(commentText){
            addNewComment(commentText);
            this.value='';
            this.style.height = '30%';
        }
    }
});

//Thêm comment mới
 function addNewComment(text){ // Phần này chạy được mà nó rất kì bạn băng xem giúp mình nhé
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