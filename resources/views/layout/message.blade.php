@section('message')
    

    @if (session('success_message'))
        <p class="success_message">
            {{ session('success_message') }}
        </p>
    @endif

    @if (session('error_message'))
        <p class="error_message">
            {{ session('error_message') }}
        </p>
    @endif

    @foreach ($errors->all() as $error)
        <p class="error_message">{{ $error }}</p>
    @endforeach

    @if (!empty($error_array))
        @foreach($error_array as $error)
            <p class="error_message">
                {{$error}}
            </p>
        @endforeach
    @endif

@show

