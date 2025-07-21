 <div class="modal fade" id="modalJustification" tabindex="-1" aria-labelledby="modalJustificationLabel" aria-hidden="true">
     <div class="modal-dialog">
         <form id="formModalJustification" method="POST">
             @csrf
             <div class="modal-content">
                 <div id="headerModalJustification" class="modal-header bg-primary text-white">
                     <h5 class="modal-title" id="modalJustificationLabel">Justificar aceptación</h5>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="justification" class="form-label">Explique el motivo:</label>
                         <textarea id="justification" name="justification" class="form-control" rows="3"></textarea>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                     <button id="btnJustification" type="submit" class="btn btn-primary">Aceptar respuesta</button>
                 </div>
             </div>
         </form>
     </div>
 </div>


 @push('scripts')
     <script>
         function openModalJustification(action, route) {

             if (action === 'accept') {

                 $('#modalJustificationLabel').text('Justificar aceptación');
                 $('#headerModalJustification').addClass('bg-primary').removeClass('bg-danger');
                 $('#btnJustification').text('Aceptar respuesta');
                 $('#btnJustification').addClass('btn-primary').removeClass('btn-danger');
                 const justification = $('#justification')

                 // Mostrar el modal de justificación
                 justification.removeClass('is-invalid');
                 hideError(justification[0]);
                 $('#modalJustification').modal('show');

                 $('#formModalJustification').attr('action', route);

             } else {
                 $('#modalJustificationLabel').text('Justificar rechazo');
                 $('#headerModalJustification').addClass('bg-danger').removeClass('bg-primary');
                 $('#btnJustification').text('Rechazar respuesta');
                 $('#btnJustification').addClass('btn-danger').removeClass('btn-primary');

                 const justification = $('#justification')

                 // Mostrar el modal de justificación
                 justification.removeClass('is-invalid');
                 hideError(justification[0]);
                 $('#modalJustification').modal('show');

                 $('#formModalJustification').attr('action',route);

             }

         }
     </script>
 @endpush
