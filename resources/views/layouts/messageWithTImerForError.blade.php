@if(session('success'))
    <div class="successMessage bg-lime-800 border border-lime-800 text-white px-4 py-3 rounded relative mt-2 mb-2">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="errorMessageWithTimer bg-red-900 border border-red-900 text-white px-4 py-3 rounded relative mt-2 mb-2">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
