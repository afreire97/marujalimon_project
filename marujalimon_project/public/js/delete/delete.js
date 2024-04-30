function confirmDelete() {
    Swal.fire({
        title: '¿Estás seguro de que deseas eliminar a este coordinador?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar',
        focusCancel: true, // Foco en el botón de cancelar
        customClass: {
            confirmButton: 'swal-confirm-btn',
            cancelButton: 'swal-cancel-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                '¡Eliminado!',
                'El coordinador ha sido eliminado.',
                'success'
            ).then(() => {
                // Enviar el formulario después de mostrar el mensaje de éxito
                document.getElementById('deleteForm').submit();
            });
        }
    })
}
