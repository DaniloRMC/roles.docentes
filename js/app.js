document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-tarea');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const descripcion = document.getElementById('descripcion').value;
            fetch('agregar_tarea.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'descripcion=' + encodeURIComponent(descripcion)
            })
            .then(res => res.text())
            .then(() => location.reload());
        });
    }
    document.querySelectorAll('.eliminar-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch('eliminar_tarea.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(res => res.text())
            .then(() => location.reload());
        });
    });
    document.querySelectorAll('.marcar-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch('marcar_tarea.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(res => res.text())
            .then(() => location.reload());
        });
    });
});
