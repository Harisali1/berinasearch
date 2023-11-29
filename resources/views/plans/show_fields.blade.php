<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $plan->id }}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $plan->title }}</p>
</div>

<!-- Limit Field -->
<div class="form-group">
    {!! Form::label('limit', 'Limit:') !!}
    <p>{{ $plan->limit }}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $plan->price }}</p>
</div>

<!-- No Of Listing Field -->
<div class="form-group">
    {!! Form::label('no_of_listing', 'No Of Listing:') !!}
    <p>{{ $plan->no_of_listing }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $plan->description }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $plan->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $plan->updated_at }}</p>
</div>

