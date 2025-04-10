<!-- modal.php -->
<div id="globalModal" class="modal-overlay hidden">
    <div class="modal-box scale-95 opacity-0 transition duration-300 ease-out">
        <div class="modal-header">
            <h2 id="modalTitle" class="text-xl font-semibold">Modal Title</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <br/>
        <hr/>
        <div class="modal-body" id="modalBody">
            <p>Loading...</p>
        </div>
    </div>
</div>


<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    pointer-events: auto;
}

.modal-box {
    background: #fff;
    padding: 1.5rem;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    position: relative;
    transform: scale(0.95);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-overlay.show .modal-box {
    transform: scale(1);
    opacity: 1;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.modal-close:hover{
    color: red;
    transition: all cubic-bezier(0.075, 0.82, 0.165, 1);
}

.hidden {
    display: none;
}
</style>


<script>
function openModal({ title, url }) {
    const overlay = document.getElementById("globalModal");
    const modalBox = overlay.querySelector(".modal-box");

    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modalBody").innerHTML = "Loading...";

    fetch(url)
        .then(res => res.text())
        .then(html => {
            document.getElementById("modalBody").innerHTML = html;

            // Make it visible first so it's in the DOM and can transition
            overlay.classList.remove("hidden");

            // Wait a tick to ensure the element is painted, then apply the .show class
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    overlay.classList.add("show");
                });
            });
        })
        .catch(() => {
            document.getElementById("modalBody").innerHTML = "<p>Error loading modal content.</p>";
        });
}


function closeModal() {
    const overlay = document.getElementById("globalModal");
    overlay.classList.remove("show");

    // Wait for animation to finish before hiding completely
    setTimeout(() => {
        overlay.classList.add("hidden");
    }, 300); // same as your transition duration
}

</script>
