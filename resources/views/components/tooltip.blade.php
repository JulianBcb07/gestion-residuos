<div class="icon-container relative">
    <a tabindex="0" role="link" aria-label="tooltip 2"
        class="focus:outline-none focus:ring-gray-300 rounded-full focus:ring-offset-2 focus:ring-2 focus:bg-gray-200"
        onmouseover="showTooltip(2)" onfocus="showTooltip(2)" onmouseout="hideTooltip(2)">
        <div class="cursor-pointer">
            <svg aria-haspopup="true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#A0AEC0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <circle cx="12" cy="12" r="9" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
                <polyline points="11 12 12 12 12 16 13 16" />
            </svg>
        </div>
    </a>

    <!-- Tooltip -->
    <div id="tooltip2" role="tooltip" class="z-20 shadow-lg bg-blue-700 p-4 rounded mt-2">
        <!-- Pestañita (flecha) en la parte superior izquierda ajustada -->
        <svg class="absolute top-[20px] left-[3px]" width="18px" height="13px" viewBox="0 0 9 9">
            <polygon points="4.5,0 9,9 0,9" fill="rgb(29 78 216)"></polygon>
        </svg>
        <p class="text-sm font-bold text-white pb-1">{{ $attributes->get('title', 'Información de ayuda') }}</p>
        <p class="text-sm leading-4 text-white pb-3">{{ $attributes->get('message', 'Es importante que verifique correctamente la fecha de registro de inicio y fin de la semana ya que este no es modificable más adelante.') }}</p>
    </div>
</div>


<script>
    function showTooltip(flag) {
        switch (flag) {
            case 1:
                document.getElementById("tooltip1").classList.remove("hidden");
                break;
            case 2:
                document.getElementById("tooltip2").classList.remove("hidden");
                break;
            case 3:
                document.getElementById("tooltip3").classList.remove("hidden");
                break;
        }
    }

    function hideTooltip(flag) {
        switch (flag) {
            case 1:
                document.getElementById("tooltip1").classList.add("hidden");
                break;
            case 2:
                document.getElementById("tooltip2").classList.add("hidden");
                break;
            case 3:
                document.getElementById("tooltip3").classList.add("hidden");
                break;
        }
    }
</script>
