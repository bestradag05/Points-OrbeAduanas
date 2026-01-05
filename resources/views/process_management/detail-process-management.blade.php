@extends('home')

@section('content_header')
    <div class="d-flex justify-content-center">
        <h2 class="text-uppercase">Detalle del proceso <span
                class="text-indigo">{{ $process->commercialQuote->nro_quote_commercial }}</span></h2>

    </div>

@stop

@section('dinamic-content')
    <div class="mb-5 p-4">
        <div id="stepperProcess" class="bs-stepper linear">
            <div class="bs-stepper-header" id="stepper-header" role="tablist"></div>
            <div class="bs-stepper-content" id="stepper-content"></div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        const services = @json($services);

        document.addEventListener('DOMContentLoaded', () => {
            // Cargar el contenido del primer paso automáticamente
            loadStepContent(Object.keys(services)[0], 0);
        });

        const stepperHeader = document.querySelector('#stepper-header');
        const stepperContent = document.querySelector('#stepper-content');

        function createSteps() {
            Object.keys(services).forEach((key, index) => {
                // Crear el header (botón de paso)
                const step = document.createElement('div');
                const stepLine = document.createElement('div');
                stepLine.classList.add('bs-stepper-line');
                step.classList.add('step');
                step.setAttribute('data-target', `#step-${key}`);
                step.innerHTML = `
                <button class="step-trigger" type="button" role="tab" aria-controls="step-${key}">
                    <span class="bs-stepper-circle">${index + 1}</span>
                    <span class="bs-stepper-label">${key.charAt(0).toUpperCase() + key.slice(1)}</span>
                </button>
                `;
                stepperHeader.appendChild(step);
                if (index < Object.keys(services).length - 1) {
                    stepperHeader.appendChild(stepLine);
                }

                // Crear el contenido de cada paso
                const content = document.createElement('div');
                content.id = `step-${key}`;
                content.classList.add('content');
                content.setAttribute('role', 'tabpanel');
                content.innerHTML = `<p>Cargando contenido...</p>`; // Mensaje de carga
                stepperContent.appendChild(content);

                const nextButton = document.createElement('button');
                nextButton.type = 'button';
                nextButton.classList.add('btn', 'btn-primary');
                nextButton.id = `next-to-step-${index + 1}`;
                nextButton.innerText = 'Siguiente';

                // Si el estado del servicio no es "Concluido", deshabilitar el botón

                if (services[key].state !== 'Concluido') {
                    nextButton.disabled = true; // Deshabilitar el botón
                }

                content.appendChild(nextButton);

            });
        }

        // Crear los pasos cuando cargue la página
        createSteps();

        // Inicializar el stepper
        const stepper = new Stepper(document.querySelector('#stepperProcess'));

        const loadedSteps = {};

        // Función para cargar el contenido del paso dinámicamente
        function loadStepContent(step, stepIndex) {
            // Verificamos si el paso ya ha sido cargado
            if (loadedSteps[step]) {
                console.log(`${step} ya está cargado`);
                stepper.to(stepIndex + 1); // Avanzamos automáticamente al siguiente paso
                return; // Si el contenido ya está cargado, no hacemos nada
            }

            const serviceId = services[step].id;
            // Hacer la solicitud para cargar el contenido
            axios.get(`/step-content/${step}`, {
                    params: {
                        id: serviceId
                    }
                })
                .then(response => {
                    const contentDiv = document.querySelector(`#step-${step}`);

                    // Mantenemos el contenido original (botón de siguiente)
                    const nextButton = contentDiv.querySelector('.btn-primary');

                    // Solo actualizamos el contenido dentro del paso, manteniendo el botón
                    contentDiv.innerHTML = response.data;
                    // Restaurar el botón "Siguiente"
                    contentDiv.appendChild(nextButton);

                    // Marcar que el contenido de este paso ya fue cargado
                    loadedSteps[step] = true;

                    executeDynamicScripts(contentDiv);

                    // Después de cargar el contenido, avanzamos al siguiente paso
                    stepper.to(stepIndex + 1); // Avanzamos al siguiente paso
                })
                .catch(error => {
                    console.error('Error al cargar el contenido del paso:', error);
                });
        }

        Object.keys(services).forEach((key, index) => {
            const nextButton = document.querySelector(`#next-to-step-${index + 1}`);

            nextButton.addEventListener('click', () => {
                // Cargar el contenido del paso a medida que avanzamos
                loadStepContent(key, index);
                stepper.next(); // Asegurarse de que el stepper avance
            });
        });

        stepper._element.addEventListener('shown.bs-stepper', (event) => {
            const stepIndex = event.detail.indexStep; // Obtén el índice del paso actual
            const step = Object.keys(services)[stepIndex]; // Obtén el nombre del paso actual

            // Si el paso no ha sido cargado, lo cargamos dinámicamente
            if (!loadedSteps[step]) {
                loadStepContent(step, stepIndex);
            }
        });


        function executeDynamicScripts(contentDiv) {
            // Encuentra todos los <script> dentro del contenido cargado
            const scripts = contentDiv.querySelectorAll('script');
            scripts.forEach(script => {
                // Crear un nuevo tag <script> y agregarlo al DOM
                const newScript = document.createElement('script');
                newScript.textContent = script.textContent;
                document.body.appendChild(newScript); // O appendChild en un lugar adecuado
            });
        }
    </script>
@endpush
