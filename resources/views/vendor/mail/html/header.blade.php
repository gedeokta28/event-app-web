@props(['url'])
<tr>
    <td class="header">
        <a href="#" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ asset('assets/images/logo-pas.png') }}" class="logo hide-logo-bg" alt="PAS Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
