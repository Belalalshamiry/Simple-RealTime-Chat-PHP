function sendMessage(user) {

    let fileInput = document.getElementById("file");
    let file = fileInput.files[0];
    let msg  = document.getElementById("msg").value;

    let fd = new FormData();
    fd.append("receiver", user);

      fd.append("message", msg); // مهم إرسال النص أيضاً
    

    if (file) {
      fd.append("file", file);
    }
    if(msg!=null || msg!=""){

    fetch("upload.php", {
      method: "POST",
      body: fd
    })
  
    .then(() => {
        // إعادة تعيين الحقول بعد الإرسال
        document.getElementById("msg").value = "";
        document.getElementById("file").value = "";
        // تحديث الدردشة فوراً
        fetchMessages(user);
    })
    .catch(err => console.error("خطأ في الإرسال:", err));
  }
}

    
  
  
  
  

  

  function fetchMessages(user) {
    fetch("fetch.php?user=" + user)
      .then(res => res.json())
      .then(data => {
        const box = document.getElementById("chat-box");
        box.innerHTML = "";
  
        data.forEach(m => {
            console.log(m);

          const side = (m.sender_id == myId) ? "me" : "other";
  
          let content = "";
          if (m.file_type === "image") {
            content = `<img src="uploads/images/${m.file_name}">`;
          } else {
            content = m.message;
          }
  
          box.innerHTML += `
            <div class="message-row ${side}">
              <div class="message ${side}">
                ${content}
              </div>
            </div>
          `;
        });
  
        box.scrollTop = box.scrollHeight;
      });
  }
  
  
  // ⭐⭐ هذا هو السطر المهم ⭐⭐
  // setInterval(() => {
  //   fetchMessages(otherUser);
  // }, 1000);
  