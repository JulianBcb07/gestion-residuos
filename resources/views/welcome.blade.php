{{-- Extendimos la plantilla app layout para que se muestre al ingresar a la app --}}
<x-app-layout>
    
    {{-- class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" / esta clase hace que todo el contenedor se centre --}}
    <Section class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="text-center">
            <x-application-mark class="w-60 mx-auto"/>
            <h1 class="text-5xl font-semibold mt-4">Sistema de monitoreo de Residuos Sólidos Institucionales del TECNM campus Valladolid</h1>
        </div>
    </Section>
</x-app-layout>
