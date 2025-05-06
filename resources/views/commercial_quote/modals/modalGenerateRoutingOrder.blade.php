{{-- Commercial Fill Data --}}
<x-adminlte-modal id="generateRoutingOrder" class="modal" title="Complete la informacion para generar el routing"
    size='lg' scrollable>
    <form action="/freight/routing" method="POST" id="formgenerateRoutingOrder">
        @csrf

        <input type="hidden" name="id_freight" value="{{ $comercialQuote->freight->id }}">

        <div class="row">

            <div class="col-12 ">
                <div class="form-group">
                    <label for="wr_loading">WR Loading</label>

                    <textarea class="form-control" id="wr_loading" name="wr_loading" placeholder="Ingrese el numero de seguimiento"></textarea>

                </div>

            </div>


        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="btn btn-indigo" type="submit" onclick="submitGenerateRoutingOrder(this)"
                label="Generar" />
            <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
        </x-slot>

    </form>
</x-adminlte-modal>
