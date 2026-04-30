<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Layout 20-60-20</title>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    html, body {
        height: 100%;
    }

    .container {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* TOP 20% */
    .top {
        height: 15%;
        padding: 10px 15px;
        background: #f5f5f5;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 8px;
        border-bottom: 1px solid #ddd;
    }

    .top-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .top-row input {
        flex: 1;
        padding: 8px 10px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .top-row button {
        padding: 8px 16px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        color: white;
    }

    .btn-save   { background: #007bff; }
    .btn-save:hover { background: #0056b3; }

    .btn-update { background: #28a745; }
    .btn-update:hover { background: #1e7e34; }

    .btn-log    { background: #6c757d; }
    .btn-log:hover { background: #545b62; }

    .btn-del-log { background: #dc3545; }
    .btn-del-log:hover { background: #a71d2a; }

    .btn-upload { background: #fd7e14; }
    .btn-upload:hover { background: #c96209; }

    .btn-del-up { background: #6f42c1; }
    .btn-del-up:hover { background: #4e2d89; }

    /* MIDDLE 60% */
    .middle {
        height: 90%;
        overflow: auto;
        padding: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background: #eee;
    }

    /* BOTTOM 20% */
    .bottom {
        height: 10%;
        padding: 15px;
        background: #222;
        color: #fff;
        border-top: 1px solid #444;
    }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-box {
        background: #fff;
        border-radius: 8px;
        padding: 30px 36px;
        min-width: 300px;
        max-width: 420px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        text-align: center;
    }
    .modal-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }
    .modal-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .modal-message {
        font-size: 14px;
        color: #555;
        margin-bottom: 22px;
    }
    .modal-close {
        padding: 9px 28px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        color: #fff;
        background: #007bff;
    }
    .modal-close:hover { background: #0056b3; }

    .modal-box.success .modal-title { color: #28a745; }
    .modal-box.error   .modal-title { color: #dc3545; }
    .modal-box.warning .modal-title { color: #fd7e14; }
    .modal-box.info    .modal-title { color: #6c757d; }
</style>
</head>

<body>

<div class="container">

   
   <livewire:receipt-list />

    <!-- BOTTOM -->
    <div class="bottom">
        <div>Status: Connected</div>
        <div>Logs: Ready</div>
    </div>

</div>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal-box" id="modalBox">
        <div class="modal-icon" id="modalIcon"></div>
        <div class="modal-title" id="modalTitle"></div>
        <div class="modal-message" id="modalMessage"></div>
        <button class="modal-close" onclick="hideModal()">OK</button>
    </div>
</div>

<script>
    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };

    function showModal(type, title, message) {
        document.getElementById('modalIcon').textContent    = icons[type] || '';
        document.getElementById('modalTitle').textContent   = title;
        document.getElementById('modalMessage').textContent = message;
        const box = document.getElementById('modalBox');
        box.className = 'modal-box ' + type;
        document.getElementById('modalOverlay').classList.add('active');
    }

    function hideModal() {
        document.getElementById('modalOverlay').classList.remove('active');
    }

    function closeModal(e) {
        if (e.target === document.getElementById('modalOverlay')) hideModal();
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') hideModal(); });

    window.addEventListener('show-modal', event => {
        if (!event.detail) return;
        showModal(event.detail.type, event.detail.title, event.detail.message);
    });
</script>

</body>
</html>