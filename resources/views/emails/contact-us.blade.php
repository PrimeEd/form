@extends("layouts.mail-v1")

@section('content')
    <div>
        New form submit!
        <hr>
        <table border="1">
            <tr>
                <td width="150" style="padding: 2px;">Name</td>
                <td style="padding: 2px;">
                    {{ $data['name'] }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Email</td>
                <td style="padding: 2px;">
                    {{ $data['email'] }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Nationality</td>
                <td style="padding: 2px;">
                    {{ $data['nationality']->name ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Are you?</td>
                <td style="padding: 2px;">
                    {{ ucwords(str_replace('_', ' ', $data['are-you'])) }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Title</td>
                <td style="padding: 2px;">
                    {{ $data['title'] }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Story</td>
                <td style="padding: 2px;">
                    @foreach (explode("\n", $data['story']) as $line)
                        {{ $line }}<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Permissions?</td>
                <td style="padding: 2px;">
                    {{ $data['accept'] == '1' ? 'Yes' : 'No' }}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 2px;">Files</td>
                <td>
                    @foreach ($files as $line)
                        <a href="{{ $line }}" target="_blank">{{ $line }}</a><br>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
@endsection
