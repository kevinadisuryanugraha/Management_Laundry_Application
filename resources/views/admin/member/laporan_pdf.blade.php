<table style="width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 12px;">
    <thead>
        <tr style="background-color: #4CAF50; color: white; text-align: center;">
            <th style="padding: 8px; border: 1px solid #ddd;">No</th>
            <th style="padding: 8px; border: 1px solid #ddd;">No Member</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Nama</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Email</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Tanggal Bergabung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($members as $item)
            <tr style="text-align: center; @if ($loop->even) background-color: #f2f2f2; @endif">
                <td style="padding: 6px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                <td style="padding: 6px; border: 1px solid #ddd;">{{ $item->nomor_member }}</td>
                <td style="padding: 6px; border: 1px solid #ddd; text-align: left;">{{ $item->nama_member }}</td>
                <td style="padding: 6px; border: 1px solid #ddd; text-align: left;">{{ $item->email }}</td>
                <td style="padding: 6px; border: 1px solid #ddd;">{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
