@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'gestion_de_residuos')
<img src="https://th.bing.com/th/id/R.db95f551b85d3243742a69b56b97331f?rik=JocEYz71QEV1sA&riu=http%3a%2f%2fyucataninnovador.org%2fsiiesweb%2fwp-content%2fuploads%2f2018%2f06%2fitsva.png&ehk=6cyzK9vML7B%2bR6l6avfdLat4%2bkLSrMrXGmW9REWwF7U%3d&risl=&pid=ImgRaw&r=0" class="logo" alt="ITSVA Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
