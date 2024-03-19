document.addEventListener("DOMContentLoaded", function () {
    //obtenemos el select de documentos para posterior agregarle un evento
    const document_select = document.getElementById("documento_identidad");
    // Agregamos el evento onchange al select
    document_select.addEventListener("change", (e) => {
        $(`#${e.target.value}`).removeClass("d-none");
        $(`#${e.target.value}`).addClass("d-block");
        //ocultamos las demas inputs que no sean el seleccionado
        const divs = $(`#${e.target.value}`).siblings();
        divs.each((index, element) => {
            if (element.id !== "contain_select") {
                $(`#${element.id}`).addClass("d-none");
                $(`#${element.id}`).removeClass("d-block");
                let elemento = $(`#${element.id} input`);
                elemento.val('');
            }
        });
    });


    // Previsualizar imagen del usuario

    $('#personal_file').change(function (e) {
        readURL(this);
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_img').attr('src', e.target.result);
                $('#preview_img').addClass('d-block');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    
});
