<div class="table-responsive-sm">
    <table class="table table-striped" id="plans-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Limit</th>
        <th>Price</th>
        <th>No Of Listing</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($plans as $plan)
            <tr>
                <td>{{ $plan->title }}</td>
            <td>{{ $plan->limit }}</td>
            <td>{{ $plan->price }}</td>
            <td>{{ $plan->no_of_listing }}</td>
                <td>
                    {!! Form::open(['route' => ['plans.destroy', $plan->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('plans.show', [$plan->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('plans.edit', [$plan->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>