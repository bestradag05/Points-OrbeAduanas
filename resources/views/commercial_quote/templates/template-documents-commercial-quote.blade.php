<div class="accordion" id="accordionExample">
    @foreach ($folders as $folder)
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-indigo text-left" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $loop->iteration }}" aria-expanded="true"
                        aria-controls="collapse{{ $loop->iteration }}">
                        {{ $folder['folder'] }}
                    </button>
                </h2>
            </div>

            <div id="collapse{{ $loop->iteration }}" class="collapse" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        @foreach ($folder['files'] as $file)
                            <li>
                                <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
