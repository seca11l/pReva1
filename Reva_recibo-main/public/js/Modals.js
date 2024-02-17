//Modal Etiqueta
//-----------------Pdf-------------------------
function openPdfModal(pdfUrl) {
    $('#pdfModal').modal('show');
    $('#pdfIframe').attr('src', pdfUrl);
}
//-----------------crear etiqueta-------------------------


//hacer que el boton de cerrar pdf "x" funcione
function closePdfModal() {
    $('#pdfModal').modal('hide');
}
function closecreateTagsModal() {
    $('#closecreateTagsModal').modal('hide');
}



function closeCreatePulpoModal() {
    $('#createPulpoModal').modal('hide');
}
