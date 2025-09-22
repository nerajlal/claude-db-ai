@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Upload DB -->
    <div class="p-3 bg-light border fixed-top">
        <form method="POST" action="{{ route('upload.db') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="db_file" required>
            <button class="btn btn-primary">Upload DB</button>
        </form>
    </div>

    <div class="pt-5 mt-5">
        <!-- Chat Query -->
        <form method="POST" action="{{ route('query.process') }}">
            @csrf
            <div class="mb-3">
                <label>User Question</label>
                <input type="text" name="user_query" class="form-control" placeholder="Ask about your DB...">
            </div>

            <!-- Editable SQL -->
            @if(isset($sql))
            <div class="mb-3">
                <label>Generated SQL (Editable)</label>
                <textarea name="sql" class="form-control" rows="4">{{ $sql }}</textarea>
            </div>
            @endif

            <button class="btn btn-success">Run Query</button>
        </form>

        <!-- Output Dropdown -->
        @if(isset($results))
        <div class="mt-4">
            <button class="btn btn-info" onclick="toggleOutput()">Show Output ▼</button>

            <div id="output-block" class="mt-3 d-none">
                <h5>Query Results</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach(array_keys((array) $results[0]) as $col)
                                <th>{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $row)
                            <tr>
                                @foreach((array) $row as $val)
                                    <td>{{ $val }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function toggleOutput() {
    document.getElementById('output-block').classList.toggle('d-none');
}
</script>
@endsection
