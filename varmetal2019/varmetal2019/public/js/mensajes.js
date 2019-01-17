const MSG_ERROR = "error";
const MSG_SUCCESS = "success";
const MSG_WARNING = "warning";
const MSG_INFO = "info";
const MSG_QUESTION = "question";

function showMensajeBanner(type, msg){
  $.notify(msg, type);
}

function confirmMensajeSwal(type, msg, metodo) {
  swal({
    title: "Confirmación",
    text: msg,
    type: type,
    showCancelButton: true,
    confirmButtonColor: "#6A9944",
    confirmButtonText: "Si",
    cancelButtonText: "No",
    cancelButtonColor: "#d71e1e",
  }).then((result) => {
    if (result.value) {
      metodo();
    }
  });
}

function showMensajeSwall(type, msg)
{
  swal({
    type: type,
    title: msg,
    showCancelButton: true,
    showConfirmButton: false,
    cancelButtonText:
      'Ok <i class="fas fa-times"></i>',
    cancelButtonAriaLabel: 'Cerrar',
    cancelButtonColor: '#661414',
  });

}
