<x-app-layout>
<style>
    main.app-main {
        background-color: #f9fafb;
        min-height: 100vh;
        padding: 2rem;
        color: #333;
    }

    h3 {
        color: #b91c1c;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    form {
        max-width: 1500px;
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(185, 28, 28, 0.15);
    }

    label {
        font-weight: 600;
        color: #7f1d1d;
    }

    input[type="text"],
    input[type="file"],
    #assignDropdownToggle,
    #searchAssignee {
        border-radius: 0.5rem;
        border: 1.5px solid #f87171;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        color: #333;
        transition: border-color 0.3s ease;
        width: 100%;
    }

    input[type="text"]:focus,
    input[type="file"]:focus,
    #assignDropdownToggle:focus,
    #searchAssignee:focus {
        border-color: #b91c1c;
        outline: none;
        box-shadow: 0 0 8px rgba(185, 28, 28, 0.4);
    }

    /* Quill editor container */
    #messageEditor {
        height: 180px;
        border: 1.5px solid #f87171;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
    }

    /* Dropdown styling */
    #assignDropdownToggle {
        cursor: pointer;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #assignDropdown {
        max-height: 240px;
        overflow-y: auto;
        z-index: 10;
    }

    /* Button */
    button[type="submit"] {
        background-color: #b91c1c;
        border: none;
        color: white;
        font-weight: 700;
        padding: 0.65rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 1.5rem;
    }

    button[type="submit"]:hover {
        background-color: #7f1d1d;
        box-shadow: 0 0 12px rgba(185, 28, 28, 0.6);
    }

</style>

<main class="app-main">
    <div class="container-fluid">
        <h3>Broadcast Email</h3>
        <form action="{{ route('broadcast.send') }}" method="POST" enctype="multipart/form-data" onsubmit="return submitForm()">
            @csrf

            <!-- Subject -->
            <div class="form-group mb-3">
                <label for="subject">Subject</label>
                <input id="subject" type="text" name="subject" class="form-control" required>
            </div>

            <!-- Message -->
            <div class="form-group mb-3">
                <label for="messageEditor">Message</label>
                <div id="messageEditor"></div>
                <input type="hidden" name="message" id="messageInput" required>
            </div>

            <!-- Attachment -->
            <div class="form-group mb-3">
                <label for="attachment">Attachment (optional)</label>
                <input id="attachment" type="file" name="attachment" class="form-control">
            </div>

            <!-- Recipient Dropdown -->
        <div class="p-2 border-bottom">
    <!-- Filter Category -->
    <div class="d-flex gap-2">
        <select id="filterCategory" class="form-select form-select-sm mb-2">
            <option value="">-- Filter by Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <!-- Select All by Category -->
        <button type="button" id="selectCategoryBtn" class="btn btn-sm btn-primary mb-2">
            Select All
        </button>
    </div>

    <!-- Search -->
    <input type="text" class="form-control form-control-sm" 
           id="searchAssignee" placeholder="Search...">
</div>

<!-- List Users -->
<div id="assignList" class="p-2" style="max-height: 200px; overflow-y: auto;">
    @foreach($clients as $client)
    <div class="form-check client-item" data-category="{{ $client->category_id }}">
        <input class="form-check-input user-checkbox" 
               type="checkbox" 
               name="recipients[]" 
               value="{{ $client->email }}" 
               id="user_{{ $client->id }}">
        <label class="form-check-label" for="user_{{ $client->id }}">
            {{ $client->name }} ({{ $client->email }})
            - <small class="text-muted">{{ $client->category->name ?? '-' }}</small>
        </label>
    </div>
    @endforeach
</div>


            <button type="submit">Send Broadcast</button>
        </form>
    </div>
</main>
<style>
.ql-font-arial { font-family: Arial, Helvetica, sans-serif; }
.ql-font-times-new-roman { font-family: "Times New Roman", serif; }
.ql-font-georgia { font-family: Georgia, serif; }
.ql-font-verdana { font-family: Verdana, sans-serif; }
</style>

