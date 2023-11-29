<div class="table-responsive-sm">
    <table class="table table-striped" id="listings-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type Id</th>
            <th>No Of Room</th>
            <th>Price</th>
            <th>Image</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($listings as $listing)
            <tr>
                <td>{{ $listing->title }}</td>
                <td>{{ $listing->type_id }}</td>
                <td>{{ $listing->no_of_room }}</td>
                <td>{{ $listing->price }}</td>
                <td><img src="{{ $listing->image }}" style="height: 50px; width: 50px"></td>
                <td>
                    {!! Form::open(['route' => ['listings.destroy', $listing->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('listings.show', [$listing->id]) }}" class='btn btn-ghost-success'><i
                                class="fa fa-eye"></i></a>
                        <a href="{{ route('listings.edit', [$listing->id]) }}" class='btn btn-ghost-info'><i
                                class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
