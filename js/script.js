document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
        const username = form.username.value.trim();
        const password = form.password.value.trim();
        
        if (username === "" || password === "") {
            alert("Please fill out all fields.");
            e.preventDefault(); // Ngăn chặn gửi form nếu có trường rỗng
        }
    });
});
