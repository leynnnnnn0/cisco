<table>
    <thead>
    <tr>
        <th>User Id</th>
        <th>Status</th>
        <th>Tag Time</th>
    </tr>
    </thead>
    <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->user_id }}</td>
                <td>{{ $tag->status }}</td>
                <td>{{ $tag->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
