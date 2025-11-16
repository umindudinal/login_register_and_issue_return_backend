document.addEventListener("DOMContentLoaded", function() {
    const addBookBtn = document.getElementById("addBookBtn");
    const updateBookBtn = document.getElementById("updateBookBtn");
    const addBookModal = document.getElementById("addBookModal");
    const updateBookModal = document.getElementById("updateBookModal");
    const viewBooksBtn = document.getElementById("viewBooksBtn");
    const bookListContainer = document.getElementById("bookListContainer");
    const closeButtons = document.querySelectorAll(".close-btn");

    addBookBtn.onclick = function() {
        addBookModal.style.display = "block";
    }
    updateBookBtn.onclick = function() {
        updateBookModal.style.display = "block";
    }
    viewBooksBtn.onclick = function() {
        bookListContainer.style.display = "block";
        loadAllBooks();
    }
    closeButtons.forEach(btn => {
        btn.onclick = function() {
            addBookModal.style.display = "none";
            updateBookModal.style.display = "none";
        }
    });
});
