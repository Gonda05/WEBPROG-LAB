<?php

function setFlash($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}



function displayFlash() {
    if (!isset($_SESSION['flash'])) return;

    $flash = $_SESSION['flash'];
    $message = htmlspecialchars($flash['message']);
    $type = $flash['type'];

    $styles = [
        'success' => 'bg-green-100 text-green-800 border border-green-300',
        'error' => 'bg-red-100 text-red-800 border border-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
        'info' => 'bg-blue-100 text-blue-800 border border-blue-300'
    ];

    $style = $styles[$type] ?? $styles['info'];

    echo "
    <div id='flash-alert' 
         class='fixed top-5 left-1/2 transform -translate-x-1/2 z-50 p-4 rounded-lg shadow-md flex items-start justify-between gap-4 min-w-[250px] max-w-sm $style opacity-100 transition-opacity duration-500'>
        <span>$message</span>
        <button onclick=\"closeFlashAlert()\" class='text-xl leading-none font-bold'>&times;</button>
    </div>

    <script>
        function closeFlashAlert() {
            const alert = document.getElementById('flash-alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 500);
            }
        }

        setTimeout(closeFlashAlert, 5000);
    </script>
    ";

    // Remove flash so it doesn't show again
    unset($_SESSION['flash']);
}
?>
