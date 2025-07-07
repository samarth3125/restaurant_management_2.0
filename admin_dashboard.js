document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.dashboard-btn');
    buttons.forEach(btn => {
        btn.addEventListener('mousedown', function() {
            btn.style.transform = 'scale(0.96)';
        });
        btn.addEventListener('mouseup', function() {
            btn.style.transform = 'scale(1)';
        });
        btn.addEventListener('mouseleave', function() {
            btn.style.transform = 'scale(1)';
        });
    });
});