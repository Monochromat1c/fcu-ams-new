@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Select Assets to Lease</h1>
            <div></div>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <form action="{{ route('lease.create.form.add') }}" method="POST">
                @csrf
                <div class="overflow-x-auto overflow-y-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    ID
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Asset Name
                                </th>
                                <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Cost
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Supplier
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Site
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Category
                                </th>
                                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                    Condition
                                </th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <td class="border border-slate-300 px-4 py-2">
                                        <input type="checkbox" name="selected_assets[]" value="{{ $asset->id }}" />
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->id }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_name }}</td>
                                    <!-- <td class="border border-slate-300 px-4 py-2">{{ $asset->cost }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->supplier_name }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->site_name }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->category_name }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $asset->condition_name }}</td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end mt-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Next
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('selected_assets[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>