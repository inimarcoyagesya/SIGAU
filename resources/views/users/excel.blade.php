<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
    <thead>
    <tr>
        <th style="<?php echo 'padding: 12px; background: #10B981; /* Green 500 */
            background: linear-gradient(to right, #10B981, #2563EB);
            color: white; font-weight: bold; text-align: left; border: 1px solid #0E9F6E;' ?>">Name</th>
        <th style="<?php echo 'padding: 12px; background: #10B981;
            background: linear-gradient(to right, #10B981, #2563EB);
            color: white; font-weight: bold; text-align: left; border: 1px solid #0E9F6E;' ?>">Email</th>
        <th style="padding: 12px; background: #10B981;
            background: linear-gradient(to right, #10B981, #2563EB);
            color: white; font-weight: bold; text-align: left; border: 1px solid #0E9F6E;">Role</th>
        <th style="padding: 12px; background: #10B981;
            background: linear-gradient(to right, #10B981, #2563EB);
            color: white; font-weight: bold; text-align: left; border: 1px solid #0E9F6E;">Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $p)
        <tr>
            <td style="padding: 10px; border: 1px solid #E5E7EB; color: #374151; background-color: {{ $loop->even ? '#F9FAFB' : '#FFFFFF' }};">{{ $p->name }}</td>
            <td style="padding: 10px; border: 1px solid #E5E7EB; color: #374151; background-color: {{ $loop->even ? '#F9FAFB' : '#FFFFFF' }};">{{ $p->email }}</td>
            <td style="padding: 10px; border: 1px solid #E5E7EB; color: #374151; background-color: {{ $loop->even ? '#F9FAFB' : '#FFFFFF' }};">{{ $p->role }}</td>
            <td style="padding: 10px; border: 1px solid #E5E7EB; color: #374151; background-color: {{ $loop->even ? '#F9FAFB' : '#FFFFFF' }};">{{ $p->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>