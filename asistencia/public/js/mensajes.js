const MSG_ERROR = "error";
const MSG_SUCCESS = "success";
const MSG_WARNING = "warning";
const MSG_INFO = "info";
const MSG_QUESTION = "question";

const BTN_ERROR = 'Ok <i class="far fa-window-close"></i>';
const BTN_SUCCESS = 'Ok <i class="fas fa-check-circle"></i>';
const BTN_OK = 'Ok';

const COLOR_SUCCESS = '#10c916';
const COLOR_ERROR = '#ff0000';
const COLOR_WARNING = '#fffa00';
const COLOR_INFO = '#1f5354';


function showMensajeBanner(type, msg){
  $.notify(msg, type);
}

function confirmMensajeSwal(type, msg, e) {
  swal({
    title: "Confirmación",
    text: msg,
    type: type,
    showCancelButton: true,
    confirmButtonColor: "#10c916",
    confirmButtonText: "Si",
    cancelButtonText: "No",
    cancelButtonColor: "#ff0000",
  }).then((result) => {
    if (result.value) {
      swal({
          title: 'Espera un momento!',
          text: 'Trabajando tu solicitud..',
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          onOpen: () => {
              swal.showLoading()
          }
        });
      $(e.currentTarget).trigger(e.type, { 'send': true });
    }
  });
}

function showMensajeSwall(type, button_text, color_btn, msg)
{
  swal({
    type: type,
    title: msg,
    showCancelButton: true,
    showConfirmButton: false,
    cancelButtonText:
      button_text,
    cancelButtonColor: color_btn,
  });

}