<!-- Quill CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    // Quill editor init
    var quill = new Quill('#messageEditor', {
        theme: 'snow',
        placeholder: 'Type your message here...',
        modules: {
            toolbar: [
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'super' }, { 'script': 'sub' }],
                [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                ['direction', { 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Before submit, copy Quill content to hidden input
    window.submitForm = function() {
        var html = quill.root.innerHTML.trim();
        if (html === '<p><br></p>' || html === '') {
            alert('Message cannot be empty.');
            return false;
        }
        document.getElementById('messageInput').value = html;
        return true;
    }

    // Dropdown toggle and filter logic
    const toggle = document.getElementById("assignDropdownToggle");
    const dropdown = document.getElementById("assignDropdown");
    const search = document.getElementById("searchAssignee");
    const checkboxes = document.querySelectorAll(".user-checkbox");
    const selectAll = document.getElementById("selectAll");
    const selectedCount = document.getElementById("selectedCount");

    toggle.addEventListener("click", () => {
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
            toggle.setAttribute("aria-expanded", "true");
        } else {
            dropdown.style.display = "none";
            toggle.setAttribute("aria-expanded", "false");
        }
    });

    search.addEventListener("input", function () {
        const term = this.value.toLowerCase();
        checkboxes.forEach(cb => {
            const label = cb.nextElementSibling.textContent.toLowerCase();
            cb.closest(".form-check").style.display = label.includes(term) ? "" : "none";
        });
    });

    selectAll.addEventListener("change", function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    checkboxes.forEach(cb => cb.addEventListener("change", updateSelectedCount));

    function updateSelectedCount() {
        const checked = document.querySelectorAll(".user-checkbox:checked").length;
        selectedCount.textContent = checked > 0 ? `${checked} selected` : "Select Recipients";
        selectAll.checked = checked === checkboxes.length;
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function(e) {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
            toggle.setAttribute("aria-expanded", "false");
        }
    });
});
</script> -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const quill = new Quill('#messageEditor', {
        theme: 'snow',
        placeholder: 'Type your message here...',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ],
                handlers: {
                    image: imageHandler
                }
            }
        }
    });

    function imageHandler() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.click();

        input.onchange = async () => {
            const file = input.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('/upload-email-image', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (!data.url) {
                    alert('Upload failed');
                    return;
                }

                const range = quill.getSelection(true);
                quill.insertEmbed(range.index, 'image', data.url);
                quill.setSelection(range.index + 1);

            } catch (err) {
                console.error(err);
                alert('Upload error');
            }
        };
    }

    window.submitForm = function () {
        document.getElementById('messageInput').value =
            quill.root.innerHTML;
        return true;
    };

});
</script>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchAssignee");
    const filterCategory = document.getElementById("filterCategory");
    const selectCategoryBtn = document.getElementById("selectCategoryBtn");
    const clientItems = document.querySelectorAll(".client-item");

    //  Search filter (ikut category filter)
    searchInput.addEventListener("keyup", function () {
        let value = this.value.toLowerCase();
        let selected = filterCategory.value;

        clientItems.forEach(item => {
            let text = item.textContent.toLowerCase();
            let category = item.getAttribute("data-category");

            // tampilkan hanya kalau:
            // - sesuai category (atau category kosong = semua)
            // - dan cocok dengan keyword search
            if ((selected === "" || category === selected) && text.includes(value)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Category filter
    filterCategory.addEventListener("change", function () {
        let selected = this.value;
        let value = searchInput.value.toLowerCase();

        clientItems.forEach(item => {
            let category = item.getAttribute("data-category");
            let text = item.textContent.toLowerCase();

            if ((selected === "" || category === selected) && text.includes(value)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Toggle Select All / Unselect
    selectCategoryBtn.addEventListener("click", function () {
        let selected = filterCategory.value;

        // Cari client mana saja yg akan diproses (ikut filter kategori)
        let targetClients = Array.from(clientItems).filter(item => {
            let category = item.getAttribute("data-category");
            return !selected || category === selected;
        });

        // Cek apakah semuanya sudah dicentang
        let allChecked = targetClients.every(item => item.querySelector(".user-checkbox").checked);

        // Toggle
        targetClients.forEach(item => {
            let checkbox = item.querySelector(".user-checkbox");
            checkbox.checked = !allChecked;
        });

        // Ganti teks tombol
        this.textContent = allChecked ? "Select All" : "Unselect All";
    });
});
</script>


</x-app-layout>