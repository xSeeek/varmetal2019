const MSG_ERROR = "E";
const MSG_SUCCESS = "S";
const MSG_WARNING = "W";

function showMensajeBanner(type, msg) {
  switch (type) {
    case MSG_ERROR:
      $.notify(msg, "error");
      break;
    case MSG_SUCCESS:
      $.notify(msg, "success")
      break;
    default:

  }
}

function showMensajeSwall(type, msg) {
  switch (type) {
    case MSG_ERROR:
      swal({
        type: 'error',
        title: msg,
        showCancelButton: true,
        showConfirmButton: false,
        cancelButtonText:
          'Ok <i class="fas fa-times"></i>',
        cancelButtonAriaLabel: 'Cerrar',
        cancelButtonColor: '#661414',
      });
      break;
    case MSG_SUCCESS:
      swal({
        position: 'top-end',
        type: 'success',
        title: msg,
        showConfirmButton: false,
        timer: 1500
      });
      break;
    default:

  }
}
