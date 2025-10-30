import './bootstrap';

// Apresentar e ocultar a senha e substituir o ícone
window.togglePassword = function(fieldId, toggleIcon){
    const field = document.getElementById(fieldId);
    const icon = toggleIcon.querySelector('i');

    if(field.type === "password"){
        field.type = "text";
        icon.classList.remove('bi', 'bi-lock');
        icon.classList.add('bi', 'bi-unlock')
    } else {
        field.type = "password";
        icon.classList.remove('bi', 'bi-unlock');
        icon.classList.add('bi', 'bi-lock')
    }
}

window.confirmDelete = function (id) {
    Swal.fire({
        title: "Tem certeza?",
        text: "Essa ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
